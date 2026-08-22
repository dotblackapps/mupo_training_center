@extends('backend.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row"><div class="col-lg-12"><div class="main-title"><h3 class="mb-20">MUPO Training Manuals & Controlled Documents</h3></div></div></div>
        <div class="white-box">
            <p class="mb-3">Learner manuals are embedded into course lessons. This library contains staff-only facilitator, assessor and controlled assessment source documents.</p>
            <div class="table-responsive">
                <table class="table Crm_table_active3">
                    <thead><tr><th>Course</th><th>Document</th><th>Type</th><th>Audience</th><th>Version</th><th>Action</th></tr></thead>
                    <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ json_decode($document->course_title, true)['en'] ?? $document->course_title ?? 'MUPO Training' }}</td>
                            <td>{{ $document->title }}</td><td>{{ $document->document_type }}</td><td>{{ ucfirst($document->audience) }}</td><td>{{ $document->version ?: '—' }}</td>
                            <td><a class="primary-btn small fix-gr-bg" href="{{ route('admin.mupo-training-manuals.download',$document->id) }}">Download</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
