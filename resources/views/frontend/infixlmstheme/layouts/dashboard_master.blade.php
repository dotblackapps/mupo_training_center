@include(theme('partials._header'))


<style id="mupo-learner-layout-fix">
/*
 | MUPO learner portal shell
 | Front-end layout only. No routes, controllers, queries or form behaviour changed.
 */
:root{
    --mupo-navy:#061b3a;
    --mupo-navy-2:#0a2a52;
    --mupo-red:#ed1c24;
    --mupo-bg:#f5f7fa;
    --mupo-text:#0a1f44;
    --mupo-muted:#667085;
    --mupo-line:#e3e8ef;
    --mupo-white:#ffffff;
}

/* The public MUPO site uses a fixed header and therefore adds body top padding.
   Dashboard pages do not render that public header, so remove that reserved space. */
html,
body{
    margin:0 !important;
    padding-top:0 !important;
    background:var(--mupo-bg) !important;
}

/* Make the learner portal start at the very top of the viewport. */
.dashboard_main_wrapper{
    min-height:100vh !important;
    width:100% !important;
    margin:0 !important;
    padding:0 !important;
    background:var(--mupo-bg) !important;
    align-items:stretch !important;
}

/* Desktop: fixed learner navigation. The sidebar itself never scrolls. */
@media (min-width:992px){
    .dashboard_main_wrapper > .mupo-learner-sidebar,
    .dashboard_main_wrapper > .sidebar.mupo-learner-sidebar{
        position:fixed !important;
        inset:0 auto 0 0 !important;
        width:280px !important;
        height:100vh !important;
        min-height:100vh !important;
        z-index:1040 !important;
        overflow:hidden !important;
        flex:none !important;
    }

    .mupo-learner-sidebar .mupo-sidebar-brand{
        height:74px !important;
        min-height:74px !important;
    }

    .mupo-learner-sidebar .mupo-sidebar-body{
        height:calc(100vh - 74px) !important;
        max-height:calc(100vh - 74px) !important;
        overflow:hidden !important;
        display:flex !important;
        flex-direction:column !important;
        padding:16px 14px 14px !important;
    }

    .mupo-learner-sidebar .mupo-sidebar-nav{
        flex:0 0 auto !important;
        overflow:visible !important;
        padding:0 !important;
        margin:0 !important;
        gap:3px !important;
    }

    .mupo-learner-sidebar .mupo-sidebar-nav a{
        min-height:42px !important;
        padding:10px 13px !important;
        font-size:13px !important;
        border-radius:7px !important;
    }

    .mupo-learner-sidebar .mupo-sidebar-nav a i{
        width:20px !important;
        font-size:15px !important;
    }

    .mupo-learner-sidebar .mupo-sidebar-quote{
        margin-top:auto !important;
        padding:15px 8px 2px !important;
    }

    .main_content.dashboard_part{
        width:calc(100% - 280px) !important;
        min-height:100vh !important;
        margin:0 0 0 280px !important;
        padding:0 !important;
        background:var(--mupo-bg) !important;
        overflow:visible !important;
    }

    .mupo-dashboard-topbar{
        position:sticky !important;
        top:0 !important;
        z-index:1030 !important;
        margin:0 !important;
    }
}

/* Keep the quote from forcing sidebar scrolling on shorter laptop displays. */
@media (min-width:992px) and (max-height:820px){
    .mupo-learner-sidebar .mupo-sidebar-quote{
        display:none !important;
    }
    .mupo-learner-sidebar .mupo-sidebar-body{
        padding-bottom:10px !important;
    }
    .mupo-learner-sidebar .mupo-sidebar-nav a{
        min-height:39px !important;
        padding-top:8px !important;
        padding-bottom:8px !important;
    }
}

/* Shared content treatment across My Courses, Quizzes, Classes, Certificates,
   Purchases, Devices and Settings so they visually belong to the same portal. */
.main_content.dashboard_part .main_content_iner{
    background:var(--mupo-bg) !important;
    padding:22px 24px 36px !important;
    margin:0 !important;
    min-height:calc(100vh - 74px) !important;
}

