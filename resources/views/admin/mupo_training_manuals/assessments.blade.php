@extends('backend.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row"><div class="col-lg-12"><div class="main-title"><h3 class="mb-20">MUPO Manual Assessment Submissions</h3></div></div></div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="white-box">
            <p class="mb-3">Sections B and C are kept as written/manual assessments because the source examination packs require short answers, structured responses and applied scenarios.</p>
            <div class="table-responsive">
                <table class="table Crm_table_active3">
                    <thead><tr><th>Learner</th><th>Course</th><th>Section</th><th>Status</th><th>Score</th><th>Updated</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse($submissions as $submission)
                        @php $courseTitle = json_decode($submission->course_title ?? '', true)['en'] ?? ($submission->course_title ?? 'MUPO Training'); @endphp
                        <tr>
                            <td>{{ $submission->learner_name }}<br><small>{{ $submission->learner_email }}</small></td>
                            <td>{{ $courseTitle }}</td>
                            <td>{{ $submission->section_code }} — {{ $submission->assessment_title }}</td>
                            <td>{{ ucfirst($submission->status) }}</td>
                            <td>{{ $submission->total_score !== null ? $submission->total_score.' / '.$submission->total_marks : '—' }}</td>
                            <td>{{ $submission->updated_at }}</td>
                            <td><a class="primary-btn small fix-gr-bg" href="{{ route('admin.mupo-assessments.show', $submission->id) }}">Review / Mark</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No manual assessment submissions yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
