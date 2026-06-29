@extends(theme('auth.layouts.app'))

@section('content')

<style>
:root{
    --mupo-navy:#061738;
    --mupo-navy-2:#09265c;
    --mupo-red:#e30613;
    --mupo-red-dark:#b8040d;
    --mupo-bg:#f4f6fb;
    --mupo-text:#172033;
    --mupo-muted:#667085;
    --mupo-line:#e5eaf2;
    --mupo-white:#ffffff;
}
.mupo-auth-page{
    min-height:100vh;
    background:linear-gradient(135deg,#f5f7fb 0%,#eef3fb 100%);
    color:var(--mupo-text);
    font-family:inherit;
}
.mupo-auth-shell{
    display:grid;
    grid-template-columns:minmax(360px,450px) 1fr;
    min-height:100vh;
}
.mupo-auth-left{
    background:linear-gradient(145deg,var(--mupo-navy),var(--mupo-navy-2));
    color:#fff;
    padding:46px 42px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    gap:28px;
    position:relative;
    overflow:hidden;
}
.mupo-auth-left::after{
    content:"";
    position:absolute;
    width:280px;
    height:280px;
    border-radius:999px;
    background:rgba(227,6,19,.16);
    right:-120px;
    bottom:-100px;
}
.mupo-auth-brand{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    gap:16px;
}
.mupo-auth-brand-card{
    background:#fff;
    border-radius:18px;
    padding:14px 18px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 14px 40px rgba(0,0,0,.16);
}
.mupo-auth-brand img{
    width:170px;
    height:auto;
    display:block;
}
.mupo-auth-left h1{
    position:relative;
    z-index:2;
    color:#fff;
    font-size:42px;
    line-height:1.08;
    font-weight:900;
    margin:36px 0 16px;
}
.mupo-auth-left p{
    position:relative;
    z-index:2;
    color:#e7edf7;
    line-height:1.75;
    margin:0;
    font-size:16px;
}
.mupo-auth-steps{
    position:relative;
    z-index:2;
    display:grid;
    gap:14px;
    margin-top:30px;
}
.mupo-auth-step{
    padding:16px 18px;
    border:1px solid rgba(255,255,255,.18);
    background:rgba(255,255,255,.08);
    border-radius:18px;
    color:#e7edf7;
    line-height:1.55;
}
.mupo-auth-step b{color:#fff}
.mupo-auth-right{
    padding:42px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.mupo-auth-card{
    width:min(780px,100%);
    background:#fff;
    border:1px solid var(--mupo-line);
    border-radius:30px;
    box-shadow:0 24px 70px rgba(6,23,56,.13);
    padding:34px;
}
.mupo-auth-card.mupo-register-card{
    width:min(980px,100%);
    max-height:calc(100vh - 70px);
    overflow-y:auto;
}
.mupo-auth-card-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
    margin-bottom:24px;
}
.mupo-badge{
    display:inline-flex;
    background:#fff1f2;
    color:var(--mupo-red);
    padding:8px 13px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
    letter-spacing:.02em;
    text-transform:uppercase;
}
.mupo-auth-card h2{
    color:var(--mupo-navy);
    font-size:34px;
    font-weight:900;
    margin:12px 0 8px;
}
.mupo-auth-sub{
    color:var(--mupo-muted);
    margin:0;
    line-height:1.6;
}
.mupo-switch-link{
    color:var(--mupo-navy)!important;
    font-weight:900;
    text-decoration:none!important;
    white-space:nowrap;
}
.mupo-switch-link:hover{color:var(--mupo-red)!important}
.mupo-form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}
.mupo-field{margin-bottom:16px}
.mupo-field label,
.mupo-field > span{
    font-size:14px;
    font-weight:900;
    color:#344054;
    display:block;
    margin-bottom:8px;
}
.mupo-field input,
.mupo-field select,
.mupo-field textarea{
    width:100%!important;
    min-height:52px;
    border:1px solid var(--mupo-line)!important;
    border-radius:14px!important;
    padding:14px 15px!important;
    background:#fff!important;
    color:var(--mupo-text)!important;
    box-shadow:none!important;
    outline:none!important;
    font-size:15px!important;
}
.mupo-field textarea{min-height:110px}
.mupo-field input:focus,
.mupo-field select:focus,
.mupo-field textarea:focus{
    border-color:var(--mupo-red)!important;
    box-shadow:0 0 0 4px rgba(227,6,19,.12)!important;
}
.mupo-section-title{
    border-top:1px solid var(--mupo-line);
    padding-top:22px;
    margin:22px 0 15px;
    color:var(--mupo-navy);
    font-weight:900;
    font-size:18px;
}
.mupo-auth-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    margin:6px 0 22px;
    flex-wrap:wrap;
}
.mupo-auth-check{
    display:flex!important;
    gap:9px;
    align-items:center;
    color:var(--mupo-muted)!important;
    font-weight:700!important;
    margin:0!important;
}
.mupo-auth-check input{width:auto!important;height:auto!important;min-height:auto!important;margin:0!important}
.mupo-auth-forgot{
    color:var(--mupo-navy)!important;
    font-weight:900;
    text-decoration:none!important;
}
.mupo-submit{
    width:100%;
    border:0;
    min-height:54px;
    border-radius:999px;
    background:var(--mupo-red);
    color:#fff;
    font-size:16px;
    font-weight:900;
    cursor:pointer;
    transition:.2s ease;
}
.mupo-submit:hover{background:var(--mupo-red-dark)}
.mupo-submit.disable_btn,
.mupo-submit:disabled{opacity:.6;cursor:not-allowed}
.mupo-note{
    text-align:center;
    color:var(--mupo-muted);
    font-size:13px;
    margin:14px 0 0;
}
.mupo-support-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
    margin-top:24px;
}
.mupo-support-card{
    border:1px solid var(--mupo-line);
    border-radius:18px;
    padding:16px;
    background:#fafcff;
}
.mupo-support-card b{color:var(--mupo-navy)}
.mupo-support-card p{
    margin:6px 0 0;
    color:var(--mupo-muted);
    font-size:13px;
    line-height:1.5;
}
.mupo-terms{
    padding:15px;
    border:1px solid var(--mupo-line);
    border-radius:16px;
    background:#fafcff;
}
.mupo-terms label{
    margin:0!important;
    display:flex!important;
    gap:10px;
    align-items:flex-start;
    color:var(--mupo-muted)!important;
    font-weight:700!important;
}
.mupo-terms input{width:auto!important;min-height:auto!important;margin-top:4px!important}
.text-danger{font-size:13px;display:block;margin-top:6px}
@media(max-width:960px){
    .mupo-auth-shell{grid-template-columns:1fr}
    .mupo-auth-left{padding:32px}
    .mupo-auth-right{padding:24px}
    .mupo-auth-card.mupo-register-card{max-height:none;overflow:visible}
}
@media(max-width:700px){
    .mupo-form-grid,.mupo-support-grid{grid-template-columns:1fr}
    .mupo-auth-card{padding:24px;border-radius:22px}
    .mupo-auth-card-top{flex-direction:column}
    .mupo-auth-left h1{font-size:32px}
    .mupo-auth-brand img{width:145px}
}

