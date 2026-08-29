@extends('frontend.infixlmstheme.layouts.mupo')

@section('title', 'Controlled Assessment')

@section('css')
<style>
.mupo-assessment-page{background:#f4f6f9;padding:48px 0 70px;min-height:70vh}.mupo-assessment-wrap{width:min(1100px,92%);margin:0 auto}.mupo-assessment-head{background:#0d1b2a;color:#fff;border-radius:16px;padding:28px 30px;margin-bottom:24px}.mupo-assessment-head h1{font-size:30px;margin:0 0 10px;color:#fff}.mupo-assessment-meta{display:flex;flex-wrap:wrap;gap:10px 18px;font-size:14px;opacity:.92}.mupo-assessment-card{background:#fff;border-radius:16px;padding:26px;margin-bottom:18px;box-shadow:0 8px 30px rgba(13,27,42,.08)}.mupo-assessment-card h2{font-size:21px;margin:0 0 12px;color:#0d1b2a}.mupo-question-label{font-weight:700;color:#b3132b;margin-bottom:8px}.mupo-question-text,.mupo-scenario{white-space:pre-line;color:#253449;line-height:1.7}.mupo-scenario{background:#f7f8fa;border-left:4px solid #b3132b;padding:14px 16px;border-radius:8px;margin:12px 0}.mupo-parts{padding-left:22px;margin-top:12px}.mupo-parts li{margin-bottom:9px}.mupo-answer{width:100%;min-height:170px;border:1px solid #ccd4dd;border-radius:10px;padding:14px;font:inherit;resize:vertical}.mupo-answer:focus{outline:none;border-color:#b3132b;box-shadow:0 0 0 3px rgba(179,19,43,.09)}.mupo-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:24px}.mupo-btn{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:9px;padding:12px 20px;font-weight:700;cursor:pointer;text-decoration:none}.mupo-btn-primary{background:#b3132b;color:#fff}.mupo-btn-secondary{background:#0d1b2a;color:#fff}.mupo-status{padding:14px 16px;border-radius:10px;margin-bottom:18px}.mupo-status-success{background:#e8f7ee;color:#176936}.mupo-status-info{background:#eaf2fb;color:#174a7e}.mupo-status-error{background:#fdecec;color:#9b1c1c}.mupo-marked{border-left:4px solid #198754}.mupo-score{font-size:24px;font-weight:800;color:#0d1b2a}.mupo-feedback{background:#f7f8fa;padding:14px;border-radius:10px;margin-top:12px}.mupo-readonly textarea{background:#f2f3f5;cursor:not-allowed}@media(max-width:700px){.mupo-assessment-head,.mupo-assessment-card{padding:20px}.mupo-assessment-head h1{font-size:24px}}
</style>
@endsection

@section('mainContent')
<section class="mupo-assessment-page">
    <div class="mupo-assessment-wrap">
        <div class="mupo-assessment-head">
            <h1>Section {{ $assessment->section_code }}: {{ $assessment->title }}</h1>
            <div class="mupo-assessment-meta">
                <span><strong>Course:</strong> {{ json_decode($course->title ?? '', true)['en'] ?? ($course->title ?? 'MUPO Training') }}</span>
                <span><strong>Total marks:</strong> {{ $assessment->total_marks }}</span>
                @if($assessment->duration_minutes)<span><strong>Assessment duration:</strong> {{ $assessment->duration_minutes }} minutes</span>@endif
                <span><strong>Marking:</strong> Manual assessor marking</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mupo-status mupo-status-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mupo-status mupo-status-error">{{ $errors->first() }}</div>
        @endif

        <div class="mupo-assessment-card">
            <h2>Assessment instructions</h2>
            <p>{{ $assessment->instruction ?: 'Answer every question clearly and completely.' }}</p>
            <p><strong>Controlled source:</strong> {{ $assessment->source_document }}</p>
            <p>The wording below is imported from the supplied MUPO examination pack. Answers are not automatically converted into multiple-choice questions.</p>
        </div>

        @if($submission && $submission->status === 'marked')
            <div class="mupo-assessment-card mupo-marked">
                <h2>Assessment result</h2>
                <div class="mupo-score">{{ rtrim(rtrim(number_format((float)$submission->total_score, 2, '.', ''), '0'), '.') }} / {{ $assessment->total_marks }}</div>
                @if($submission->feedback)<div class="mupo-feedback"><strong>Assessor feedback:</strong><br>{{ $submission->feedback }}</div>@endif
            </div>
        @elseif($submission && $submission->status === 'submitted')
            <div class="mupo-status mupo-status-info">Submitted {{ $submission->submitted_at ? \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y H:i') : '' }}. Your answers are awaiting assessor marking.</div>
        @endif

        <form method="POST" action="{{ route('mupo.assessment.save', $assessment->id) }}" class="{{ $submission && in_array($submission->status, ['submitted','marked']) ? 'mupo-readonly' : '' }}">
            @csrf
            @foreach($questions as $question)
                @php
                    $saved = $answers->get($question->id);
                    $parts = $question->parts_json ? json_decode($question->parts_json, true) : [];
                    $locked = $submission && in_array($submission->status, ['submitted','marked']);
                @endphp
                <div class="mupo-assessment-card">
                    <div class="mupo-question-label">Question {{ $question->question_number }} — {{ $question->marks }} mark{{ $question->marks == 1 ? '' : 's' }}</div>
                    @if($question->title)<h2>{{ $question->title }}</h2>@endif
                    @if($question->scenario)<div class="mupo-scenario">{{ $question->scenario }}</div>@endif
                    @if($question->question)<div class="mupo-question-text">{{ $question->question }}</div>@endif
                    @if(!empty($parts))
                        <ol class="mupo-parts" type="a">
                            @foreach($parts as $part)
                                <li>{{ $part['question'] ?? '' }} @if(isset($part['marks'])) <strong>[{{ $part['marks'] }}]</strong>@endif</li>
                            @endforeach
                        </ol>
                    @endif
                    <label for="answer_{{ $question->id }}"><strong>Your answer</strong></label>
                    <textarea class="mupo-answer" id="answer_{{ $question->id }}" name="answers[{{ $question->id }}]" {{ $locked ? 'readonly' : '' }}>{{ old('answers.'.$question->id, $saved->answer ?? '') }}</textarea>
                    @if($submission && $submission->status === 'marked')
                        <div class="mupo-feedback">
                            <strong>Score:</strong> {{ $saved && $saved->score !== null ? $saved->score : 0 }} / {{ $question->marks }}
                            @if($saved && $saved->feedback)<br><strong>Feedback:</strong> {{ $saved->feedback }}@endif
                        </div>
                    @endif
                </div>
            @endforeach

            @if(!$submission || !in_array($submission->status, ['submitted','marked']))
                <div class="mupo-actions">
                    <button class="mupo-btn mupo-btn-secondary" type="submit" name="action" value="draft">Save Draft</button>
                    <button class="mupo-btn mupo-btn-primary" type="submit" name="action" value="submit" onclick="return confirm('Submit this section for assessor marking? You will not be able to edit it after submission.')">Submit for Marking</button>
                </div>
            @endif
        </form>
    </div>
</section>
@endsection
