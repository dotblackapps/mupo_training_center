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
                <h1>Welcome back.</h1>
                <p>Access your MUPO Training Center courses, assessments, progress and learning resources securely.</p>
                <div class="mupo-auth-steps">
                    <div class="mupo-auth-step"><b><i class="fa-solid fa-graduation-cap"></i> Learners</b><br>Continue your training and monitor progress.</div>
                    <div class="mupo-auth-step"><b><i class="fa-solid fa-shield-halved"></i> Secure access</b><br>Your learning account remains protected.</div>
                    
                </div>
            </div>
            <p><b>Secure LMS Access</b><br>Use your registered email and password to continue.</p>
        </aside>

        <main class="mupo-auth-right">
            <section class="mupo-auth-card">
                <div class="mupo-auth-card-top">
                    <div>
                        <span class="mupo-badge">LMS Login</span>
                        <h2>Sign in</h2>
                        <p class="mupo-auth-sub">Enter your registered email and password to continue.</p>
                    </div>
                    @if(Settings('student_reg')==1 && saasPlanCheck('student')==false)
                        <a class="mupo-switch-link" href="{{ route('register') }}">Sign Up</a>
                    @endif
                </div>

                <form action="{{route('login')}}" method="POST" id="loginForm">
                    @csrf

                    <div class="mupo-field">
                        <label>Email Address</label>
                        <input type="email"
                               value="{{old('email')}}"
                               class="{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               placeholder="{{__('common.Enter Email')}}"
                               name="email"
                               aria-label="Email">
                        @if($errors->first('email'))
                            <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                        @endif
                    </div>

                    <div class="mupo-field">
                        <label>Password</label>
                        <input type="password"
                               name="password"
                               autocomplete="current-password"
                               placeholder="{{__('common.Enter Password')}}"
                               aria-label="password">
                        @if($errors->first('password'))
                            <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
                        @endif
                    </div>

                    @if(saasEnv('NOCAPTCHA_FOR_LOGIN')=='true')
                        <div class="mupo-field">
                            @if(saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")
                                {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}
                            @else
                                {!! NoCaptcha::display() !!}
                            @endif
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger" role="alert">
                                    {{$errors->first('g-recaptcha-response')}}
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="mupo-auth-row">
                        <label class="mupo-auth-check">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="1">
                            <span>Remember Me</span>
                        </label>

                       
                        <button type="button" class="mupo-auth-forgot mupo-reset-trigger" data-reset-modal-open aria-haspopup="dialog" aria-controls="mupoResetModal">
                            <i class="fa-solid fa-key" aria-hidden="true"></i>
                            <span>Forgot Password?</span>
                        </button>
                    </div>

                    @if(saasEnv('NOCAPTCHA_FOR_LOGIN')=='true' && saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")
                        <button type="button" class="g-recaptcha mupo-submit"
                                data-sitekey="{{saasEnv('NOCAPTCHA_SITEKEY')}}"
                                data-size="invisible"
                                data-callback="onSubmit">Login</button>
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <script>
                            function onSubmit(token) {
                                document.getElementById("loginForm").submit();
                            }
                        </script>
                    @else
                        <button type="submit" class="mupo-submit">Login</button>
                    @endif

                    @if(Settings('student_reg')==1 && saasPlanCheck('student')==false)
                        <p class="mupo-note">New learner? <a href="{{route('register')}}">Create your account</a>.</p>
                    @endif
                </form>

                <div class="mupo-support-grid">
                    <div class="mupo-support-card">
                        <b>Course Support</b>
                        <p>Get help with course selection, modules, assessments or training progress.</p>
                    </div>
                    <div class="mupo-support-card">
                        <b>Admin Support</b>
                        <p>Get help with login issues, learner approval, documentation or reporting.</p>
                    </div>
                </div>

                @if(config('app.demo_mode'))
                    <div class="mupo-support-grid">
                        @foreach($roles as $role)
                            <a class="mupo-submit" href="{{route('auto.login',$role->id)}}">{{$role->name}}</a>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>
</div>


<div id="mupoResetModal" class="mupo-reset-modal" role="dialog" aria-modal="true" aria-labelledby="mupoResetModalTitle" aria-hidden="true">
    <div class="mupo-reset-modal__backdrop" data-reset-modal-close></div>
    <div class="mupo-reset-modal__dialog" role="document">
        <button type="button" class="mupo-reset-modal__close" data-reset-modal-close aria-label="Close password reset dialog">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>

        <a href="{{ route('frontendHomePage') }}" class="mupo-reset-modal__brand" aria-label="Mupo Training Center Home">
            <img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" alt="Mupo Training Center Logo">
        </a>

        <div class="mupo-reset-modal__icon" aria-hidden="true">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <h3 id="mupoResetModalTitle">Reset your password</h3>
        <p class="mupo-reset-modal__text">Enter your registered email address and we will send you a secure password reset link.</p>

        @if(session('status'))
            <div class="mupo-reset-modal__alert mupo-reset-modal__alert--success">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                {{ session('status') }}
            </div>
        @endif

        @if(old('reset_request') && $errors->has('email'))
            <div class="mupo-reset-modal__alert mupo-reset-modal__alert--error">
                <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                {{ $errors->first('email') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" id="mupoResetForm">
            @csrf
            <input type="hidden" name="reset_request" value="1">
            <div class="mupo-reset-modal__field">
                <label for="mupoResetEmail">Email Address</label>
                <div class="mupo-reset-modal__input-wrap">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    <input id="mupoResetEmail" type="email" name="email" value="{{ old('reset_request') ? old('email') : '' }}" placeholder="Enter your registered email" autocomplete="email" required>
                </div>
            </div>
            <button type="submit" class="mupo-reset-modal__submit">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                <span>Send Reset Link</span>
            </button>
        </form>

        <div class="mupo-reset-modal__support">
            Need help?&nbsp;<a href="{{ route('contact') }}">Contact MUPO support</a>
        </div>
    </div>
</div>


{!! Toastr::message() !!}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('mupoResetModal');
    const openers = document.querySelectorAll('[data-reset-modal-open]');
    const closers = document.querySelectorAll('[data-reset-modal-close]');
    const emailInput = document.getElementById('mupoResetEmail');
    let lastFocusedElement = null;

    function openResetModal() {
        if (!modal) return;
        lastFocusedElement = document.activeElement;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('mupo-modal-open');
        window.setTimeout(function () {
            if (emailInput) emailInput.focus();
        }, 80);
    }

    function closeResetModal() {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('mupo-modal-open');
        if (lastFocusedElement) lastFocusedElement.focus();
    }

    openers.forEach(function (button) {
        button.addEventListener('click', openResetModal);
    });

    closers.forEach(function (button) {
        button.addEventListener('click', closeResetModal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal && modal.classList.contains('is-open')) {
            closeResetModal();
        }
    });

    const shouldOpenResetModal = @json(
        request()->boolean('forgot') ||
        session()->has('status') ||
        old('reset_request')
    );

    if (shouldOpenResetModal) {
        openResetModal();
    }
});

$('form').submit(function () {
    $(this).find(':submit').attr('disabled', true);
});
</script>
@endsection
