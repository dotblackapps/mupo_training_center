@extends('backend.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row"><div class="col-lg-12"><div class="main-title"><h3 class="mb-20">Mark MUPO Assessment</h3></div></div></div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

        <div class="white-box mb-20">
            @php $courseTitle = json_decode($submission->course_title ?? '', true)['en'] ?? ($submission->course_title ?? 'MUPO Training'); @endphp
            <h4>{{ $courseTitle }}</h4>
            <p><strong>Learner:</strong> {{ $submission->learner_name }} ({{ $submission->learner_email }})</p>
            <p><strong>Section {{ $submission->section_code }}:</strong> {{ $submission->assessment_title }} — {{ $submission->total_marks }} marks</p>
            <p><strong>Source:</strong> {{ $submission->source_document }}</p>
            <p><strong>Memorandum:</strong> {{ $submission->memorandum_document }}</p>
        </div>

        <form method="POST" action="{{ route('admin.mupo-assessments.grade', $submission->id) }}">
            @csrf
            @foreach($questions as $question)
                @php $parts = $question->parts_json ? json_decode($question->parts_json, true) : []; @endphp
                <div class="white-box mb-20">
                    <h4>Question {{ $question->question_number }} — {{ $question->marks }} marks</h4>
                    @if($question->title)<p><strong>{{ $question->title }}</strong></p>@endif
                    @if($question->scenario)<div class="alert alert-light">{{ $question->scenario }}</div>@endif
                    @if($question->question)<p>{{ $question->question }}</p>@endif
                    @if(!empty($parts))
                        <ol type="a">@foreach($parts as $part)<li>{{ $part['question'] ?? '' }} @if(isset($part['marks']))[{{ $part['marks'] }}]@endif</li>@endforeach</ol>
                    @endif
                    <hr>
                    <p><strong>Learner answer:</strong></p>
                    <div style="white-space:pre-wrap;border:1px solid #e1e5ea;padding:15px;border-radius:8px;min-height:80px">{{ $question->answer ?: 'No answer supplied.' }}</div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Score (max {{ $question->marks }})</label>
                            <input class="primary_input_field" type="number" step="0.5" min="0" max="{{ $question->marks }}" name="scores[{{ $question->id }}]" value="{{ $question->score ?? 0 }}" required>
                        </div>
                        <div class="col-md-9">
                            <label>Question feedback</label>
                            <textarea class="primary_input_field" name="answer_feedback[{{ $question->id }}]" rows="2">{{ $question->answer_feedback }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="white-box mb-20">
                <label>Overall assessor feedback</label>
                <textarea class="primary_input_field" name="feedback" rows="4">{{ $submission->feedback }}</textarea>
                <button type="submit" class="primary-btn fix-gr-bg mt-3">Save Final Mark</button>
            </div>
        </form>

        @if($submission->memorandum_text)
            <div class="white-box mb-20">
                <h4>Controlled Assessor Memorandum</h4>
                <p class="text-muted">Staff only. Do not expose this content to learner-facing pages.</p>
                <div style="white-space:pre-wrap;max-height:650px;overflow:auto;border:1px solid #e1e5ea;padding:15px;border-radius:8px">{{ $submission->memorandum_text }}</div>
            </div>
        @endif
    </div>
</section>
@endsection
