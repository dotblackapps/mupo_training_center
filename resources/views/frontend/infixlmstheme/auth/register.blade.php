@extends(theme('auth.layouts.app'))

@section('content')

<style>
:root{--mupo-navy:#061738;--mupo-navy-2:#0a2a60;--mupo-red:#e30613;--mupo-red-dark:#ba0610;--mupo-bg:#f4f7fb;--mupo-text:#172033;--mupo-muted:#667085;--mupo-line:#e3e9f2;--mupo-white:#fff}
html,body{margin:0;padding:0;background:var(--mupo-bg)}
body{min-height:100vh}
.mupo-auth-page{min-height:100vh;background:linear-gradient(135deg,#f6f8fc 0%,#eef3fa 100%);color:var(--mupo-text);font-family:inherit}
.mupo-auth-shell{min-height:100vh;display:grid;grid-template-columns:minmax(300px,34vw) 1fr}
.mupo-auth-left{background:linear-gradient(150deg,var(--mupo-navy) 0%,var(--mupo-navy-2) 100%);color:#fff;padding:30px 34px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}
.mupo-auth-left:before{content:"";position:absolute;left:-90px;top:-90px;width:230px;height:230px;border-radius:50%;background:rgba(255,255,255,.045)}
.mupo-auth-left:after{content:"";position:absolute;right:-110px;bottom:-100px;width:270px;height:270px;border-radius:50%;background:rgba(227,6,19,.18)}
.mupo-back-home{display:inline-flex;align-items:center;gap:8px;height:38px;padding:0 14px;border-radius:999px;background:rgba(255,255,255,.10);color:#fff!important;border:1px solid rgba(255,255,255,.20);text-decoration:none!important;font-weight:800;font-size:13px;position:relative;z-index:2;transition:.2s ease}
.mupo-back-home:hover{background:#fff;color:var(--mupo-navy)!important}
.mupo-auth-brand{display:block;width:max-content;margin-top:18px;position:relative;z-index:2}
.mupo-auth-brand-card{background:#fff;border-radius:14px;padding:10px 14px;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 12px 32px rgba(0,0,0,.15)}
.mupo-auth-brand img{width:145px;height:auto;display:block}
.mupo-auth-left h1{position:relative;z-index:2;color:#fff!important;font-size:clamp(30px,3vw,46px);line-height:1.04;font-weight:900;margin:26px 0 12px;max-width:430px;letter-spacing:-.025em}
.mupo-auth-left>div>p,.mupo-auth-left>p{position:relative;z-index:2;color:#dce6f5;line-height:1.55;margin:0;font-size:14px;max-width:430px}
.mupo-auth-steps{position:relative;z-index:2;display:grid;gap:9px;margin-top:22px}
.mupo-auth-step{padding:11px 13px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.07);border-radius:13px;color:#e8eef8;line-height:1.35;font-size:13px}
.mupo-auth-step b{color:#fff;font-size:13px}
.mupo-auth-right{padding:24px 32px;display:flex;align-items:center;justify-content:center;min-width:0}
.mupo-auth-card{width:min(680px,100%);background:#fff;border:1px solid var(--mupo-line);border-radius:24px;box-shadow:0 24px 70px rgba(6,23,56,.12);padding:28px 30px}
.mupo-auth-card.mupo-register-card{width:min(1040px,100%);padding:22px 26px}
.mupo-auth-card-top{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:18px}
.mupo-badge{display:inline-flex;background:#fff1f2;color:var(--mupo-red);padding:6px 11px;border-radius:999px;font-size:11px;font-weight:900;letter-spacing:.05em;text-transform:uppercase}
.mupo-auth-card h2{color:var(--mupo-navy)!important;font-size:30px;font-weight:900;margin:9px 0 5px;letter-spacing:-.02em}
.mupo-auth-sub{color:var(--mupo-muted);margin:0;line-height:1.45;font-size:14px}
.mupo-switch-link{display:inline-flex;align-items:center;justify-content:center;min-height:40px;padding:0 15px;border:1px solid var(--mupo-line);border-radius:999px;color:var(--mupo-navy)!important;background:#fff;font-weight:900;text-decoration:none!important;white-space:nowrap;font-size:13px}
.mupo-switch-link:hover{border-color:var(--mupo-red);color:var(--mupo-red)!important}
.mupo-form-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px 12px}
.mupo-field{margin:0 0 11px}
.mupo-field label{font-size:12px;font-weight:900;color:#344054;display:block;margin-bottom:5px}
.mupo-field input,.mupo-field select,.mupo-field textarea{width:100%!important;height:44px;min-height:44px;border:1px solid var(--mupo-line)!important;border-radius:11px!important;padding:9px 12px!important;background:#fff!important;color:var(--mupo-text)!important;box-shadow:none!important;outline:none!important;font-size:13px!important}
.mupo-field select{padding-right:30px!important}.mupo-field textarea{height:auto;min-height:84px}
.mupo-field input:focus,.mupo-field select:focus,.mupo-field textarea:focus{border-color:var(--mupo-red)!important;box-shadow:0 0 0 3px rgba(227,6,19,.09)!important}
.mupo-section-title{border-top:1px solid var(--mupo-line);padding-top:11px;margin:8px 0 9px;color:var(--mupo-navy);font-weight:900;font-size:14px}
.mupo-auth-row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:2px 0 15px;flex-wrap:wrap}
.mupo-auth-check{display:flex!important;gap:8px;align-items:center;color:var(--mupo-muted)!important;font-weight:700!important;margin:0!important;font-size:13px}.mupo-auth-check input{width:auto!important;height:auto!important;min-height:auto!important;margin:0!important}
.mupo-auth-forgot,.mupo-reset-trigger{border:0;background:transparent;padding:0;color:var(--mupo-navy)!important;font-weight:900;text-decoration:none!important;display:inline-flex;align-items:center;gap:7px;cursor:pointer;font-size:13px}.mupo-reset-trigger i{color:var(--mupo-red)}
.mupo-submit{width:100%;border:0;min-height:48px;border-radius:999px;background:var(--mupo-red);color:#fff;font-size:14px;font-weight:900;cursor:pointer;transition:.2s ease}.mupo-submit:hover{background:var(--mupo-red-dark)}.mupo-submit.disable_btn,.mupo-submit:disabled{opacity:.58;cursor:not-allowed}
.mupo-note{text-align:center;color:var(--mupo-muted);font-size:12px;margin:10px 0 0}.mupo-note a{color:var(--mupo-navy);font-weight:900}
.mupo-support-grid{display:none}
.mupo-terms{padding:9px 11px;border:1px solid var(--mupo-line);border-radius:12px;background:#fafcff;margin-top:2px}.mupo-terms label{margin:0!important;display:flex!important;gap:9px;align-items:flex-start;color:var(--mupo-muted)!important;font-weight:700!important;font-size:12px;line-height:1.35}.mupo-terms input{width:auto!important;min-height:auto!important;margin-top:2px!important}
.text-danger{font-size:11px;display:block;margin-top:4px;line-height:1.2}
body.mupo-modal-open{overflow:hidden}.mupo-reset-modal{position:fixed;inset:0;z-index:10050;display:none;align-items:center;justify-content:center;padding:20px}.mupo-reset-modal.is-open{display:flex}.mupo-reset-modal__backdrop{position:absolute;inset:0;background:rgba(6,23,56,.74);backdrop-filter:blur(6px)}.mupo-reset-modal__dialog{position:relative;z-index:1;width:min(460px,100%);background:#fff;border-radius:22px;box-shadow:0 30px 90px rgba(6,23,56,.30);padding:28px;animation:mupoResetIn .22s ease-out}@keyframes mupoResetIn{from{opacity:0;transform:translateY(14px) scale(.98)}to{opacity:1;transform:none}}.mupo-reset-modal__close{position:absolute;top:14px;right:14px;width:38px;height:38px;border:1px solid var(--mupo-line);border-radius:50%;background:#fff;color:var(--mupo-navy);display:grid;place-items:center;cursor:pointer}.mupo-reset-modal__close:hover{background:var(--mupo-red);border-color:var(--mupo-red);color:#fff}.mupo-reset-modal__brand{display:inline-flex;padding:8px 12px;margin-bottom:16px;background:#fff;border:1px solid var(--mupo-line);border-radius:12px}.mupo-reset-modal__brand img{display:block;width:130px;height:auto}.mupo-reset-modal__icon{width:56px;height:56px;border-radius:16px;display:grid;place-items:center;margin-bottom:14px;background:#fff1f2;color:var(--mupo-red);font-size:23px}.mupo-reset-modal h3{margin:0 44px 7px 0;color:var(--mupo-navy);font-size:25px;font-weight:900}.mupo-reset-modal__text{margin:0 0 17px;color:var(--mupo-muted);line-height:1.55;font-size:13px}.mupo-reset-modal__alert{border-radius:12px;padding:10px 12px;margin-bottom:12px;font-size:12px;line-height:1.4}.mupo-reset-modal__alert--success{background:#ecfdf3;border:1px solid #a6f4c5;color:#067647}.mupo-reset-modal__alert--error{background:#fff1f2;border:1px solid #fecdd3;color:#b42318}.mupo-reset-modal__field label{display:block;margin-bottom:6px;color:#344054;font-size:12px;font-weight:900}.mupo-reset-modal__input-wrap{position:relative}.mupo-reset-modal__input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#98a2b3}.mupo-reset-modal__field input{width:100%;min-height:48px;padding:11px 12px 11px 42px;border:1px solid var(--mupo-line);border-radius:11px;background:#fff;color:var(--mupo-text);font-size:13px;outline:none}.mupo-reset-modal__field input:focus{border-color:var(--mupo-red);box-shadow:0 0 0 3px rgba(227,6,19,.10)}.mupo-reset-modal__submit{width:100%;min-height:48px;margin-top:14px;border:0;border-radius:999px;background:var(--mupo-red);color:#fff;display:flex;align-items:center;justify-content:center;gap:8px;font-size:14px;font-weight:900;cursor:pointer}.mupo-reset-modal__submit:hover{background:var(--mupo-red-dark)}.mupo-reset-modal__support{display:flex;justify-content:center;margin-top:12px;color:var(--mupo-muted);font-size:12px}.mupo-reset-modal__support a{color:var(--mupo-navy);font-weight:900}
@media(min-width:992px){html,body{height:100%;overflow:hidden}.mupo-auth-page,.mupo-auth-shell{height:100vh;min-height:0}.mupo-auth-card.mupo-register-card{max-height:none;overflow:visible}.mupo-auth-left>p{font-size:12px}.mupo-register-card .mupo-field{margin-bottom:7px}.mupo-register-card .mupo-section-title{padding-top:8px;margin:5px 0 7px}.mupo-register-card .mupo-submit{min-height:44px;margin-top:9px}}
@media(max-width:991px){html,body{overflow:auto}.mupo-auth-shell{grid-template-columns:1fr}.mupo-auth-left{padding:26px;min-height:auto}.mupo-auth-right{padding:20px}.mupo-form-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.mupo-auth-left>p{margin-top:20px}.mupo-auth-steps{display:none}}
@media(max-width:640px){.mupo-form-grid{grid-template-columns:1fr}.mupo-auth-card,.mupo-auth-card.mupo-register-card{padding:20px;border-radius:18px}.mupo-auth-card-top{flex-direction:column;gap:10px}.mupo-auth-left h1{font-size:30px}.mupo-auth-brand img{width:130px}.mupo-auth-right{padding:14px}.mupo-reset-modal{padding:12px}.mupo-reset-modal__dialog{padding:22px 18px;border-radius:18px}}
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
                <h1>Start learning with MUPO.</h1>
                <p>Create your learner account and get access to professional training through MUPO Training Center.</p>
                <div class="mupo-auth-steps">
                    <div class="mupo-auth-step"><b>01 · Your profile</b><br>Provide your learner and contact details.</div>
                    <div class="mupo-auth-step"><b>02 · Your access</b><br>Set up your secure learning account.</div>
                    
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