.mupo-back-home{
    display:inline-flex;
    align-items:center;
    gap:8px;
    height:44px;
    padding:0 16px;
    border-radius:999px;
    background:#ffffff;
    color:var(--mupo-navy)!important;
    border:1px solid rgba(255,255,255,.65);
    box-shadow:0 10px 28px rgba(0,0,0,.14);
    text-decoration:none!important;
    font-weight:900;
    margin-bottom:24px;
    position:relative;
    z-index:3;
}
.mupo-back-home:hover{
    color:#fff!important;
    background:var(--mupo-red);
    border-color:var(--mupo-red);
}
</style>

<div class="mupo-auth-page">
    <div class="mupo-auth-shell">
        <aside class="mupo-auth-left">
            <div>
                <a href="{{ url('/') }}" class="mupo-back-home"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
                <a href="{{ url('/') }}" class="mupo-auth-brand">
                    <span class="mupo-auth-brand-card">
                        <img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" onerror="this.src='{{ url('public/uploads/settings/mupo-logo_1.jpeg') }}'" alt="Mupo Training Center">
                    </span>
                </a>
                <h1>Register for professional training.</h1>
                <p>Create a learner profile, select your details, and continue with MUPO Training Center's LMS registration process.</p>
                <div class="mupo-auth-steps">
                    <div class="mupo-auth-step"><b>01</b><br>Capture learner and contact details.</div>
                    <div class="mupo-auth-step"><b>02</b><br>Choose student type and institute.</div>
                    <div class="mupo-auth-step"><b>03</b><br>Access the LMS after your account is created.</div>
                </div>
            </div>
            <p><b>Need help?</b><br>Contact MUPO Training Center support for learner registration assistance.</p>
        </aside>

        <main class="mupo-auth-right">
            <section class="mupo-auth-card mupo-register-card">
                <div class="mupo-auth-card-top">
                    <div>
                        <span class="mupo-badge">Learner Registration</span>
                        <h2>Create your account</h2>
                        <p class="mupo-auth-sub">Complete the required fields below. Your backend registration process remains unchanged.</p>
                    </div>
                    <a class="mupo-switch-link" href="{{ route('login') }}">Login</a>
                </div>

                <form action="{{ route('register') }}" method="POST" id="regForm">
                    @csrf

                    <div class="mupo-section-title">Personal Details</div>
                    <div class="mupo-form-grid">
                        <div class="mupo-field">
                            <label>Full Name *</label>
                            <input type="text" required placeholder="Enter Full Name *" name="name" value="{{ old('name') }}">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Email Address *</label>
                            <input type="email" required placeholder="Enter Email *" name="email" value="{{ old('email') }}">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Phone Number</label>
                            <input type="text" placeholder="Enter Phone Number" name="phone" value="{{ old('phone') }}">
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob') }}">
                            <span class="text-danger">{{ $errors->first('dob') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Password *</label>
                            <input type="password" required placeholder="Enter Password *" name="password" autocomplete="new-password">
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Confirm Password *</label>
                            <input type="password" required placeholder="Enter Confirm Password *" name="password_confirmation">
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        </div>
                    </div>

                    <div class="mupo-section-title">Additional Details</div>
                    <div class="mupo-form-grid">
                        <div class="mupo-field">
                            <label>Company</label>
                            <input type="text" placeholder="Enter Company" name="company" value="{{ old('company') }}">
                            <span class="text-danger">{{ $errors->first('company') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Identification Number</label>
                            <input type="text" placeholder="Enter Identification Number" name="identification_number" value="{{ old('identification_number') }}">
                            <span class="text-danger">{{ $errors->first('identification_number') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Job Title</label>
                            <input type="text" placeholder="Enter Job Title" name="job_title" value="{{ old('job_title') }}">
                            <span class="text-danger">{{ $errors->first('job_title') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="">Choose Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('gender') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Student Type</label>
                            <select name="student_type">
                                <option value="">Choose Student Type</option>
                                <option value="personal" {{ old('student_type') == 'personal' ? 'selected' : '' }}>Personal</option>
                                <option value="corporate" {{ old('student_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('student_type') }}</span>
                        </div>

                        <div class="mupo-field">
                            <label>Institute</label>
                            <select name="institute">
                                <option value="">Choose Institute</option>
                                <option value="PRASA" {{ old('institute') == 'PRASA' ? 'selected' : '' }}>PRASA</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('institute') }}</span>
                        </div>
                    </div>

                    <div class="mupo-section-title">Terms & Conditions</div>
                    <div class="mupo-terms">
                        <label for="checkbox">
                            <input type="checkbox" id="checkbox" required>
                            <span>
                                By signing up, you agree to
                                <a target="_blank" href="{{ url('terms') }}">Terms of Service</a>
                                and
                                <a target="_blank" href="{{ url('privacy') }}">Privacy Policy</a>.
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="mupo-submit disable_btn" disabled id="submitBtn">
                        Sign Up
                    </button>

                    <p class="mupo-note">Already have an account? <a href="{{ route('login') }}">Login</a>.</p>
                </form>
            </section>
        </main>
    </div>
</div>

<script>
    $(function () {
        $('#checkbox').click(function () {
            if ($(this).is(':checked')) {
                $('#submitBtn').removeClass('disable_btn');
                $('#submitBtn').removeAttr('disabled');
            } else {
                $('#submitBtn').addClass('disable_btn');
                $('#submitBtn').attr('disabled', 'disabled');
            }
        });
    });
</script>
@endsection
