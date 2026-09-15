@extends(theme('auth.layouts.app'))
@section('content')

<style>
:root{--mupo-navy:#061738;--mupo-navy-2:#0b2858;--mupo-red:#e30613;--mupo-red-dark:#b9040e;--mupo-text:#152033;--mupo-muted:#657083;--mupo-line:#dfe5ee;--mupo-soft:#f6f8fb;--mupo-white:#fff}
html,body{margin:0;padding:0;background:#fff}
body{min-height:100vh;color:var(--mupo-text)}
.mupo-auth-page{min-height:100vh;background:#fff;font-family:inherit}
.mupo-auth-shell{min-height:100vh;display:grid;grid-template-columns:minmax(390px,44%) 1fr}
.mupo-auth-brand-panel{position:relative;overflow:hidden;background:var(--mupo-navy);color:#fff;min-height:100vh;display:flex;align-items:stretch}
.mupo-auth-brand-panel::before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(6,23,56,.97) 0%,rgba(6,23,56,.92) 44%,rgba(6,23,56,.52) 100%),url('{{ asset('mupo/assets/images/bulb.jpg') }}') center/cover no-repeat}
.mupo-auth-brand-inner{position:relative;z-index:1;width:100%;padding:40px 52px;display:flex;flex-direction:column;justify-content:space-between}
.mupo-back-home{display:inline-flex;align-items:center;gap:9px;color:#fff!important;text-decoration:none!important;font-size:14px;font-weight:700;width:max-content;border-bottom:1px solid rgba(255,255,255,.38);padding-bottom:4px}
.mupo-back-home:hover{color:#fff!important;border-color:#fff}
.mupo-brand-logo{display:inline-block;margin-top:44px;background:#fff;padding:13px 17px;border-radius:8px}
.mupo-brand-logo img{display:block;width:170px;height:auto}
.mupo-brand-copy{max-width:520px;margin-top:auto;margin-bottom:auto;padding:55px 0 40px}
.mupo-brand-kicker{color:var(--mupo-red);font-size:13px;font-weight:900;letter-spacing:.11em;text-transform:uppercase;margin-bottom:15px}
.mupo-brand-copy h1{margin:0;color:#fff!important;font-size:clamp(42px,4.4vw,70px);line-height:.98;font-weight:900;letter-spacing:-.045em}
.mupo-brand-copy p{max-width:460px;margin:22px 0 0;color:#e6edf7;font-size:18px;line-height:1.6}
.mupo-brand-line{width:64px;height:4px;background:var(--mupo-red);margin-top:30px}
.mupo-brand-footer{display:flex;align-items:center;gap:22px;color:#d3dcec;font-size:13px;text-transform:uppercase;letter-spacing:.12em;font-weight:700}
.mupo-brand-footer span+span{position:relative}.mupo-brand-footer span+span::before{content:"";position:absolute;left:-12px;top:50%;width:3px;height:3px;border-radius:50%;background:var(--mupo-red)}
.mupo-auth-main{min-height:100vh;background:#fff;display:flex;align-items:center;justify-content:center;padding:56px clamp(34px,6vw,92px)}
.mupo-auth-content{width:min(520px,100%)}
.mupo-auth-eyebrow{font-size:13px;color:var(--mupo-red);font-weight:900;letter-spacing:.09em;text-transform:uppercase;margin-bottom:12px}
.mupo-auth-content h2{margin:0!important;color:var(--mupo-navy)!important;font-size:clamp(34px,3vw,46px)!important;line-height:1.08!important;font-weight:900!important;letter-spacing:-.035em!important}
.mupo-auth-sub{margin:12px 0 34px;color:var(--mupo-muted);font-size:15px;line-height:1.65}
.mupo-field{margin-bottom:20px}
.mupo-field label{display:block;margin-bottom:8px;color:var(--mupo-navy);font-size:13px;font-weight:800}
.mupo-field input{width:100%!important;height:52px!important;min-height:52px!important;border:1px solid var(--mupo-line)!important;border-radius:9px!important;background:#fff!important;padding:0 15px!important;color:var(--mupo-text)!important;box-shadow:none!important;outline:none!important;font-size:14px!important;transition:border-color .2s,box-shadow .2s}
.mupo-field input:focus{border-color:var(--mupo-navy)!important;box-shadow:0 0 0 3px rgba(6,23,56,.07)!important}
.mupo-auth-row{display:flex;align-items:center;justify-content:space-between;gap:18px;margin:3px 0 24px;flex-wrap:wrap}
.mupo-auth-check{display:flex!important;align-items:center;gap:8px;margin:0!important;color:var(--mupo-muted)!important;font-size:13px!important;font-weight:600!important}
.mupo-auth-check input{width:15px!important;height:15px!important;min-height:0!important;margin:0!important}
.mupo-reset-trigger{border:0;background:transparent;padding:0;color:var(--mupo-navy)!important;font-size:13px;font-weight:800;cursor:pointer;text-decoration:none!important}
.mupo-reset-trigger:hover{color:var(--mupo-red)!important}
.mupo-submit{width:100%;min-height:52px;border:0;border-radius:9px;background:var(--mupo-red);color:#fff;font-size:14px;font-weight:900;cursor:pointer;transition:background .2s,transform .2s}
.mupo-submit:hover{background:var(--mupo-red-dark);transform:translateY(-1px)}
.mupo-auth-divider{height:1px;background:var(--mupo-line);margin:28px 0 22px}
.mupo-note{margin:0;text-align:center;color:var(--mupo-muted);font-size:13px}.mupo-note a{color:var(--mupo-navy)!important;font-weight:900;text-decoration:none}.mupo-note a:hover{color:var(--mupo-red)!important}
.text-danger{display:block;margin-top:5px;color:#b42318!important;font-size:11px;line-height:1.35}
.mupo-support-grid{display:none}
body.mupo-modal-open{overflow:hidden}.mupo-reset-modal{position:fixed;inset:0;z-index:10050;display:none;align-items:center;justify-content:center;padding:20px}.mupo-reset-modal.is-open{display:flex}.mupo-reset-modal__backdrop{position:absolute;inset:0;background:rgba(6,23,56,.78);backdrop-filter:blur(5px)}.mupo-reset-modal__dialog{position:relative;z-index:1;width:min(460px,100%);background:#fff;border:1px solid var(--mupo-line);border-radius:12px;box-shadow:0 24px 70px rgba(6,23,56,.25);padding:30px}.mupo-reset-modal__close{position:absolute;top:14px;right:14px;width:36px;height:36px;border:1px solid var(--mupo-line);border-radius:8px;background:#fff;color:var(--mupo-navy);display:grid;place-items:center;cursor:pointer}.mupo-reset-modal__close:hover{background:var(--mupo-red);border-color:var(--mupo-red);color:#fff}.mupo-reset-modal__brand{display:inline-flex;padding:8px 10px;margin-bottom:18px;background:#fff;border:1px solid var(--mupo-line);border-radius:8px}.mupo-reset-modal__brand img{display:block;width:128px;height:auto}.mupo-reset-modal__icon{width:48px;height:48px;border-radius:9px;display:grid;place-items:center;margin-bottom:14px;background:#fff1f2;color:var(--mupo-red);font-size:20px}.mupo-reset-modal h3{margin:0 44px 7px 0;color:var(--mupo-navy);font-size:25px;font-weight:900}.mupo-reset-modal__text{margin:0 0 18px;color:var(--mupo-muted);line-height:1.55;font-size:13px}.mupo-reset-modal__alert{border-radius:8px;padding:10px 12px;margin-bottom:12px;font-size:12px;line-height:1.4}.mupo-reset-modal__alert--success{background:#ecfdf3;border:1px solid #a6f4c5;color:#067647}.mupo-reset-modal__alert--error{background:#fff1f2;border:1px solid #fecdd3;color:#b42318}.mupo-reset-modal__field label{display:block;margin-bottom:7px;color:var(--mupo-navy);font-size:12px;font-weight:800}.mupo-reset-modal__input-wrap{position:relative}.mupo-reset-modal__input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#98a2b3}.mupo-reset-modal__field input{width:100%;min-height:50px;padding:11px 12px 11px 42px;border:1px solid var(--mupo-line);border-radius:9px;background:#fff;color:var(--mupo-text);font-size:13px;outline:none}.mupo-reset-modal__field input:focus{border-color:var(--mupo-navy);box-shadow:0 0 0 3px rgba(6,23,56,.07)}.mupo-reset-modal__submit{width:100%;min-height:50px;margin-top:14px;border:0;border-radius:9px;background:var(--mupo-red);color:#fff;display:flex;align-items:center;justify-content:center;gap:8px;font-size:14px;font-weight:900;cursor:pointer}.mupo-reset-modal__support{display:flex;justify-content:center;margin-top:14px;color:var(--mupo-muted);font-size:12px}.mupo-reset-modal__support a{color:var(--mupo-navy);font-weight:900}
@media(max-width:1050px){.mupo-auth-shell{grid-template-columns:40% 1fr}.mupo-auth-brand-inner{padding:34px}.mupo-auth-main{padding:44px}.mupo-brand-copy h1{font-size:46px}.mupo-brand-copy p{font-size:16px}}
@media(max-width:820px){.mupo-auth-shell{grid-template-columns:1fr}.mupo-auth-brand-panel{min-height:330px}.mupo-auth-brand-inner{padding:26px}.mupo-brand-logo{margin-top:28px}.mupo-brand-copy{padding:38px 0 20px}.mupo-brand-copy h1{font-size:40px}.mupo-brand-copy p{font-size:15px;margin-top:14px}.mupo-brand-footer{display:none}.mupo-auth-main{min-height:auto;padding:44px 24px 54px}}
@media(max-width:520px){.mupo-auth-brand-panel{min-height:290px}.mupo-auth-brand-inner{padding:22px}.mupo-brand-logo img{width:145px}.mupo-brand-copy{padding:28px 0 12px}.mupo-brand-copy h1{font-size:34px}.mupo-brand-copy p{font-size:14px}.mupo-auth-main{padding:36px 18px 48px}.mupo-auth-content h2{font-size:32px!important}.mupo-auth-sub{margin-bottom:28px}.mupo-auth-row{align-items:flex-start;flex-direction:column;gap:12px}}
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
                    <div class="mupo-brand-kicker">Empowering minds. Building futures.</div>
                    <h1>Welcome back.</h1>
                    <p>Continue your learning journey with accredited, practical and industry-relevant training from Mupo Training Center.</p>
                    <div class="mupo-brand-line"></div>
                </div>

                <div class="mupo-brand-footer">
                    <span>Learn</span><span>Grow</span><span>Succeed</span>
                </div>
            </div>
        </aside>

        <main class="mupo-auth-main">
            <section class="mupo-auth-content">
                <div class="mupo-auth-eyebrow">Mupo Training Center</div>
                <h2>Sign in to your account</h2>
                <p class="mupo-auth-sub">Enter your registered email address and password to access your learning portal.</p>

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
                                <span class="text-danger" role="alert">{{$errors->first('g-recaptcha-response')}}</span>
                            @endif
                        </div>
                    @endif

                    <div class="mupo-auth-row">
                        <label class="mupo-auth-check">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="1">
                            <span>Remember me</span>
                        </label>
                        <button type="button" class="mupo-reset-trigger" data-reset-modal-open aria-haspopup="dialog" aria-controls="mupoResetModal">Forgot password?</button>
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

                    <div class="mupo-auth-divider"></div>
                    <p class="mupo-note">New to Mupo Training Center? <a href="{{ route('register') }}">Create an account</a></p>
                </form>

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
        <div class="mupo-reset-modal__icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></div>
        <h3 id="mupoResetModalTitle">Reset your password</h3>
        <p class="mupo-reset-modal__text">Enter your registered email address and we will send you a secure password reset link.</p>

        @if(session('status'))
            <div class="mupo-reset-modal__alert mupo-reset-modal__alert--success"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> {{ session('status') }}</div>
        @endif
        @if(old('reset_request') && $errors->has('email'))
            <div class="mupo-reset-modal__alert mupo-reset-modal__alert--error"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i> {{ $errors->first('email') }}</div>
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
            <button type="submit" class="mupo-reset-modal__submit"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i><span>Send Reset Link</span></button>
        </form>
        <div class="mupo-reset-modal__support">Need help?&nbsp;<a href="{{ route('contact') }}">Contact MUPO support</a></div>
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
        window.setTimeout(function () { if (emailInput) emailInput.focus(); }, 80);
    }
    function closeResetModal() {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('mupo-modal-open');
        if (lastFocusedElement) lastFocusedElement.focus();
    }
    openers.forEach(function (button) { button.addEventListener('click', openResetModal); });
    closers.forEach(function (button) { button.addEventListener('click', closeResetModal); });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal && modal.classList.contains('is-open')) closeResetModal();
    });

    const shouldOpenResetModal = @json(
        request()->boolean('forgot') ||
        session()->has('status') ||
        old('reset_request')
    );
    if (shouldOpenResetModal) openResetModal();
});

$('form').submit(function () {
    $(this).find(':submit').attr('disabled', true);
});
</script>
@endsection
