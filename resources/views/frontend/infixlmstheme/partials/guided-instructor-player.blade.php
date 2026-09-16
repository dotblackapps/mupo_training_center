@php
    $guidedAudioDirectory = public_path("storage/instructor-audio/course-{$course->id}/lesson-{$lesson->id}");
    $guidedManifestPath = $guidedAudioDirectory . '/manifest.json';
    $guidedManifest = null;

    if (is_file($guidedManifestPath) && is_readable($guidedManifestPath)) {
        $decodedManifest = json_decode(file_get_contents($guidedManifestPath), true);
        if (is_array($decodedManifest) && !empty($decodedManifest['segments'])) {
            $guidedManifest = $decodedManifest;
        }
    }
@endphp

@if($guidedManifest)
    <section class="guided-instructor"
             id="guidedInstructorPlayer"
             data-course-id="{{ $course->id }}"
             data-lesson-id="{{ $lesson->id }}"
             data-user-id="{{ auth()->id() ?: 'guest' }}"
             aria-labelledby="guidedInstructorTitle">
        <div class="guided-instructor__header">
            <div class="guided-instructor__identity">
                <span class="guided-instructor__icon" aria-hidden="true"><i class="fas fa-headphones-alt"></i></span>
                <div>
                    <span class="guided-instructor__eyebrow">Learn with Instructor</span>
                    <h2 id="guidedInstructorTitle">{{ $guidedManifest['title'] ?? ($lesson->name . ' — Guided Lesson') }}</h2>
                </div>
            </div>
            <span class="guided-instructor__state" id="guidedInstructorState"><i></i> Ready</span>
        </div>

        <p class="guided-instructor__intro">
            {{ $guidedManifest['description'] ?? 'Listen to a guided explanation with practical examples and important takeaways.' }}
        </p>

        <div class="guided-instructor__now" aria-live="polite">
            <span>Now explaining</span>
            <strong id="guidedCurrentSegment">{{ $guidedManifest['segments'][0]['title'] ?? 'Introduction' }}</strong>
        </div>

        <div class="guided-instructor__wave" aria-hidden="true">
            @for($bar = 0; $bar < 24; $bar++)<i></i>@endfor
        </div>

        <audio id="guidedInstructorAudio" preload="metadata"></audio>

        <div class="guided-instructor__timeline">
            <span id="guidedElapsed">00:00</span>
            <input id="guidedSeek" type="range" min="0" max="1000" value="0" aria-label="Guided lesson position">
            <span id="guidedDuration">00:00</span>
        </div>

        <div class="guided-instructor__controls">
            <button type="button" class="guided-control guided-control--seek" data-guided-seek="-10" aria-label="Rewind 10 seconds"><i class="fas fa-undo"></i><span>10 sec</span></button>
            <button type="button" class="guided-control guided-control--primary" id="guidedPlay" aria-label="Start guided lesson"><i class="fas fa-play"></i><span>Start Guided Lesson</span></button>
            <button type="button" class="guided-control guided-control--seek" data-guided-seek="10" aria-label="Forward 10 seconds"><i class="fas fa-redo"></i><span>10 sec</span></button>
            <label class="guided-speed" for="guidedSpeed"><span>Speed</span><select id="guidedSpeed" aria-label="Playback speed"><option value="0.75">0.75×</option><option value="1" selected>1×</option><option value="1.25">1.25×</option><option value="1.5">1.5×</option></select></label>
            <button type="button" class="guided-control guided-control--mute" id="guidedMute" aria-label="Mute guided lesson"><i class="fas fa-volume-up"></i></button>
        </div>

        <div class="guided-instructor__resume" id="guidedResume" hidden>
            <p>You previously stopped at <strong id="guidedResumeTime">00:00</strong>.</p>
            <div><button type="button" data-resume-action="resume">Resume</button><button type="button" data-resume-action="restart">Start Again</button></div>
        </div>

        <button type="button" class="guided-transcript-toggle" id="guidedTranscriptToggle" aria-expanded="false" aria-controls="guidedTranscript"><i class="far fa-file-alt"></i> Transcript <i class="fas fa-chevron-down"></i></button>
        <div class="guided-transcript" id="guidedTranscript" hidden>
            @foreach($guidedManifest['segments'] as $index => $segment)
                <article class="guided-transcript__segment" data-guided-segment="{{ $index }}" data-section-id="{{ $segment['section_id'] ?? $segment['id'] ?? '' }}">
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div><h3>{{ $segment['title'] ?? 'Lesson segment' }}</h3><p>{{ $segment['transcript'] ?? $segment['text'] ?? '' }}</p></div>
                </article>
            @endforeach
        </div>

        <script type="application/json" id="guidedInstructorManifest">{!! json_encode(array_merge($guidedManifest, [
            'base_url' => asset("storage/instructor-audio/course-{$course->id}/lesson-{$lesson->id}"),
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    </section>
@endif
