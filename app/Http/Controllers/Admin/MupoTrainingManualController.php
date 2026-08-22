<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MupoTrainingManualController extends Controller
{
    public function index()
    {
        $documents = DB::table('mupo_training_documents as d')
            ->leftJoin('courses as c','c.id','=','d.course_id')
            ->select('d.*','c.title as course_title')
            ->where('d.active',1)->orderBy('d.course_id')->orderBy('d.title')->get();
        return view('admin.mupo_training_manuals.index', compact('documents'));
    }

    public function download($id)
    {
        $document = DB::table('mupo_training_documents')->where('id',$id)->where('active',1)->firstOrFail();
        abort_unless(Storage::disk('local')->exists($document->storage_path), 404);
        return Storage::disk('local')->download($document->storage_path, $document->original_filename);
    }
}
