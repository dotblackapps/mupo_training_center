<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\CourseSetting\Entities\Course;
use Modules\Setting\Entities\VersionHistory;

class FrontendHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }

    public function index()
    {
        try {
            if (!auth()->check()) {
                if (Settings('start_site') == 'loginpage') {
                    return redirect()->route('login');
                }
            }

            // MUPO FRONTEND:
            // Do not load the old Aora Page Builder homepage from front_pages/home2.
            // The uploaded database still contains the old InfixLMS homepage content,
            // so we force the Mupo Blade homepage here.
            $featuredCourses = Course::with(['category', 'courseLevel', 'user'])
                ->where('status', 1)
                ->where('type', 1)
                ->latest()
                ->take(6)
                ->get();

            return view(theme('pages.index'), compact('featuredCourses'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function test()
    {
        dd('ok');
    }

    public function version()
    {
        return VersionHistory::select('version', 'release_date')
            ->get()
            ->pluck('version', 'release_date')
            ->toArray();
    }
}