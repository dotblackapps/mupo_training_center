@include(theme('partials._header'))


<style id="mupo-learner-layout-fix">
:root{
    --mupo-navy:#061b3a;
    --mupo-navy-2:#0a2a52;
    --mupo-red:#ed1c24;
    --mupo-bg:#f5f7fa;
    --mupo-text:#0a1f44;
    --mupo-muted:#667085;
    --mupo-line:#e3e8ef;
    --mupo-white:#fff;
    --mupo-sidebar:250px;
    --mupo-sidebar-collapsed:78px;
    --mupo-topbar:70px;
}

html,body{
    margin:0!important;
    padding-top:0!important;
    background:var(--mupo-bg)!important;
}

.dashboard_main_wrapper{
    min-height:100vh!important;
    width:100%!important;
    margin:0!important;
    padding:0!important;
    background:var(--mupo-bg)!important;
    align-items:stretch!important;
}

/* ===== SIDEBAR ===== */
.mupo-learner-sidebar{
    background:linear-gradient(180deg,#061b3a 0%,#08294e 100%)!important;
    border:0!important;
    box-shadow:none!important;
    color:#fff;
}
.mupo-sidebar-brand{
    height:74px!important;
    min-height:74px!important;
    background:#fff!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    position:relative!important;
    border-right:1px solid var(--mupo-line)!important;
}
.mupo-sidebar-logo{display:flex;align-items:center;justify-content:center}
.mupo-sidebar-logo img{height:54px!important;width:auto!important;object-fit:contain!important}
.mupo-sidebar-collapse{
    position:absolute;right:-14px;top:22px;width:29px;height:29px;border-radius:50%;
    background:var(--mupo-navy);color:#fff;border:2px solid #fff;place-items:center;
    cursor:pointer;z-index:20;font-size:10px;box-shadow:0 4px 12px rgba(6,27,58,.15)
}
.mupo-sidebar-brand .sidebar_close_icon{position:absolute;right:15px;color:var(--mupo-navy)}
.mupo-sidebar-body{
    height:calc(100vh - 74px)!important;
    overflow:hidden!important;
    display:flex!important;
    flex-direction:column!important;
    padding:14px 12px 12px!important;
}
.mupo-sidebar-identity{padding:2px 12px 10px}
.mupo-sidebar-identity strong{display:block;font-size:11px;letter-spacing:1.5px;color:#fff}
.mupo-sidebar-identity span{display:block;margin-top:3px;font-size:11px;color:rgba(255,255,255,.65)}
.mupo-sidebar-identity b{color:var(--mupo-red);font-weight:700}
.mupo-sidebar-nav{display:flex!important;flex-direction:column!important;gap:0!important}
.mupo-nav-group{padding:9px 0;border-top:1px solid rgba(255,255,255,.12)}
.mupo-nav-label{
    padding:0 12px 6px;color:#91a6bf;font-size:8px;font-weight:800;
    letter-spacing:1.45px;white-space:nowrap
}
.mupo-sidebar-nav a{
    min-height:36px!important;padding:7px 11px!important;border-radius:6px!important;
    display:flex!important;align-items:center!important;gap:11px!important;
    position:relative!important;color:rgba(255,255,255,.9)!important;text-decoration:none!important;
    font-size:12px!important;font-weight:500!important;transition:.18s ease!important;white-space:nowrap
}
.mupo-sidebar-nav a i{width:19px!important;text-align:center!important;font-size:14px!important;color:#fff}
.mupo-sidebar-nav a:hover{background:rgba(255,255,255,.07)!important;color:#fff!important}
.mupo-sidebar-nav a.active{background:rgba(255,255,255,.08)!important;color:#fff!important}
.mupo-sidebar-nav a.active:before{
    content:"";position:absolute;left:-12px;top:4px;bottom:4px;width:4px;
    background:var(--mupo-red);border-radius:0 4px 4px 0
}
.mupo-sidebar-nav a.active i{color:#fff}
.mupo-support-group{padding-bottom:4px}
.mupo-sidebar-bottom{margin-top:auto;padding-top:7px}
.mupo-back-site{
    min-height:38px;padding:8px 11px;border:1px solid rgba(255,255,255,.26);
    border-radius:7px;color:#fff!important;text-decoration:none!important;display:flex;
    align-items:center;gap:10px;font-size:11px;font-weight:600;white-space:nowrap
}
.mupo-back-site:hover{background:#fff;color:var(--mupo-navy)!important}
.mupo-back-site i{width:19px;text-align:center}
.mupo-sidebar-motto{padding:13px 11px 0;display:flex;align-items:flex-start;gap:10px}
.mupo-sidebar-motto>span{width:3px;height:42px;background:var(--mupo-red);border-radius:4px;flex:0 0 auto}
.mupo-sidebar-motto strong{font-size:8px;line-height:1.5;letter-spacing:1.4px;color:rgba(255,255,255,.82)}

@media(min-width:992px){
    .dashboard_main_wrapper>.mupo-learner-sidebar,
    .dashboard_main_wrapper>.sidebar.mupo-learner-sidebar{
        position:fixed!important;inset:0 auto 0 0!important;width:var(--mupo-sidebar)!important;
        height:100vh!important;min-height:100vh!important;z-index:1040!important;overflow:visible!important;flex:none!important
    }
    .main_content.dashboard_part{
        width:calc(100% - var(--mupo-sidebar))!important;min-height:100vh!important;
        margin:0 0 0 var(--mupo-sidebar)!important;padding:0!important;background:var(--mupo-bg)!important;
        transition:width .2s ease,margin-left .2s ease!important
    }
    body.mupo-sidebar-collapsed .dashboard_main_wrapper>.mupo-learner-sidebar,
    body.mupo-sidebar-collapsed .dashboard_main_wrapper>.sidebar.mupo-learner-sidebar{width:var(--mupo-sidebar-collapsed)!important}
    body.mupo-sidebar-collapsed .main_content.dashboard_part{
        width:calc(100% - var(--mupo-sidebar-collapsed))!important;
        margin-left:var(--mupo-sidebar-collapsed)!important
    }
    body.mupo-sidebar-collapsed .mupo-sidebar-brand{justify-content:center!important}
    body.mupo-sidebar-collapsed .mupo-sidebar-logo img{height:42px!important;max-width:60px!important;object-fit:contain!important}
    body.mupo-sidebar-collapsed .mupo-sidebar-identity,
    body.mupo-sidebar-collapsed .mupo-nav-label,
    body.mupo-sidebar-collapsed .mupo-sidebar-nav a span,
    body.mupo-sidebar-collapsed .mupo-back-site span,
    body.mupo-sidebar-collapsed .mupo-sidebar-motto{display:none!important}
    body.mupo-sidebar-collapsed .mupo-sidebar-body{padding-left:9px!important;padding-right:9px!important}
    body.mupo-sidebar-collapsed .mupo-sidebar-nav a,
    body.mupo-sidebar-collapsed .mupo-back-site{
        justify-content:center!important;padding-left:0!important;padding-right:0!important
    }
    body.mupo-sidebar-collapsed .mupo-sidebar-nav a i,
    body.mupo-sidebar-collapsed .mupo-back-site i{width:auto!important;font-size:16px!important}
    body.mupo-sidebar-collapsed .mupo-nav-group{padding:8px 0}
    body.mupo-sidebar-collapsed .mupo-sidebar-collapse i{transform:none}
}

@media(min-width:992px) and (max-width:1279.98px){
    .main_content.dashboard_part{
        width:calc(100% - var(--mupo-sidebar-collapsed))!important;
        margin-left:var(--mupo-sidebar-collapsed)!important
    }
    .mupo-dashboard-topbar{left:var(--mupo-sidebar-collapsed)!important}
}

/* ===== TOP BAR ===== */
.mupo-dashboard-topbar{
    height:var(--mupo-topbar)!important;min-height:var(--mupo-topbar)!important;background:#fff!important;
    border-bottom:1px solid var(--mupo-line)!important;display:flex!important;align-items:center!important;
    justify-content:space-between!important;padding:0 26px!important;position:fixed!important;top:0!important;
    right:0!important;left:var(--mupo-sidebar)!important;width:auto!important;z-index:1030!important;
    transition:left .2s ease!important
}
.mupo-topbar-left{display:flex;align-items:center;gap:14px}
.mupo-page-context strong{display:block;color:var(--mupo-text);font-size:17px;line-height:1.1;font-weight:800}
.mupo-page-context span{display:block;color:#8490a2;font-size:10px;margin-top:5px}
.mupo-topbar-actions{display:flex;align-items:center;gap:15px}
.mupo-notification-btn{
    width:37px;height:37px;border-radius:50%;display:grid;place-items:center;color:var(--mupo-navy)!important;
    position:relative;text-decoration:none!important
}
.mupo-notification-btn:hover{background:#f4f6f8}
.mupo-notification-btn>span{
    position:absolute;top:0;right:0;min-width:16px;height:16px;padding:0 4px;border-radius:9px;
    background:var(--mupo-red);color:#fff;font-size:8px;font-weight:800;display:grid;place-items:center;border:2px solid #fff
}
.mupo-profile-menu{position:relative}
.mupo-profile-menu summary{list-style:none;cursor:pointer;display:flex;align-items:center;gap:9px}
.mupo-profile-menu summary::-webkit-details-marker{display:none}
.mupo-profile-avatar{
    width:40px;height:40px;border-radius:50%;background:var(--mupo-navy);color:#fff;display:grid;
    place-items:center;font-size:12px;font-weight:800;overflow:hidden
}
.mupo-profile-avatar img{width:100%;height:100%;object-fit:cover}
.mupo-profile-copy strong{display:block;color:var(--mupo-text);font-size:12px;line-height:1.2}
.mupo-profile-copy small{display:block;color:#7b8798;font-size:9px;margin-top:3px}
.mupo-profile-menu summary>i{font-size:9px;color:var(--mupo-navy)}
.mupo-profile-dropdown{
    position:absolute;top:51px;right:0;width:220px;background:#fff;border:1px solid var(--mupo-line);
    border-radius:9px;box-shadow:0 14px 35px rgba(6,27,58,.14);padding:7px;z-index:100
}
.mupo-profile-dropdown a{
    display:flex;align-items:center;gap:10px;padding:10px 11px;border-radius:6px;color:var(--mupo-text)!important;
    text-decoration:none!important;font-size:11px;font-weight:600
}
.mupo-profile-dropdown a:hover{background:#f5f7fa;color:var(--mupo-red)!important}
.mupo-profile-dropdown i{width:17px;text-align:center}
.mupo-profile-divider{height:1px;background:var(--mupo-line);margin:5px 4px}
.mupo-profile-dropdown .mupo-logout-link{color:var(--mupo-red)!important}

/* ===== SHARED CONTENT QUALITY FOR ALL LEARNER PAGES ===== */
.main_content.dashboard_part{background:var(--mupo-bg)!important;overflow:visible!important}
.main_content.dashboard_part .main_content_iner{
    background:var(--mupo-bg)!important;padding:calc(var(--mupo-topbar) + 18px) 22px 34px!important;margin:0!important;
    min-height:calc(100vh - var(--mupo-topbar))!important
}

@media(min-width:992px){
    body.mupo-sidebar-collapsed .mupo-dashboard-topbar{left:var(--mupo-sidebar-collapsed)!important}
}
.main_content.dashboard_part .container,
.main_content.dashboard_part .container-fluid{max-width:1500px!important}
.main_content.dashboard_part h1,
.main_content.dashboard_part h2,
.main_content.dashboard_part h3,
.main_content.dashboard_part h4,
.main_content.dashboard_part h5{color:var(--mupo-text)!important}
.main_content.dashboard_part .white_box,
.main_content.dashboard_part .dashboard_lg_card,
.main_content.dashboard_part .card,
.main_content.dashboard_part .table-responsive{
    background:#fff!important;border:1px solid var(--mupo-line)!important;border-radius:9px!important;
    box-shadow:0 5px 18px rgba(6,27,58,.035)!important
}
.main_content.dashboard_part .white_box{padding:20px!important}
.main_content.dashboard_part .primary-btn,
.main_content.dashboard_part .theme_btn,
.main_content.dashboard_part .btn-primary{
    background:var(--mupo-red)!important;border-color:var(--mupo-red)!important;color:#fff!important;border-radius:7px!important
}
.main_content.dashboard_part input.form-control,
.main_content.dashboard_part select.form-control,
.main_content.dashboard_part textarea.form-control{
    border-color:#dce2e9!important;border-radius:7px!important;box-shadow:none!important
}
.main_content.dashboard_part input.form-control:focus,
.main_content.dashboard_part select.form-control:focus,
.main_content.dashboard_part textarea.form-control:focus{
    border-color:#9caabd!important;box-shadow:0 0 0 3px rgba(6,27,58,.05)!important
}
.main_content.dashboard_part table thead th{
    background:#f7f8fa!important;color:var(--mupo-text)!important;border-bottom:1px solid var(--mupo-line)!important
}
.main_content.dashboard_part table td{border-color:#edf0f4!important}

/* Hide any legacy/public footer inside authenticated learner portal. */
.dashboard_main_wrapper + .footer,
.dashboard_main_wrapper ~ footer,
.dashboard_part footer,
.dashboard_part .footer{display:none!important}

@media(min-width:992px) and (max-height:780px){
    .mupo-sidebar-motto{display:none!important}
    .mupo-sidebar-body{padding-top:9px!important}
    .mupo-sidebar-identity{padding-bottom:6px}
    .mupo-nav-group{padding:6px 0}
    .mupo-sidebar-nav a{min-height:33px!important;padding-top:5px!important;padding-bottom:5px!important}
}
@media(max-width:991.98px){
    .dashboard_main_wrapper{display:block!important}
    .main_content.dashboard_part{width:100%!important;margin:0!important;min-height:100vh!important}
    .mupo-learner-sidebar{position:fixed!important;top:0!important;bottom:0!important;height:100vh!important;overflow:hidden!important}
    .mupo-learner-sidebar .mupo-sidebar-body{
        height:calc(100vh - 74px)!important;
        overflow-y:auto!important;
        scrollbar-width:none;
        -ms-overflow-style:none;
    }
    .mupo-learner-sidebar .mupo-sidebar-body::-webkit-scrollbar{display:none}
    .mupo-dashboard-topbar{left:0!important;padding:0 15px!important}
    .main_content.dashboard_part .main_content_iner{padding:calc(var(--mupo-topbar) + 14px) 14px 14px!important}
    .mupo-sidebar-collapse{display:none!important}
}
@media(max-width:640px){
    .mupo-profile-copy{display:none}
    .mupo-page-context strong{font-size:15px}
    .mupo-page-context span{font-size:9px}
}
</style>

<link href="{{ asset('mupo/assets/css/learning-portal-shell.css') }}?v={{ filemtime(public_path('mupo/assets/css/learning-portal-shell.css')) }}" rel="stylesheet">
<link href="{{ asset('mupo/assets/css/learner-dashboard-components.css') }}?v={{ filemtime(public_path('mupo/assets/css/learner-dashboard-components.css')) }}" rel="stylesheet">
<link href="{{ asset('mupo/assets/css/learner-workspace.css') }}?v={{ filemtime(public_path('mupo/assets/css/learner-workspace.css')) }}" rel="stylesheet">


<div class="dashboard_main_wrapper">
    @include(theme('partials._sidebar'))
    <button type="button" class="mupo-nav-overlay" id="mupoDashboardNavOverlay" aria-label="Close learner navigation"></button>

    <section
        class="main_content dashboard_part @if(\Illuminate\Support\Facades\Route::is('student.gamification.reward')) bg-none bg-body @endif">
        @include(theme('partials._dashboard_menu'))
        @yield('mainContent')
    </section>
</div>
@include('preloader')
<input type="hidden" name="app_debug" class="app_debug" value="{{env('APP_DEBUG') }}">

<script>
document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;
    var toggle = document.getElementById('mupoSidebarCollapse');
    var sidebar = document.getElementById('mupoLearnerSidebar');
    var mobileOpen = document.getElementById('mupoDashboardNavOpen');
    var mobileClose = sidebar ? sidebar.querySelector('.sidebar_close_icon') : null;
    var overlay = document.getElementById('mupoDashboardNavOverlay');

    function setMobileNavigation(open) {
        body.classList.toggle('mupo-portal-nav-open', Boolean(open));
        if (mobileOpen) {
            mobileOpen.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
    }

    if (window.innerWidth >= 992 && localStorage.getItem('mupoLearnerSidebarCollapsed') === '1') {
        body.classList.add('mupo-sidebar-collapsed');
    }

    if (toggle) {
        toggle.addEventListener('click', function () {
            body.classList.toggle('mupo-sidebar-collapsed');
            localStorage.setItem(
                'mupoLearnerSidebarCollapsed',
                body.classList.contains('mupo-sidebar-collapsed') ? '1' : '0'
            );
        });
    }

    if (mobileOpen) mobileOpen.addEventListener('click', function () { setMobileNavigation(true); });
    if (mobileClose) mobileClose.addEventListener('click', function () { setMobileNavigation(false); });
    if (overlay) overlay.addEventListener('click', function () { setMobileNavigation(false); });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') setMobileNavigation(false);
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) setMobileNavigation(false);
    });
});
</script>
