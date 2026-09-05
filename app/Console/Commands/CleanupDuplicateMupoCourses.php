<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\ManagesMupoCourseData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

/**
 * One-off, safe cleanup for MUPO courses that were duplicated by earlier
 * (pre-fix) runs of `mupo:import-training-manuals`.
 *
 * This command NEVER touches any course outside the "MUPO Security
 * Training" category, and within that category it only ever acts on rows
 * whose (normalized) title matches one of the two canonical MUPO course
 * titles read from database/seeders/data/mupo_training_content.json. Any
 * other course — including any other course an instructor may have placed
 * in the same category — is left completely alone.
 *
 * For each canonical course it keeps exactly one row (preferring the one
 * whose slug already matches the current data file, then falling back to
 * the oldest/most-complete duplicate) and removes the others, along with
 * their chapters, lessons, quiz questions/options and controlled documents,
 * so nothing is left orphaned.
 */
class CleanupDuplicateMupoCourses extends Command
{
    use ManagesMupoCourseData;

    protected $signature = 'mupo:cleanup-duplicate-courses
        {--dry-run : Report what would change without deleting anything}
        {--force : Actually perform the deletion (required unless --dry-run is used)}';

    protected $description = 'Safely remove duplicate MUPO-imported courses left over from earlier import runs, without touching any other course.';

    public function handle(): int
    {
        $dataFile = database_path('seeders/data/mupo_training_content.json');
        if (!File::exists($dataFile)) {
            $this->error('Training content data file is missing: '.$dataFile);
            return self::FAILURE;
        }

        $payload = json_decode(File::get($dataFile), true);
        $canonical = collect($payload['courses'] ?? [])->map(function ($course) {
            return [
                'slug' => $course['slug'],
                'title' => $course['title'],
                'normalized_title' => $this->normalizeTitle($course['title']),
            ];
        });

        if ($canonical->isEmpty()) {
            $this->error('No canonical MUPO course definitions found in the training content data file.');
            return self::FAILURE;
        }

        $category = DB::table('categories')->where('title', 'MUPO Security Training')->first();
        if (!$category) {
            $this->info('No "MUPO Security Training" category found — nothing to clean up.');
            return self::SUCCESS;
        }

        $dryRun = (bool) $this->option('dry-run');
        if (!$dryRun && !$this->option('force')) {
            $this->error('Refusing to delete anything without --force (or use --dry-run to preview).');
            return self::FAILURE;
        }

        $coursesInCategory = DB::table('courses')->where('category_id', $category->id)->get();

        $totalRemoved = 0;

        foreach ($canonical as $definition) {
            $matches = $coursesInCategory->filter(function ($course) use ($definition) {
                return $this->normalizeTitle($this->decodeTitle($course->title)) === $definition['normalized_title'];
            })->values();

            if ($matches->count() <= 1) {
                $this->line("[ok] \"{$definition['title']}\": ".$matches->count()." row(s), nothing to do.");
                continue;
            }

            // Prefer the row whose slug already matches the current data
            // file. If none does (e.g. every duplicate has a stale slug),
            // fall back to the row with the most imported content, then the
            // oldest row, as the one to keep.
            $keeper = $matches->firstWhere('slug', $definition['slug']);
            if (!$keeper) {
                $keeper = $matches
                    ->sortByDesc(function ($course) {
                        return DB::table('lessons')->where('course_id', $course->id)->count();
                    })
                    ->sortBy('id')
                    ->first();
            }

            $duplicates = $matches->reject(fn ($course) => $course->id === $keeper->id);

            $this->warn("\"{$definition['title']}\": found {$matches->count()} rows — keeping course id {$keeper->id} (slug: {$keeper->slug}), removing ".$duplicates->count().' duplicate(s).');

            foreach ($duplicates as $duplicate) {
                $lessonCount = DB::table('lessons')->where('course_id', $duplicate->id)->count();
                $chapterCount = DB::table('chapters')->where('course_id', $duplicate->id)->count();
                $enrollCount = DB::table('course_enrolleds')->where('course_id', $duplicate->id)->count();

                $this->line("  - duplicate course id {$duplicate->id} (slug: {$duplicate->slug}): {$chapterCount} chapter(s), {$lessonCount} lesson(s), {$enrollCount} enrollment(s).");

                if ($enrollCount > 0) {
                    $this->warn("    Skipping deletion of course id {$duplicate->id}: it has {$enrollCount} learner enrollment(s). Resolve this manually first.");
                    continue;
                }

                if ($dryRun) {
                    continue;
                }

                DB::transaction(function () use ($duplicate) {
                    $this->deleteCourseAndChildren((int) $duplicate->id);
                });

                $totalRemoved++;
            }
        }

        if (!$dryRun) {
            DB::table('categories')->where('id', $category->id)->update([
                'total_courses' => DB::table('courses')->where('category_id', $category->id)->where('type', 1)->count(),
                'updated_at' => now(),
            ]);
        }

        $this->newLine();
        if ($dryRun) {
            $this->info('Dry run complete — no data was changed.');
        } else {
            $this->info("Cleanup complete. Removed {$totalRemoved} duplicate course row(s).");
        }

        return self::SUCCESS;
    }

    private function normalizeTitle(string $title): string
    {
        return Str::of($title)->lower()->replaceMatches('/[^a-z0-9]+/', ' ')->trim()->__toString();
    }

    /**
     * Course titles are stored as a translatable JSON blob (e.g.
     * {"en":"National Key Point (NKP) Security Training"}). Decode the
     * English value when present, otherwise fall back to the raw value.
     */
    private function decodeTitle(?string $raw): string
    {
        if (!$raw) {
            return '';
        }

        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return $decoded['en'] ?? reset($decoded) ?: '';
        }

        return $raw;
    }
}
