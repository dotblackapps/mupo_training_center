@extends(theme('auth.layouts.app'))
@section('content')

<style>
:root{--mupo-navy:#061738;--mupo-navy-2:#0b2858;--mupo-red:#e30613;--mupo-red-dark:#b9040e;--mupo-text:#152033;--mupo-muted:#657083;--mupo-line:#dfe5ee;--mupo-soft:#f6f8fb;--mupo-white:#fff}
html,body{margin:0;padding:0;background:#fff}
body{min-height:100vh;color:var(--mupo-text)}
.mupo-auth-page{min-height:100vh;background:#fff;font-family:inherit}
.mupo-auth-shell{min-height:100vh;display:grid;grid-template-columns:minmax(350px,36%) 1fr}
.mupo-auth-brand-panel{position:relative;overflow:hidden;background:var(--mupo-navy);color:#fff;min-height:100vh;display:flex;align-items:stretch}
.mupo-auth-brand-panel::before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(6,23,56,.98) 0%,rgba(6,23,56,.92) 52%,rgba(6,23,56,.60) 100%),url('{{ asset('mupo/assets/images/bulb.jpg') }}') center/cover no-repeat}
.mupo-auth-brand-inner{position:relative;z-index:1;width:100%;padding:36px 44px;display:flex;flex-direction:column;justify-content:space-between}
.mupo-back-home{display:inline-flex;align-items:center;gap:9px;color:#fff!important;text-decoration:none!important;font-size:14px;font-weight:700;width:max-content;border-bottom:1px solid rgba(255,255,255,.38);padding-bottom:4px}
.mupo-brand-logo{display:inline-block;margin-top:38px;background:#fff;padding:12px 16px;border-radius:8px}.mupo-brand-logo img{display:block;width:165px;height:auto}
.mupo-brand-copy{max-width:430px;margin:auto 0;padding:46px 0 30px}.mupo-brand-kicker{color:var(--mupo-red);font-size:13px;font-weight:900;letter-spacing:.11em;text-transform:uppercase;margin-bottom:15px}.mupo-brand-copy h1{margin:0;color:#fff!important;font-size:clamp(38px,3.8vw,58px);line-height:1.02;font-weight:900;letter-spacing:-.04em}.mupo-brand-copy p{margin:20px 0 0;color:#e6edf7;font-size:16px;line-height:1.6;max-width:400px}.mupo-brand-line{width:64px;height:4px;background:var(--mupo-red);margin-top:28px}.mupo-brand-footer{color:#d3dcec;font-size:12px;line-height:1.6}.mupo-brand-footer strong{display:block;color:#fff;font-size:13px;margin-bottom:2px}
.mupo-register-main{min-height:100vh;background:#fff;padding:42px clamp(34px,5vw,76px);display:flex;justify-content:center;align-items:flex-start;overflow:auto}
.mupo-register-content{width:min(900px,100%)}
.mupo-register-head{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;padding-bottom:24px;border-bottom:1px solid var(--mupo-line);margin-bottom:28px}
.mupo-register-eyebrow{font-size:13px;color:var(--mupo-red);font-weight:900;letter-spacing:.09em;text-transform:uppercase;margin-bottom:10px}.mupo-register-head h2{margin:0!important;color:var(--mupo-navy)!important;font-size:clamp(32px,2.7vw,42px)!important;line-height:1.08!important;font-weight:900!important;letter-spacing:-.035em!important}.mupo-register-sub{margin:10px 0 0;color:var(--mupo-muted);font-size:14px;line-height:1.6;max-width:610px}.mupo-login-link{display:inline-flex;align-items:center;gap:7px;color:var(--mupo-navy)!important;font-size:13px;font-weight:800;text-decoration:none!important;white-space:nowrap;padding-top:5px}.mupo-login-link:hover{color:var(--mupo-red)!important}
.mupo-section{margin-bottom:26px}.mupo-section-heading{display:flex;align-items:center;gap:12px;margin-bottom:16px}.mupo-section-number{width:28px;height:28px;border:1px solid var(--mupo-line);border-radius:7px;display:grid;place-items:center;color:var(--mupo-red);font-size:11px;font-weight:900;background:#fff}.mupo-section-title{margin:0;color:var(--mupo-navy);font-size:15px;font-weight:900}.mupo-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px 20px}.mupo-field{margin:0}.mupo-field label{display:block;margin-bottom:7px;color:var(--mupo-navy);font-size:12px;font-weight:800}.mupo-field input,.mupo-field select{width:100%!important;height:50px!important;min-height:50px!important;border:1px solid var(--mupo-line)!important;border-radius:9px!important;background:#fff!important;padding:0 14px!important;color:var(--mupo-text)!important;box-shadow:none!important;outline:none!important;font-size:13px!important;transition:border-color .2s,box-shadow .2s}.mupo-field select{padding-right:34px!important}.mupo-field input:focus,.mupo-field select:focus{border-color:var(--mupo-navy)!important;box-shadow:0 0 0 3px rgba(6,23,56,.07)!important}.text-danger{display:block;margin-top:5px;color:#b42318!important;font-size:11px;line-height:1.35}
.mupo-terms{border-top:1px solid var(--mupo-line);padding-top:22px;margin-top:2px}.mupo-terms label{display:flex!important;align-items:flex-start;gap:10px;margin:0!important;color:var(--mupo-muted)!important;font-size:12px!important;line-height:1.55;font-weight:600!important}.mupo-terms input{width:15px!important;height:15px!important;min-height:0!important;margin:2px 0 0!important}.mupo-terms a{color:var(--mupo-navy)!important;font-weight:800;text-decoration:none}.mupo-terms a:hover{color:var(--mupo-red)!important}
.mupo-submit{width:100%;min-height:52px;margin-top:20px;border:0;border-radius:9px;background:var(--mupo-red);color:#fff;font-size:14px;font-weight:900;cursor:pointer;transition:background .2s,transform .2s}.mupo-submit:hover{background:var(--mupo-red-dark);transform:translateY(-1px)}.mupo-submit.disable_btn,.mupo-submit:disabled{opacity:.55;cursor:not-allowed;transform:none}.mupo-note{margin:18px 0 0;text-align:center;color:var(--mupo-muted);font-size:13px}.mupo-note a{color:var(--mupo-navy)!important;font-weight:900;text-decoration:none}.mupo-note a:hover{color:var(--mupo-red)!important}
@media(max-width:1050px){.mupo-auth-shell{grid-template-columns:34% 1fr}.mupo-auth-brand-inner{padding:32px}.mupo-register-main{padding:36px}.mupo-brand-copy h1{font-size:42px}}
@media(max-width:820px){.mupo-auth-shell{grid-template-columns:1fr}.mupo-auth-brand-panel{min-height:310px}.mupo-auth-brand-inner{padding:26px}.mupo-brand-logo{margin-top:26px}.mupo-brand-copy{padding:32px 0 18px}.mupo-brand-copy h1{font-size:38px}.mupo-brand-copy p{font-size:14px;margin-top:12px}.mupo-brand-footer{display:none}.mupo-register-main{min-height:auto;padding:38px 24px 52px}}
@media(max-width:620px){.mupo-form-grid{grid-template-columns:1fr}.mupo-register-head{display:block}.mupo-login-link{margin-top:16px}.mupo-register-main{padding:32px 18px 44px}.mupo-brand-logo img{width:145px}.mupo-brand-copy h1{font-size:34px}}


/* MUPO auth viewport refinement: keep brand panel fixed and place navigation consistently. */
@media (min-width: 992px) {
    html, body {
        height: 100%;
        overflow: hidden !important;
    }

    .mupo-auth-page {
        height: 100vh !important;
        min-height: 100vh !important;
        overflow: hidden !important;
    }

    .mupo-auth-shell {
        height: 100vh !important;
        min-height: 0 !important;
        overflow: hidden !important;
    }

    .mupo-auth-left {
        height: 100vh !important;
        min-height: 0 !important;
        overflow: hidden !important;
        position: relative !important;
    }

    .mupo-auth-right {
        height: 100vh !important;
        min-height: 0 !important;
    }

    .mupo-back-home {
        position: absolute !important;
        top: 30px !important;
        left: 44px !important;
        z-index: 20 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 9px !important;
        margin: 0 !important;
        width: auto !important;
    }
}

@media (min-width: 992px) {
    /* Registration scroll belongs only to the form/content side. */
    .mupo-auth-right {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        overscroll-behavior: contain;
        scrollbar-gutter: stable;
    }

    .mupo-auth-right::-webkit-scrollbar {
        width: 8px;
    }

    .mupo-auth-right::-webkit-scrollbar-track {
        background: #f4f6f9;
    }

    .mupo-auth-right::-webkit-scrollbar-thumb {
        background: #b8c0cc;
        border-radius: 8px;
    }
}

</style>

<div class="mupo-auth-page">
    <div class="mupo-auth-shell">
        <aside class="mupo-auth-brand-panel">
            <div class="mupo-auth-brand-inner">
                <div>
                    <a href="{{ url('/') }}" class="mupo-back-home"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
                    <a href="{{ url('/') }}" class="mupo-brand-logo" aria-label="Mupo Training Center Home">
                        <img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" onerror="this.src='{{ url('public/uploads/settings/mupo-logo_1.jpeg') }}'" alt="Mupo Training Center">
                    </a>
                </div>

                <div class="mupo-brand-copy">
                    <div class="mupo-brand-kicker">Professional learning starts here.</div>
                    <h1>Build your future with MUPO.</h1>
                    <p>Create your learner account to access accredited training programmes, course resources, assessments and learning progress.</p>
                    <div class="mupo-brand-line"></div>
                </div>

                <div class="mupo-brand-footer"><strong>Mupo Training Center</strong>Practical. Accredited. Industry-relevant.</div>
            </div>
        </aside>

        <main class="mupo-register-main">
            <section class="mupo-register-content">
                <div class="mupo-register-head">
                    <div>
                        <div class="mupo-register-eyebrow">Learner registration</div>
                        <h2>Create your learner account</h2>
                        <p class="mupo-register-sub">Register to access Mupo Training Center courses and learning resources. Fields marked with * are required.</p>
                    </div>
                    <a class="mupo-login-link" href="{{ route('login') }}">Already registered? <strong>Login</strong></a>
                </div>

                <form action="{{ route('register') }}" method="POST" id="regForm">
                    @csrf

                    <div class="mupo-section">
                        <div class="mupo-section-heading"><span class="mupo-section-number">01</span><h3 class="mupo-section-title">Personal information</h3></div>
                        <div class="mupo-form-grid">
                            <div class="mupo-field">
                                <label>Full Name *</label>
                                <input type="text" required placeholder="Enter full name" name="name" value="{{ old('name') }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Email Address *</label>
                                <input type="email" required placeholder="Enter email address" name="email" value="{{ old('email') }}">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Phone Number</label>
                                <input type="text" placeholder="Enter phone number" name="phone" value="{{ old('phone') }}">
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" value="{{ old('dob') }}">
                                <span class="text-danger">{{ $errors->first('dob') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mupo-section">
                        <div class="mupo-section-heading"><span class="mupo-section-number">02</span><h3 class="mupo-section-title">Account security</h3></div>
                        <div class="mupo-form-grid">
                            <div class="mupo-field">
                                <label>Password *</label>
                                <input type="password" required placeholder="Create a password" name="password" autocomplete="new-password">
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Confirm Password *</label>
                                <input type="password" required placeholder="Confirm your password" name="password_confirmation">
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mupo-section">
                        <div class="mupo-section-heading"><span class="mupo-section-number">03</span><h3 class="mupo-section-title">Additional information</h3></div>
                        <div class="mupo-form-grid">
                            <div class="mupo-field">
                                <label>Company</label>
                                <input type="text" placeholder="Enter company" name="company" value="{{ old('company') }}">
                                <span class="text-danger">{{ $errors->first('company') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Identification Number</label>
                                <input type="text" placeholder="Enter identification number" name="identification_number" value="{{ old('identification_number') }}">
                                <span class="text-danger">{{ $errors->first('identification_number') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Job Title</label>
                                <input type="text" placeholder="Enter job title" name="job_title" value="{{ old('job_title') }}">
                                <span class="text-danger">{{ $errors->first('job_title') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Gender</label>
                                <select name="gender">
                                    <option value="">Choose gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Student Type</label>
                                <select name="student_type">
                                    <option value="">Choose student type</option>
                                    <option value="personal" {{ old('student_type') == 'personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="corporate" {{ old('student_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('student_type') }}</span>
                            </div>
                            <div class="mupo-field">
                                <label>Institute</label>
                                <select name="institute">
                                    <option value="">Choose institute</option>
                                    <option value="PRASA" {{ old('institute') == 'PRASA' ? 'selected' : '' }}>PRASA</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('institute') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mupo-section">
                        <div class="mupo-section-heading"><span class="mupo-section-number">04</span><h3 class="mupo-section-title">Agreement</h3></div>
                        <div class="mupo-terms">
                            <label for="checkbox">
                                <input type="checkbox" id="checkbox" required>
                                <span>By signing up, you agree to <a target="_blank" href="{{ url('terms') }}">Terms of Service</a> and <a target="_blank" href="{{ url('privacy') }}">Privacy Policy</a>.</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="mupo-submit disable_btn" disabled id="submitBtn">Create Account</button>
                    <p class="mupo-note">Already have an account? <a href="{{ route('login') }}">Login</a></p>
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
