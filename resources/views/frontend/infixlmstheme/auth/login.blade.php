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
                <h1>Welcome back to your learning portal.</h1>
                <p>Login to access courses, progress, assessments, learner notices, admin tools and support services.</p>
                <div class="mupo-auth-steps">
                    <div class="mupo-auth-step"><b>Learners</b><br>Continue training and track your learning progress.</div>
                    <div class="mupo-auth-step"><b>Admins</b><br>Manage learners, registrations, courses and reports.</div>
                    <div class="mupo-auth-step"><b>Support</b><br>Request course or administrative assistance.</div>
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

                       
                        <a href="{{route('SendPasswordResetLink')}}" class="mupo-auth-forgot">Forgot Password?</a>
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

{!! Toastr::message() !!}
<script>
    $('form').submit(function () {
        $(":submit").attr("disabled", true);
    });
</script>
@endsection