.main_content.dashboard_part .dashboard_lg_card,
.main_content.dashboard_part .white_box,
.main_content.dashboard_part .card,
.main_content.dashboard_part .table-responsive{
    border-color:var(--mupo-line) !important;
}

.main_content.dashboard_part .dashboard_lg_card,
.main_content.dashboard_part .white_box{
    background:#fff !important;
    border:1px solid var(--mupo-line) !important;
    border-radius:10px !important;
    box-shadow:0 5px 16px rgba(6,27,58,.035) !important;
}

/* MUPO navigation styling shared by every learner dashboard page. */
.mupo-learner-sidebar{
    background:linear-gradient(180deg,var(--mupo-navy) 0%,#08294e 100%) !important;
    border:0 !important;
    box-shadow:none !important;
}
.mupo-sidebar-brand{
    background:#fff !important;
    border-right:1px solid var(--mupo-line) !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
}
.mupo-sidebar-brand img{
    height:54px !important;
    width:auto !important;
    object-fit:contain !important;
}
.mupo-sidebar-nav{
    display:flex !important;
    flex-direction:column !important;
}
.mupo-sidebar-nav a{
    position:relative !important;
    color:#fff !important;
    display:flex !important;
    align-items:center !important;
    gap:12px !important;
    text-decoration:none !important;
    font-weight:600 !important;
    transition:.2s ease !important;
}
.mupo-sidebar-nav a:hover{
    background:rgba(255,255,255,.09) !important;
    color:#fff !important;
}
.mupo-sidebar-nav a.active{
    background:var(--mupo-red) !important;
    color:#fff !important;
}
.mupo-sidebar-nav a.active:before{
    content:"";
    position:absolute;
    left:-14px;
    top:8px;
    bottom:8px;
    width:3px;
    background:#fff;
    border-radius:0 3px 3px 0;
}
.mupo-sidebar-quote{
    color:#fff !important;
    border-top:1px solid rgba(255,255,255,.18) !important;
}
.mupo-sidebar-quote > span{
    display:block;
    width:34px;
    height:3px;
    background:var(--mupo-red);
    margin-bottom:10px;
}
.mupo-sidebar-quote p{
    color:#fff !important;
    font-size:11px !important;
    line-height:1.45 !important;
    margin:0 0 5px !important;
}
.mupo-sidebar-quote small{
    color:rgba(255,255,255,.6) !important;
}

/* Header shared by every learner page. */
.mupo-dashboard-topbar{
    height:74px !important;
    min-height:74px !important;
    background:#fff !important;
    border-bottom:1px solid var(--mupo-line) !important;
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
    padding:0 28px !important;
}

/* Mobile/tablet keeps the existing off-canvas behaviour. */
@media (max-width:991.98px){
    html,body{padding-top:0 !important;}
    .dashboard_main_wrapper{display:block !important;}
    .main_content.dashboard_part{
        width:100% !important;
        margin:0 !important;
        min-height:100vh !important;
    }
    .mupo-learner-sidebar{
        position:fixed !important;
        top:0 !important;
        bottom:0 !important;
        height:100vh !important;
        overflow:hidden !important;
    }
    .mupo-learner-sidebar .mupo-sidebar-body{
        height:calc(100vh - 74px) !important;
        overflow-y:auto !important;
    }
    .main_content.dashboard_part .main_content_iner{
        padding:16px !important;
    }
    .mupo-dashboard-topbar{
        position:sticky !important;
        top:0 !important;
        z-index:1030 !important;
        padding:0 16px !important;
    }
}
</style>


<div class="dashboard_main_wrapper">
    @include(theme('partials._sidebar'))

    <section
        class="main_content dashboard_part @if(\Illuminate\Support\Facades\Route::is('student.gamification.reward')) bg-none bg-body @endif">
        @include(theme('partials._dashboard_menu'))
        @yield('mainContent')
    </section>
</div>
@include('preloader')
<input type="hidden" name="app_debug" class="app_debug" value="{{env('APP_DEBUG') }}">
@include(theme('partials._footer'))
