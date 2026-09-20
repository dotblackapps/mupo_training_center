@php use Illuminate\Support\Carbon;use Modules\BunnyStorage\Http\Controllers\BunnyStreamController; @endphp
@extends(theme('layouts.full_screen_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{ $course->title}}
@endsection
@section('css')
    <link href="{{assetPath('backend/css/jquery-ui.css')}}{{assetVersion()}}" rel="stylesheet">
    <link href="{{assetPath('frontend/infixlmstheme/css/full_screen.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{ asset('mupo/assets/css/course-learning.css') }}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{ asset('mupo/assets/css/learning-portal-shell.css') }}?v={{ filemtime(public_path('mupo/assets/css/learning-portal-shell.css')) }}" rel="stylesheet"/>
    <link href="{{ asset('mupo/assets/css/guided-instructor.css') }}?v={{ filemtime(public_path('mupo/assets/css/guided-instructor.css')) }}" rel="stylesheet"/>

    {{-- <link href="{{assetPath('frontend/infixlmstheme/css/class_details.css')}}{{assetVersion()}}" rel="stylesheet"/> --}}
    <link href="{{assetPath('backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">

    @if(isModuleActive("WhatsappSupport"))
        <link rel="stylesheet" href="{{assetPath('whatsapp-support/style.css')}}{{assetVersion()}}"/>
    @endif

    <style>
        .default-font {
            font-family: "Jost", sans-serif;
            font-weight: normal;
            font-style: normal;
            font-weight: 400;
        }

        .primary_checkbox {
            z-index: 99;
        }

        @media (max-width: 767.98px) {
            .contact_btn {
                margin: 0 !important;
                justify-content: space-between;
            }

            #video-placeholder {
                height: 300px;
            }
        }

        .course__play_warp.courseListPlayer:before {
            background-color: transparent;
        }

        @media (max-width: 991.98px) {
            .mobile-min-height {
                height: 330px !important;
            }
        }

        #ExternalHeaderViewerChromeTopBars {
            display: none !important;
        }

        .quiz_questions_wrapper {
            height: 100%;
        }

        .question_number_lists {
            max-height: 320px;
            overflow: auto;
        }

        .logo_img {
            height: 50px !important;
        }

        @media (max-width: 991.98px) {
            .header_area .header__wrapper .header__left .logo_img img {
                padding: .5rem !important
            }
        }

        .inline-YTPlayer {
            height: auto !important;
        }

        .quiz_score_wrapper .quiz_test_body .score_view_wrapper {
            justify-content: space-around;
        }

        html[dir=rtl] .fa-angle-left,
        html[dir=rtl] .fa-angle-right {
            transform: scaleX(-1)
        }

        @media (max-width: 991px) {
            .course_fullview_wrapper .video_iframe {
                position: initial !important;
                height: 400px;
                width: 100%;
            }
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 550px;
            }
        }

        @media (min-width: 1080px) {
            .modal-dialog {
                max-width: 800px;
            }
        }

        .conversition_box .single_comment_box .comment_box_inner .comment_box_info .comment_box_text span {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 10px;
            margin-top: 2px;
            display: block;
            color: #7b7887;
        }

        .header__common_btn {
            border: 0 !important;
        }

        .header__common_btn:hover {
            background-position: right !important;
            color: white !important;
        }

    </style>
    <style>
        .nice-select.quiz-select {
            padding-right: 50px;
            height: 30px;
        }

        html[dir="rtl"] .nice-select.quiz-select {
            padding-left: 50px;
            padding-right: 20px;
        }

        .select-wrapper .nice-select .current {
            line-height: 30px;
        }

        .question_title_quiz p {
            flex-wrap: wrap;
            vertical-align: middle;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* drawflow */

        .drawflow_content_node .image-preview {
            height: 60px;
            background: #f1f1f1;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #D1D1D1;
        }

        .drawflow_content_node .image-preview img {
            height: 60px;
            width: 100px;
            object-fit: cover;
            min-width: 100px
        }

        .drawflow_content_node .option_title,
        .drawflow_content_node .ans_title {
            flex-grow: 1;
        }

        .drawflow_content_node .primary_label2 {
            gap: 10px;
        }

        /* .ansNode .drawflow_content_node .primary_label2{
            flex-direction: row-reverse;
        } */

        .drawflow_content_node .option_title,
        .drawflow_content_node .ans_title {
            height: 60px;
            font-size: 22px;
        }

        .drawflow {
            min-width: 900px;
            overflow: auto;
            max-width: 100%;
            width: 100%;
        }

        .drawflow .drawflow-node {
            width: calc(100% / 12 * 5) !important;
        }

        .parent-drawflow {
            overflow: auto !important;
        }

        @media (max-width: 767px) {
            .quiz_secondary_btn, .quiz_primary_btn {
                font-size: 16px;
                padding: 0px 20px;
                height: 50px;
                line-height: 50px;
            }

            .question_number_lists a {
                height: 40px;
                width: 40px;
                line-height: 40px;
                flex: 40px 0 0;
                font-size: 16px;
            }

            .question_number_lists {
                gap: 10px;
                margin-bottom: 10px;
            }

            .drawflow_content_node .option_title,
            .drawflow_content_node .ans_title {
                height: 50px;
                font-size: 22px;
            }

            .drawflow_content_node .image-preview img {
                height: 50px;
                width: 80px;
                min-width: 80px;
            }

            .drawflow_content_node .image-preview {
                height: 50px;
            }

            .drawflow {
                min-width: 600px;
            }
        }

        .sumit_skip_btns {
            margin-top: 20px;
        }

        .nice-select.quiz-select {
            padding-right: 30px;
        }

        .question_title_quiz p * {
            vertical-align: middle
        }

        html[dir='rtl'] .drawflow {
            direction: ltr;
        }

        html[dir='rtl'] .drawflow .connection {
            right: auto;
            left: 0;
        }

    </style>
    <style>
        .quiz_questions_wrapper .quiz_test_header .quiz_header_right p {
            color: #ffffff;
        }

        .course_fullview_wrapper:not(.video) {
            height: auto;
        }

        .multypol_qustion p {
            flex-wrap: wrap;
            vertical-align: middle;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        html[dir="rtl"] .course_fullview_wrapper .course__play_warp {
            top: var(--top);
        }

        html[dir="rtl"] .header_area {
            position: fixed;
            padding-left: 0;
            padding-right: 0;
        }

        html[dir="rtl"] .floating-title {
            left: 0px;
            right: auto;
        }

        html[dir="rtl"] .lmsSwitch_toggle input:checked + .slider:before {
            transform: translateY(-50%) translateX(-18px);
        }

        .plyr.plyr--full-ui {
            height: 100%;
            width: 100%;
        }

        .plyr__controls__item.plyr__progress__container {
            flex-grow: 1;
        }


    </style>
    <style id="mupo-premium-learning-workspace">
        :root{
            --mupo-navy:#061b3a;
            --mupo-navy-2:#0a2a52;
            --mupo-red:#ed1c24;
            --mupo-bg:#f5f7fa;
            --mupo-line:#e2e7ee;
            --mupo-text:#0a1f44;
            --mupo-muted:#667085;
            --mupo-green:#159957;
            --mupo-side-expanded:250px;
            --mupo-panel-safe-gap:0px;
            --mupo-side:var(--mupo-side-expanded);
            --mupo-head:74px;
            --mupo-bottom:76px;
            --mupo-reading:900px;
        }

        html,body{
            margin:0!important;
            padding:0!important;
            background:var(--mupo-bg)!important;
            overflow:hidden!important;
        }

        body{
            font-family:"Jost",sans-serif!important;
            color:var(--mupo-text)!important;
            font-size:16px!important;
        }

        /* ===== TOP LEARNING BAR ===== */
        #sticky-header.header_area{
            position:fixed!important;
            top:0!important;
            left:0!important;
            right:0!important;
            width:auto!important;
            max-width:none!important;
            box-sizing:border-box!important;
            height:var(--mupo-head)!important;
            background:#fff!important;
            border-bottom:1px solid var(--mupo-line)!important;
            z-index:1090!important;
            box-shadow:0 2px 10px rgba(6,27,58,.025)!important;
            padding:0!important;
        }

        #sticky-header .container-fluid,
        #sticky-header .row,
        #sticky-header .col-12,
        #sticky-header .header__wrapper{
            height:100%!important;
        }

        #sticky-header .header__wrapper{
            padding:0 28px!important;
            display:flex!important;
            align-items:center!important;
            justify-content:space-between!important;
            gap:24px!important;
            flex-wrap:nowrap!important;
        }

        #sticky-header .header__left{
            min-width:0!important;
            gap:22px!important;
        }

        .logo_img{
            height:auto!important;
            border-right:1px solid var(--mupo-line);
            padding-right:22px;
        }

        .logo_img img{
            width:132px!important;
            height:58px!important;
            object-fit:contain!important;
            padding:4px!important;
        }

        .mupo-exit-course{
            display:inline-flex;
            align-items:center;
            gap:9px;
            color:var(--mupo-text)!important;
            font-size:14px;
            font-weight:700;
            white-space:nowrap;
            text-decoration:none!important;
        }

        .mupo-exit-course:hover{color:var(--mupo-red)!important}

        #sticky-header .category_search{
            display:flex!important;
            min-width:0!important;
        }

        .category_box_iner{
            border:0!important;
            background:transparent!important;
        }

        .input-group-prepend2{
            padding-left:0!important;
            min-width:0;
        }

        h4.headerTitle{
            font-size:20px!important;
            line-height:1.15!important;
            color:var(--mupo-text)!important;
            margin:0!important;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            max-width:500px;
            font-weight:800!important;
            letter-spacing:-.2px;
        }

        .mupo-header-breadcrumb{
            display:flex;
            align-items:center;
            gap:7px;
            font-size:12px;
            color:#758195;
            margin-top:7px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            max-width:520px;
        }

        .mupo-header-breadcrumb .mupo-breadcrumb-separator{color:#a0aabd;flex:0 0 auto}
        .mupo-header-breadcrumb .mupo-breadcrumb-module,
        .mupo-header-breadcrumb .mupo-breadcrumb-lesson{min-width:0;overflow:hidden;text-overflow:ellipsis}
        .mupo-header-breadcrumb b{color:var(--mupo-text)}
        #sticky-header .header__right{margin-left:auto!important;min-width:0!important;flex:0 0 auto!important}
        .contact_wrap,.contact_btn{flex-wrap:nowrap!important}

        .mupo-header-progress{
            width:250px;
            padding:0 24px;
            border-left:1px solid var(--mupo-line);
            border-right:1px solid var(--mupo-line);
        }

        .mupo-header-progress-top{
            display:flex;
            justify-content:space-between;
            gap:10px;
            font-size:11px;
            color:var(--mupo-muted);
            margin-bottom:6px;
        }

        .mupo-header-progress-top strong{
            font-size:14px;
            color:var(--mupo-text);
        }

        .mupo-progress-line{
            height:7px;
            background:#e7ebf0;
            border-radius:10px;
            overflow:hidden;
        }

        .mupo-progress-line span{
            display:block;
            height:100%;
            background:var(--mupo-red);
            border-radius:10px;
        }

        .mupo-header-progress>div:last-child{
            font-size:11px!important;
            margin-top:6px!important;
        }

        .mupo-header-tools{
            display:flex;
            align-items:center;
            gap:4px;
            margin-left:12px;
        }

        .mupo-tool-btn{
            min-width:62px;
            height:58px;
            border:0;
            background:transparent;
            color:var(--mupo-navy);
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:5px;
            border-radius:8px;
            font-size:11px;
            font-weight:700;
            text-decoration:none!important;
            cursor:pointer;
        }

        .mupo-tool-btn i{font-size:18px}
        .mupo-tool-btn:hover,
        .mupo-tool-btn.is-active{
            background:#f2f5f8;
            color:var(--mupo-red)!important;
        }

        .header__common_btn.dropdown{
            margin-left:4px!important;
            width:44px!important;
            height:44px!important;
            border:0!important;
            background:transparent!important;
            color:var(--mupo-navy)!important;
        }

        /* ===== MAIN LESSON READING WORKSPACE ===== */
        .course_fullview_wrapper{
            position:fixed!important;
            top:var(--mupo-head)!important;
            left:0!important;
            right:calc(var(--mupo-side) + var(--mupo-panel-safe-gap))!important;
            bottom:var(--mupo-bottom)!important;
            width:auto!important;
            height:auto!important;
            min-height:0!important;
            background:var(--mupo-bg)!important;
            overflow-y:auto!important;
            overflow-x:hidden!important;
            padding:24px 28px 36px!important;
            display:block!important;
            scroll-behavior:smooth;
            scrollbar-width:thin;
            scrollbar-color:#9eabbc #edf1f5;
            scrollbar-gutter:stable;
            transition:right .22s ease;
        }

        .course_fullview_wrapper::-webkit-scrollbar{width:9px}
        .course_fullview_wrapper::-webkit-scrollbar-track{background:#edf1f5}
        .course_fullview_wrapper::-webkit-scrollbar-thumb{
            background:#9eabbc;
            border:2px solid #edf1f5;
            border-radius:999px;
        }
        .course_fullview_wrapper::-webkit-scrollbar-thumb:hover{background:#748398}

        .course_fullview_wrapper.video{background:var(--mupo-bg)!important}
        .course_fullview_wrapper.video:before{display:none!important}

        .mupo-lesson-context{
            max-width:var(--mupo-reading);
            margin:0 auto 14px;
            background:#fff;
            border:1px solid var(--mupo-line);
            border-radius:10px;
            padding:15px 18px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            box-shadow:0 4px 14px rgba(6,27,58,.025);
        }

        .mupo-lesson-context strong{
            display:block;
            font-size:15px;
            line-height:1.3;
            color:var(--mupo-text);
            font-weight:800;
        }

        .mupo-lesson-context span{
            font-size:13px;
            color:var(--mupo-muted);
            line-height:1.4;
        }

        .mupo-lesson-status{
            display:inline-flex!important;
            align-items:center;
            min-height:32px;
            padding:0 12px;
            border-radius:18px;
            background:#eef4fb;
            color:#47617e!important;
            font-size:12px!important;
            font-weight:700;
            white-space:nowrap;
        }

        .mupo-lesson-status.completed{
            background:#eaf7f0;
            color:var(--mupo-green)!important;
        }

        .mupo-editor-heading{
            max-width:var(--mupo-reading);
            margin:0 auto 14px;
            padding:28px 32px;
            border-radius:10px;
            background:linear-gradient(115deg,#061b3a 0%,#0b315e 100%);
            color:#fff;
            position:relative;
            overflow:hidden;
        }

        .mupo-editor-heading:after{
            content:"";
            position:absolute;
            width:190px;
            height:190px;
            border-radius:50%;
            right:-65px;
            top:-85px;
            background:rgba(255,255,255,.05);
        }

        .mupo-editor-kicker{
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:8px;
            color:#ff4a51;
            font-size:12px;
            font-weight:900;
            letter-spacing:1.4px;
            text-transform:uppercase;
        }

        .mupo-editor-kicker:before{
            content:"";
            width:28px;
            height:3px;
            border-radius:4px;
            background:var(--mupo-red);
        }

        .mupo-editor-heading h1{
            color:#fff!important;
            font-size:36px!important;
            line-height:1.08!important;
            letter-spacing:-.6px;
            margin:0!important;
            font-weight:800!important;
        }

        .mupo-editor-heading p{
            color:rgba(255,255,255,.82)!important;
            font-size:16px!important;
            line-height:1.6!important;
            margin:10px 0 0!important;
            max-width:700px;
        }

        .lesson_content_text{
            max-width:var(--mupo-reading)!important;
            margin:0 auto!important;
            background:#fff!important;
            border:1px solid var(--mupo-line)!important;
            border-radius:10px!important;
            padding:42px 46px!important;
            color:#263b57!important;
            font-size:17px!important;
            line-height:1.72!important;
            box-shadow:0 8px 26px rgba(6,27,58,.035)!important;
        }

        .lesson_content_text>*:first-child{margin-top:0!important}
        .lesson_content_text>*:last-child{margin-bottom:0!important}

        .lesson_content_text h1,
        .lesson_content_text h2,
        .lesson_content_text h3,
        .lesson_content_text h4,
        .lesson_content_text h5{
            color:var(--mupo-text)!important;
            font-weight:800!important;
            line-height:1.25!important;
            letter-spacing:-.2px;
        }

        .lesson_content_text h1{
            font-size:34px!important;
            margin:0 0 18px!important;
        }

        .lesson_content_text h2{
            font-size:27px!important;
            margin:34px 0 14px!important;
            padding-top:4px;
        }

        .lesson_content_text h3{
            font-size:22px!important;
            margin:28px 0 12px!important;
        }

        .lesson_content_text h4{
            font-size:19px!important;
            margin:24px 0 10px!important;
        }

        .lesson_content_text p{
            color:#344b67!important;
            font-size:17px!important;
            line-height:1.72!important;
            margin:0 0 16px!important;
        }

        .lesson_content_text ul,
        .lesson_content_text ol{
            margin:12px 0 22px!important;
            padding-left:26px!important;
        }

        .lesson_content_text li{
            color:#344b67!important;
            font-size:17px!important;
            line-height:1.65!important;
            margin:7px 0!important;
            padding-left:3px;
        }

        .lesson_content_text strong{color:var(--mupo-text)!important}
        .lesson_content_text a{color:var(--mupo-red)!important;font-weight:600}

        .lesson_content_text blockquote{
            margin:24px 0!important;
            padding:18px 20px!important;
            background:#f7f9fb!important;
            border-left:4px solid var(--mupo-red)!important;
            border-radius:0 8px 8px 0!important;
            color:#344b67!important;
        }

        .lesson_content_text table{
            width:100%!important;
            border-collapse:separate!important;
            border-spacing:0!important;
            margin:24px 0!important;
            border:1px solid var(--mupo-line)!important;
            border-radius:8px!important;
            overflow:hidden!important;
        }

        .lesson_content_text th{
            background:#f4f6f9!important;
            color:var(--mupo-text)!important;
            font-weight:800!important;
        }

        .lesson_content_text td,
        .lesson_content_text th{
            border:0!important;
            border-bottom:1px solid var(--mupo-line)!important;
            padding:13px 14px!important;
            font-size:15px!important;
            vertical-align:top!important;
        }

        .lesson_content_text tr:last-child td{border-bottom:0!important}

        /* Give plain imported learner-manual content stronger visual rhythm. */
        .lesson_content_text>p:first-child{
            color:var(--mupo-red)!important;
            font-size:13px!important;
            font-weight:800!important;
            letter-spacing:1.2px!important;
            text-transform:uppercase!important;
            margin-bottom:8px!important;
        }

        .lesson_content_text>p:nth-child(2){
            color:var(--mupo-text)!important;
            font-size:29px!important;
            line-height:1.2!important;
            font-weight:800!important;
            margin-bottom:12px!important;
        }

        /* ===== RIGHT COURSE CONTENT ===== */
        .floating-title{display:none!important}

        .course__play_warp.courseListPlayer{
            position:fixed!important;
            top:var(--mupo-head)!important;
            right:0!important;
            bottom:var(--mupo-bottom)!important;
            width:var(--mupo-side)!important;
            min-width:var(--mupo-side)!important;
            max-width:var(--mupo-side)!important;
            flex:0 0 var(--mupo-side)!important;
            box-sizing:border-box!important;
            height:auto!important;
            background:#fff!important;
            z-index:1060!important;
            border-left:1px solid var(--mupo-line)!important;
            box-shadow:-8px 0 22px rgba(6,27,58,.025)!important;
            overflow:hidden!important;
            transform:none!important;
            transition:width .22s ease, transform .22s ease!important;
        }

        .course__play_warp.courseListPlayer:before{display:none!important}
        #mupoCoursePanelContent{height:100%;overflow:hidden}

        .play_warp_header{
            height:auto!important;
            min-height:106px!important;
            background:var(--mupo-navy)!important;
            color:#fff!important;
            padding:20px 22px!important;
            display:block!important;
        }

        .mupo-content-head{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:10px;
        }

        .mupo-content-head h3{
            color:#fff!important;
            font-size:20px!important;
            margin:0!important;
            font-weight:800!important;
        }

        .mupo-content-head strong{
            color:#fff;
            font-size:16px;
        }

        .mupo-content-sub{
            font-size:12px;
            color:rgba(255,255,255,.72);
            margin:5px 0 10px;
        }

        .mupo-side-search{
            padding:13px 16px;
            border-bottom:1px solid var(--mupo-line);
            background:#fff;
        }

        .mupo-side-search-wrap{position:relative}

        .mupo-side-search i{
            position:absolute;
            left:13px;
            top:50%;
            transform:translateY(-50%);
            color:var(--mupo-navy);
            font-size:15px;
        }

        .mupo-side-search input{
            width:100%;
            height:44px;
            border:1px solid #d8dfe8;
            border-radius:7px;
            padding:0 13px 0 40px;
            font-size:14px;
            color:var(--mupo-text);
            outline:none;
        }

        .mupo-side-search input::placeholder{color:#8b96a5}
        .mupo-side-search input:focus{
            border-color:#94a3b8;
            box-shadow:0 0 0 3px rgba(6,27,58,.05);
        }

        .course__play_list{
            height:calc(100% - 177px)!important;
            overflow-y:auto!important;
            padding:0!important;
            background:#fff!important;
            scrollbar-width:thin;
            scrollbar-color:#9eabbc #f2f5f8;
            scrollbar-gutter:stable;
        }

        .course__play_list::-webkit-scrollbar{width:8px}
        .course__play_list::-webkit-scrollbar-track{background:#f2f5f8}
        .course__play_list::-webkit-scrollbar-thumb{
            background:#9eabbc;
            border:2px solid #f2f5f8;
            border-radius:999px;
        }
        .course__play_list::-webkit-scrollbar-thumb:hover{background:#748398}

        .theme_according{margin:0!important}
        .theme_according .accordion-item{
            border:0!important;
            border-bottom:1px solid #edf0f4!important;
            border-radius:0!important;
        }

        .theme_according .accordion-button{
            background:#fff!important;
            color:var(--mupo-text)!important;
            padding:16px 18px!important;
            font-size:15px!important;
            font-weight:800!important;
            box-shadow:none!important;
            line-height:1.3!important;
        }

        .theme_according .accordion-button:not(.collapsed){background:#f8fafc!important}
        .theme_according .accordion-button:after{transform:scale(.78)}

        .theme_according .course_length{
            font-size:11px!important;
            color:#8792a2!important;
            font-weight:500!important;
            margin-top:5px!important;
        }

        .theme_according .accordion-body{padding:7px 10px 11px!important}
        .single_play_list{margin:0!important}

        .single_play_list>a{
            min-height:48px!important;
            border:0!important;
            border-left:3px solid transparent!important;
            border-radius:7px!important;
            padding:9px 11px!important;
            display:flex!important;
            align-items:center!important;
            justify-content:space-between!important;
            background:#fff!important;
            transition:.15s ease!important;
        }

        .single_play_list>a:hover{background:#f7f9fb!important}

        .single_play_list>a.active{
            background:#fff1f2!important;
            border-left-color:var(--mupo-red)!important;
        }

        .single_play_list>a.active .course_play_name span,
        .single_play_list>a.active .course_play_duration{
            color:var(--mupo-red)!important;
        }

        .course_play_name{
            display:flex!important;
            align-items:center!important;
            min-width:0!important;
            gap:9px!important;
        }

        .course_play_name>span,
        .quiz_name{
            font-size:13px!important;
            line-height:1.35!important;
            color:var(--mupo-text)!important;
            cursor:pointer;
        }

        .course_play_duration{
            font-size:11px!important;
            color:#8792a2!important;
            margin-left:8px;
            white-space:nowrap;
        }

        .single_play_list .primary_checkbox{min-width:21px!important}
        .single_play_list input[type="checkbox"]{pointer-events:none!important}
        .single_play_list .checkmark{
            width:19px!important;
            height:19px!important;
            margin-right:0!important;
            border-color:#8799ad!important;
        }

        .single_play_list input:checked~.checkmark{
            background:var(--mupo-green)!important;
            border-color:var(--mupo-green)!important;
        }

        .single_play_list i{
            font-size:11px!important;
            color:#748399!important;
        }

        /* ===== STICKY LESSON NAVIGATION ===== */
        .mupo-bottom-nav{
            position:fixed;
            left:0;
            right:0;
            bottom:0;
            height:var(--mupo-bottom);
            background:#fff;
            border-top:1px solid var(--mupo-line);
            z-index:1100;
            display:grid;
            grid-template-columns:1fr auto 1fr;
            align-items:center;
            padding:10px 28px;
            gap:18px;
            box-shadow:0 -6px 20px rgba(6,27,58,.045);
        }

        .mupo-nav-btn{
            height:48px;
            min-width:205px;
            border:1px solid #cbd4df;
            border-radius:7px;
            background:#fff;
            color:var(--mupo-text)!important;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            font-size:14px;
            font-weight:700;
            text-decoration:none!important;
            padding:0 20px;
        }

        .mupo-nav-btn:hover{
            border-color:#9caabd;
            background:#f8fafc;
        }

        .mupo-nav-btn.disabled{opacity:.4;pointer-events:none}

        .mupo-bottom-center{
            text-align:center;
            color:var(--mupo-muted);
            font-size:12px;
        }

        .mupo-bottom-center strong{
            display:block;
            color:var(--mupo-text);
            font-size:14px;
        }

        .mupo-bottom-right{display:flex;justify-content:flex-end}

        .mupo-complete-btn{
            height:48px;
            min-width:300px;
            border:0;
            border-radius:7px;
            background:var(--mupo-red)!important;
            color:#fff!important;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            font-size:14px;
            font-weight:800;
            padding:0 22px;
            box-shadow:0 8px 20px rgba(237,28,36,.14);
        }

        .mupo-complete-btn:hover{filter:brightness(.96)}
        .mupo-complete-btn.is-complete{background:var(--mupo-green)!important}

        .quiz_questions_wrapper,
        .quiz_score_wrapper{
            max-width:1050px!important;
            margin:0 auto!important;
            padding:18px!important;
        }

        .course_fullview_wrapper iframe,
        .course_fullview_wrapper video{
            max-width:100%!important;
            border-radius:10px!important;
            background:#000!important;
        }

        /* ===== FOCUS MODE ===== */
        body.mupo-focus-mode .course__play_warp.courseListPlayer{
            transform:translateX(100%)!important;
            pointer-events:none!important;
        }

        body.mupo-focus-mode .course_fullview_wrapper{
            right:0!important;
        }

        body.mupo-focus-mode .lesson_content_text,
        body.mupo-focus-mode .mupo-lesson-context,
        body.mupo-focus-mode .mupo-editor-heading{
            max-width:940px!important;
        }

        @media(max-width:1280px){
            :root{--mupo-side-expanded:250px}
            .mupo-header-progress{width:210px;padding-left:16px;padding-right:16px}
            h4.headerTitle{max-width:340px}
            .mupo-tool-btn{min-width:52px}
        }

        @media(max-width:1199.98px){
            :root{--mupo-head:72px;--mupo-bottom:70px;--mupo-side:0px}

            html,body{overflow:auto!important}

            .course_fullview_wrapper{
                right:0!important;
                padding:16px!important;
            }

            .course__play_warp.courseListPlayer{
                width:min(86vw,290px)!important;
                min-width:0!important;
                max-width:min(86vw,290px)!important;
                flex-basis:auto!important;
                right:0!important;
                transform:translateX(100%)!important;
                transition:transform .2s ease!important;
                box-shadow:-15px 0 35px rgba(6,27,58,.15)!important;
            }

            .course__play_warp.courseListPlayer.active{transform:translateX(0)!important}

            .mupo-mobile-contents{display:inline-flex!important}
            .mupo-focus-toggle{display:none!important}
            .mupo-header-progress{display:none!important}

            .mupo-tool-btn{
                min-width:42px;
                width:42px;
                height:48px;
            }

            .mupo-tool-btn span{display:none}
            .mupo-header-tools{gap:1px;margin-left:0}
            .mupo-exit-course span{display:none}

            #sticky-header .header__wrapper{
                padding:0 12px!important;
                gap:10px!important;
            }

            .logo_img{padding-right:10px}

            .logo_img img{
                width:92px!important;
                height:48px!important;
            }

            h4.headerTitle{
                font-size:15px!important;
                max-width:280px;
            }

            .mupo-header-breadcrumb{display:none}

            .mupo-bottom-nav{
                grid-template-columns:auto 1fr;
                gap:9px;
                padding:8px 10px;
            }

            .mupo-bottom-center{display:none}

            .mupo-nav-btn{
                min-width:50px;
                width:50px;
                padding:0;
            }

            .mupo-nav-btn span{display:none}

            .mupo-complete-btn{
                min-width:0;
                width:100%;
                font-size:12px;
            }

            .mupo-editor-heading{padding:24px 22px}
            .mupo-editor-heading h1{font-size:30px!important}

            .lesson_content_text{
                padding:28px 22px!important;
                font-size:16px!important;
            }

            .lesson_content_text p,
            .lesson_content_text li{
                font-size:16px!important;
            }

            .course_fullview_wrapper .video_iframe{height:430px!important}
        }

        @media(max-width:575px){
            h4.headerTitle{max-width:160px}
            .mupo-tool-btn.notes-tool,
            .mupo-tool-btn.resources-tool{display:none!important}
            .course_fullview_wrapper{padding:10px!important}
            .mupo-lesson-context{padding:12px}
            .mupo-editor-heading h1{font-size:27px!important}
            .mupo-editor-heading p{font-size:15px!important}
            .lesson_content_text{padding:24px 18px!important}
            .lesson_content_text h1{font-size:28px!important}
            .lesson_content_text h2{font-size:23px!important}
            .lesson_content_text h3{font-size:20px!important}
            .mupo-complete-btn{padding:0 12px}
        }

        /* Final MUPO course-player reference alignment. */
        @media(min-width:1200px){
            :root{--mupo-side-expanded:250px;--mupo-side:var(--mupo-side-expanded);--mupo-reading:1000px;--mupo-head:76px;--mupo-bottom:78px}
            #sticky-header .header__wrapper{padding:0 22px!important;gap:16px!important}
            #sticky-header .header__left{flex:1 1 0!important;min-width:0!important;gap:16px!important;overflow:hidden!important}
            #sticky-header .category_search{flex:1 1 auto!important;min-width:0!important}
            .input-group-prepend2{display:block!important;width:100%!important;min-width:0!important;overflow:hidden!important}
            h4.headerTitle{display:block!important;max-width:100%!important;font-size:18px!important}
            .mupo-header-breadcrumb{max-width:100%!important;font-size:11px!important}
            .mupo-lesson-global-search{width:230px;height:42px;position:relative;display:flex!important;align-items:center;margin-right:4px;flex:0 0 230px}
            .mupo-lesson-global-search i{position:absolute;left:13px;color:#62718a;font-size:14px;z-index:2}
            .mupo-lesson-global-search input{width:100%;height:100%;border:1px solid #dbe2ea!important;border-radius:7px!important;padding:0 12px 0 39px!important;font-size:12px!important;color:var(--mupo-text)!important;outline:0;background:#f8fafc!important;box-shadow:none!important}
            .mupo-lesson-notification{width:42px;height:42px;display:grid;place-items:center;position:relative;color:var(--mupo-navy)!important;font-size:18px;margin:0 5px;text-decoration:none!important;flex:0 0 42px}
            .mupo-lesson-notification span{position:absolute;right:1px;top:0;min-width:17px;height:17px;border-radius:9px;background:var(--mupo-red);color:#fff;font-size:9px;display:grid;place-items:center;border:2px solid #fff}
            .mupo-lesson-profile{display:grid;grid-template-columns:42px minmax(85px,130px) 14px;grid-template-rows:1fr 1fr;column-gap:9px;align-items:center;color:var(--mupo-text)!important;text-decoration:none!important;min-width:150px;max-width:190px;flex:0 0 auto}
            .mupo-lesson-profile>span{grid-row:1/3;width:42px;height:42px;border-radius:50%;display:grid;place-items:center;background:var(--mupo-navy);color:#fff;font-size:12px;font-weight:800}
            .mupo-lesson-profile b{font-size:11px;align-self:end;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
            .mupo-lesson-profile small{font-size:9px;color:#7d8998;align-self:start}
            .mupo-lesson-profile>i{grid-column:3;grid-row:1/3;font-size:9px}
            .mupo-focus-toggle{display:none!important}
            .course_fullview_wrapper{padding:24px 28px 36px!important}
            .mupo-lesson-context,.mupo-editor-heading,.lesson_content_text{max-width:1000px!important}
            .lesson_content_text{font-size:17px!important}
            .lesson_content_text p,.lesson_content_text li{font-size:17px!important}
            .course_play_name>span,.quiz_name{font-size:14px!important}
            .course_play_duration{font-size:12px!important}
        }
        @media(min-width:1280px) and (max-width:1599.98px){
            #sticky-header .header__wrapper{padding:0 16px!important;gap:12px!important}
            #sticky-header .header__left{gap:14px!important}
            .mupo-exit-course{font-size:13px;gap:7px}
            h4.headerTitle{font-size:17px!important}
            .mupo-header-breadcrumb{margin-top:5px!important;font-size:10.5px!important}
            .mupo-lesson-global-search{width:210px!important;flex-basis:210px!important;margin-right:0!important}
            .mupo-lesson-global-search input{font-size:11px!important;padding-right:9px!important}
            .mupo-lesson-notification{width:38px!important;height:42px!important;flex-basis:38px!important;margin:0 2px!important}
            .mupo-lesson-profile{grid-template-columns:42px minmax(76px,110px) 12px!important;min-width:140px!important;max-width:164px!important;column-gap:8px!important}
        }
        @media(min-width:1200px) and (max-width:1279.98px){
            #sticky-header .header__wrapper{padding:0 14px!important;gap:10px!important}
            #sticky-header .header__left{gap:12px!important}
            .mupo-exit-course{font-size:12px;gap:6px}
            h4.headerTitle{font-size:16px!important}
            .mupo-header-breadcrumb{margin-top:4px!important;font-size:10px!important}
            .mupo-lesson-global-search{display:none!important}
            .mupo-lesson-notification{width:38px!important;flex-basis:38px!important;margin:0 2px!important}
            .mupo-lesson-profile{grid-template-columns:42px minmax(70px,96px) 12px!important;min-width:132px!important;max-width:150px!important;column-gap:7px!important}
        }
        .play_warp_header{background:var(--mupo-navy)!important;color:#fff!important;border-bottom:1px solid rgba(255,255,255,.08)!important;min-height:112px!important;padding:20px!important}
        .mupo-content-head h3,.mupo-content-head strong{color:#fff!important}
        .play_warp_header .mupo-progress-line{margin-top:12px}
        .play_warp_header .mupo-content-sub{color:rgba(255,255,255,.72)!important;margin:8px 0 0!important;font-size:13px!important}

        /* ===== FINAL BOSS-REFERENCE LESSON SYSTEM ===== */
        .mupo-lesson-context{display:grid!important;grid-template-columns:42px minmax(0,1fr) auto!important;min-height:68px!important;padding:12px 16px!important;margin-bottom:14px!important}
        .mupo-context-icon{width:42px;height:42px;border-radius:9px;background:#eaf3ff;color:#0864c5;display:grid;place-items:center;font-size:19px}
        .mupo-lesson-status{min-width:88px!important;justify-content:center!important;background:#e5f1ff!important;color:#0755ae!important}
        .mupo-lesson-status.completed{background:#eaf7f0!important;color:var(--mupo-green)!important}
        .mupo-editor-heading{min-height:188px!important;padding:30px 34px!important;display:flex!important;align-items:center!important;justify-content:space-between!important;gap:28px!important;background-image:linear-gradient(90deg,rgba(6,27,58,.98) 0%,rgba(6,38,75,.93) 58%,rgba(7,40,77,.78) 100%),var(--mupo-lesson-cover)!important;background-size:cover!important;background-position:center!important}
        .mupo-editor-heading:after{right:12px!important;top:-18px!important;width:210px!important;height:210px!important;background:rgba(255,255,255,.035)!important}
        .mupo-editor-copy{position:relative;z-index:2;min-width:0;flex:1 1 auto}
        .mupo-editor-heading h1{font-size:38px!important}
        .mupo-hero-meta{position:relative;z-index:2;width:165px;flex:0 0 165px;text-align:center;color:#fff;display:flex;flex-direction:column;align-items:center;gap:8px}
        .mupo-hero-icon{width:58px;height:58px;border:1px solid rgba(255,255,255,.35);border-radius:50%;display:grid;place-items:center;font-size:25px;background:rgba(255,255,255,.08)}
        .mupo-hero-meta strong{font-size:12px;color:#fff;line-height:1.3}
        .mupo-hero-meta small{font-size:12px;color:rgba(255,255,255,.9)}
        .lesson_content_text{padding:26px 28px!important}
        .mupo-objectives-heading{display:flex;align-items:center;gap:14px;padding:0 0 15px;margin-bottom:12px;border-bottom:1px solid var(--mupo-line)}
        .mupo-objectives-heading>span{width:48px;height:48px;border-radius:50%;background:#fff0f1;color:var(--mupo-red);display:grid;place-items:center;font-size:23px;flex:0 0 48px}
        .mupo-objectives-heading strong{display:block;color:var(--mupo-text);font-size:18px;line-height:1.2}
        .mupo-objectives-heading small{display:block;color:#526987;font-size:14px;margin-top:3px}
        .mupo-essential-knowledge>ul{list-style:none!important;padding:0!important;margin:0!important}
        .mupo-essential-knowledge>ul li{position:relative;padding:7px 0 7px 36px!important;margin:0!important}
        .mupo-essential-knowledge>ul li:before{content:'\2713';position:absolute;left:0;top:7px;width:23px;height:23px;border-radius:50%;display:grid;place-items:center;background:#0864c5;color:#fff;font-size:12px;font-weight:800}
        .mupo-essential-knowledge>.table-responsive{margin-top:16px!important;border-radius:9px!important;background:#eaf4ff!important;padding:10px 14px!important}
        .mupo-essential-knowledge>.table-responsive table{margin:0!important;border:0!important;background:transparent!important}
        .mupo-essential-knowledge>.table-responsive td{border:0!important;background:transparent!important;color:#42607f!important;padding:9px 10px 9px 54px!important;position:relative}
        .mupo-essential-knowledge>.table-responsive td:before{content:'\f15c';font-family:'Font Awesome 5 Free';font-weight:400;position:absolute;left:8px;top:50%;transform:translateY(-50%);width:34px;height:34px;border-radius:7px;background:#d8eaff;color:#0864c5;display:grid;place-items:center;font-size:17px}
        .play_warp_header{background:#fff!important;color:var(--mupo-text)!important;border-bottom:1px solid var(--mupo-line)!important;min-height:108px!important}
        .mupo-content-head h3,.mupo-content-head strong{color:var(--mupo-text)!important}
        .play_warp_header .mupo-content-sub{color:var(--mupo-muted)!important}
        .mupo-side-search{border-bottom:1px solid var(--mupo-line)!important}
        @media(min-width:1280px){
            .mupo-course-heading{display:flex!important;align-items:center!important;gap:10px!important;white-space:nowrap!important}
            .mupo-course-heading h4.headerTitle{flex:0 1 auto!important;font-size:13px!important;font-weight:800!important;overflow:hidden!important;text-overflow:ellipsis!important}
            .mupo-header-breadcrumb{display:flex!important;flex:1 1 auto!important;margin:0!important;font-size:10.5px!important;overflow:hidden!important}
            .mupo-course-heading h4.headerTitle:after{content:'›';color:#a0aabd;margin-left:10px;font-weight:500}
            .mupo-lesson-profile{min-width:58px!important;width:58px!important;max-width:58px!important;grid-template-columns:42px 12px!important;column-gap:6px!important}
            .mupo-lesson-profile b,.mupo-lesson-profile small{display:none!important}
            .mupo-lesson-profile>i{grid-column:2!important}
        }
        .course__play_warp.courseListPlayer{background:#f6f8fb!important}
        .play_warp_header{width:calc(100% - 24px)!important;margin:12px 12px 8px!important;border:1px solid var(--mupo-line)!important;border-radius:9px!important;box-shadow:0 5px 16px rgba(6,27,58,.045)!important;min-height:96px!important;padding:16px!important}
        .mupo-side-search{background:#fff!important}
        @media(max-width:767.98px){
            .mupo-lesson-context{grid-template-columns:38px minmax(0,1fr)!important;padding:10px!important}
            .mupo-context-icon{width:38px;height:38px}
            .mupo-lesson-status{grid-column:1/-1;justify-self:start;margin-left:52px;margin-top:3px}
            .mupo-editor-heading{min-height:0!important;padding:24px 20px!important;display:block!important}
            .mupo-hero-meta{display:none!important}
            .lesson_content_text{padding:22px 18px!important}
        }

        /* ===== MUPO REFERENCE MATCH: authoritative final layer ===== */
        :root{
            --mupo-navy:#082b52;
            --mupo-navy-2:#0b3767;
            --mupo-red:#ed1c24;
            --mupo-blue:#0864c5;
            --mupo-green:#08a66c;
            --mupo-bg:#f4f7fb;
            --mupo-line:#dbe4ee;
            --mupo-text:#09254a;
            --mupo-muted:#657b98;
            --mupo-side-expanded:320px;
            --mupo-side:var(--mupo-side-expanded);
            --mupo-reading:1010px;
            --mupo-head:76px;
            --mupo-bottom:78px;
        }

        .course_fullview_wrapper{
            padding:24px 34px 32px!important;
            background:#f4f7fb!important;
        }

        .mupo-lesson-context,
        .mupo-editor-heading,
        .lesson_content_text{max-width:1010px!important}

        .mupo-lesson-context{
            min-height:82px!important;
            padding:12px 16px!important;
            border-color:#dbe4ee!important;
            border-radius:11px!important;
            box-shadow:0 4px 16px rgba(9,37,74,.035)!important;
        }

        .mupo-lesson-context strong{font-size:16px!important;color:#09254a!important}
        .mupo-lesson-context span:not(.mupo-lesson-status){font-size:13px!important;color:#657b98!important}
        .mupo-context-icon{background:#e8f2ff!important;color:#0864c5!important;border-radius:9px!important}
        .mupo-lesson-status{background:#e2efff!important;color:#0755ae!important;min-width:108px!important;min-height:40px!important}
        .mupo-lesson-status.completed{background:#e8f7ef!important;color:#08a66c!important}

        .mupo-editor-heading{
            min-height:204px!important;
            padding:28px 40px!important;
            border-radius:10px!important;
            background-image:linear-gradient(90deg,rgba(5,38,73,.98) 0%,rgba(6,48,91,.94) 58%,rgba(7,50,94,.82) 100%),var(--mupo-lesson-cover)!important;
            background-position:center!important;
        }

        .mupo-editor-kicker{font-size:12px!important;color:#ff3e46!important;margin-bottom:12px!important}
        .mupo-editor-heading h1{font-size:40px!important;line-height:1.08!important;letter-spacing:-.5px!important}
        .mupo-editor-heading p{font-size:16px!important;line-height:1.55!important;max-width:720px!important;color:rgba(255,255,255,.93)!important}
        .mupo-hero-meta{width:150px!important;flex-basis:150px!important}
        .mupo-hero-icon{width:58px!important;height:58px!important;font-size:24px!important;color:#fff!important}
        .mupo-hero-icon i{display:block!important;color:#fff!important;font-size:24px!important;line-height:1!important}

        .lesson_content_text{
            padding:18px 24px!important;
            border-radius:11px!important;
            border-color:#dbe4ee!important;
            box-shadow:0 6px 20px rgba(9,37,74,.035)!important;
        }

        .mupo-essential-knowledge{min-height:0!important}
        .mupo-objectives-heading{padding:0 0 12px!important;margin-bottom:8px!important}
        .mupo-objectives-heading strong{font-size:18px!important}
        .mupo-objectives-heading small{font-size:14px!important;color:#526987!important}
        .mupo-essential-knowledge>ul li{font-size:14px!important;line-height:1.45!important;padding:6px 0 6px 34px!important}
        .mupo-essential-knowledge>ul li:before{top:5px!important;width:23px!important;height:23px!important;background:#0864c5!important}

        .course__play_warp.courseListPlayer{background:#f4f7fb!important;border-left-color:#dbe4ee!important}
        #mupoCoursePanelContent{background:#f4f7fb!important}
        .play_warp_header{
            width:calc(100% - 24px)!important;
            min-height:104px!important;
            margin:12px 12px 10px!important;
            padding:16px 18px!important;
            background:#fff!important;
            color:#09254a!important;
            border:1px solid #dbe4ee!important;
            border-radius:10px!important;
            box-shadow:0 4px 14px rgba(9,37,74,.045)!important;
        }
        .mupo-content-head{align-items:center!important}
        .mupo-content-head h3{font-size:17px!important;color:#09254a!important}
        .mupo-content-head strong{font-size:16px!important;color:#09254a!important}
        .play_warp_header .mupo-content-sub{font-size:12px!important;color:#657b98!important;margin:8px 0 0!important}
        .play_warp_header .mupo-progress-line{height:8px!important;margin-top:10px!important;background:#e4eaf1!important}

        .mupo-side-search{padding:12px!important;background:#fff!important;border:1px solid #dbe4ee!important;border-radius:9px!important;margin:0 12px 10px!important}
        .mupo-side-search input{height:42px!important;font-size:13px!important}
        .course__play_list{height:calc(100% - 188px)!important;background:#fff!important;border-top:1px solid #e3e9f0!important}
        .theme_according .accordion-button{padding:15px 18px!important;font-size:14px!important}
        .theme_according .accordion-button:not(.collapsed){background:#fff1f2!important;color:#ed1c24!important;border-left:4px solid #ed1c24!important;padding-left:14px!important}
        .theme_according .accordion-body{padding:6px 10px 10px!important}
        .single_play_list>a{min-height:44px!important;padding:7px 9px!important;border-radius:7px!important}
        .course_play_name>span,.quiz_name{font-size:12px!important;line-height:1.3!important}
        .course_play_duration{font-size:11px!important}
        .single_play_list .primary_checkbox{min-width:24px!important}
        .single_play_list .primary_checkbox>i{display:none!important}
        .single_play_list .checkmark{
            width:22px!important;height:22px!important;flex:0 0 22px!important;
            border:2px solid #8fa3bc!important;border-radius:50%!important;
            background:#fff!important;
        }
        .single_play_list .checkmark:after{display:none!important}
        .single_play_list input:checked~.checkmark{background:#08a66c!important;border-color:#08a66c!important}
        .single_play_list input:checked~.checkmark:before{
            content:'\2713'!important;font-family:inherit!important;inset:0!important;
            transform:none!important;display:grid!important;place-items:center!important;
            color:#fff!important;font-size:13px!important;line-height:1!important;font-weight:800!important;
        }
        .single_play_list>a.active .checkmark{background:#fff!important;border-color:#ed1c24!important}
        .single_play_list>a.active input:checked~.checkmark{background:#fff!important;border-color:#ed1c24!important}
        .single_play_list>a.active input:checked~.checkmark:before{display:none!important}
        .single_play_list>a.active{background:#fff1f2!important;border-left:4px solid #ed1c24!important}

        .mupo-bottom-nav{height:78px!important;padding:10px 26px!important}
        .mupo-nav-btn{height:48px!important;min-width:216px!important}
        .mupo-complete-btn{height:50px!important;min-width:304px!important}

        @media(min-width:1280px){
            body.mupo-learning-portal-shell{--mupo-portal-sidebar:267px}
            #sticky-header .header__wrapper{padding:0 24px!important;gap:14px!important}
            .mupo-portal-menu-toggle{width:40px!important;height:40px!important;border-radius:50%!important;background:#082b52!important;color:#fff!important}
            .mupo-exit-course{font-size:12px!important;gap:8px!important}
            .mupo-course-heading{gap:9px!important}
            .mupo-course-heading h4.headerTitle{font-size:12px!important;color:#09254a!important}
            .mupo-header-breadcrumb{font-size:11px!important;color:#657b98!important}
            .mupo-lesson-global-search{width:268px!important;flex-basis:268px!important;height:42px!important}
            .mupo-lesson-profile{width:58px!important;min-width:58px!important;max-width:58px!important}
        }

        @media(min-width:1280px) and (max-width:1439.98px){
            body.mupo-learning-portal-shell{--mupo-portal-sidebar:232px}
            :root{--mupo-side-expanded:286px;--mupo-side:286px;--mupo-reading:900px}
            .course_fullview_wrapper{padding:18px 22px 26px!important}
            .mupo-lesson-context,.mupo-editor-heading,.lesson_content_text{max-width:900px!important}
            .mupo-lesson-global-search{width:210px!important;flex-basis:210px!important}
            .mupo-editor-heading h1{font-size:35px!important}
        }
    </style>

@endsection

@section('mainContent')
    @auth
        @if((int) auth()->user()->role_id === 3)
            <script>document.body.classList.add('mupo-learning-portal-shell');</script>
            @include(theme('partials._sidebar'))
            <button type="button" class="mupo-nav-overlay" id="mupoLearningNavOverlay" aria-label="Close learner navigation"></button>
        @endif
    @endauth
    @php
        $video_lesson_hosts=['Iframe','Image','PDF','Word','Excel','PowerPoint','Text','Zip','GoogleDrive','H5P','Editor'];
        $currentLessonId = (int) $lesson->id;
        $currentLessonIndex = array_search($currentLessonId, array_map('intval', $lesson_ids ?? []), true);
        $previousLessonId = ($currentLessonIndex !== false && $currentLessonIndex > 0) ? (int) $lesson_ids[$currentLessonIndex - 1] : null;
        $nextLessonId = ($currentLessonIndex !== false && isset($lesson_ids[$currentLessonIndex + 1])) ? (int) $lesson_ids[$currentLessonIndex + 1] : null;
        $isCurrentLessonComplete = auth()->check()
            ? \App\LessonComplete::where('user_id', auth()->id())->where('course_id', $course->id)->where('lesson_id', $lesson->id)->where('status', 1)->exists()
            : false;
        $completedLessonCount = auth()->check()
            ? \App\LessonComplete::where('user_id', auth()->id())->where('course_id', $course->id)->where('status', 1)->count()
            : 0;
        $currentLessonNumber = $currentLessonIndex !== false ? $currentLessonIndex + 1 : 1;
        $totalLessonCount = count($lesson_ids ?? []);
        $currentChapter = $chapters->firstWhere('id', $lesson->chapter_id);
        $isEssentialKnowledge = strtolower(trim((string) $lesson->name)) === 'essential knowledge';
    @endphp
    @push('js')
        <script>
            // $(document).on('click', '.showHistory', function (e) {
            //     console.log('click')
            //     e.preventDefault();
            //     $("#historyDiv").toggle('slow')
            // });
        </script>
        <script>
            var completeRequest = false;
        </script>
    @endpush

    @php
        if ($lesson->lessonQuiz->random_question==1){
        $questions =$lesson->lessonQuiz->assignRand;
        }else{
        $questions =$lesson->lessonQuiz->assign;
       }
    @endphp

    <script>
        @if(auth()->check())
            window.full_name = "{{auth()->user()->name}}";
        window.course_name = "{{ $course->title}}";
        @if(isModuleActive('Org'))
            window.org_chart_name = "{{auth()->user()->branch->group}}";
        @endif
            @else
            window.full_name = "Guest";
        window.course_name = "{{ $course->title}}";
        @if(isModuleActive('Org'))
            window.org_chart_name = "";
        @endif
        @endif
    </script>
    <header>
        <div id="sticky-header" class="header_area">
            <div class="container-fluid"><div class="row"><div class="col-12">
                <div class="header__wrapper">
                    <div class="header__left d-flex align-items-center">
                        <button type="button" class="mupo-portal-menu-toggle" id="mupoLearningNavOpen" aria-label="Open learner navigation" aria-controls="mupoLearnerSidebar" aria-expanded="false"><i class="fas fa-bars"></i></button>
                        <a class="logo_img d-lg-none" href="{{ url('/') }}"><img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" alt="Mupo Training Center"></a>
                        <a class="mupo-exit-course" href="{{ route('myCourses') }}"><i class="fas fa-arrow-left"></i><span>Back to My Courses</span></a>
                        <div class="category_search category_box_iner"><div class="input-group-prepend2 mupo-course-heading">
                            <h4 class="headerTitle">{{ $course->title }}</h4>
                            <div class="mupo-header-breadcrumb" aria-label="Current lesson location">
                                <span class="mupo-breadcrumb-module">{{ optional($currentChapter)->name ?? 'Course Content' }}</span>
                                <span class="mupo-breadcrumb-separator" aria-hidden="true">›</span>
                                <b class="mupo-breadcrumb-lesson">Lesson {{ $currentLessonNumber }}: {{ $lesson->name }}</b>
                            </div>
                        </div></div>
                    </div>
                    <div class="header__right"><div class="contact_wrap d-flex align-items-center">
                        <form class="mupo-lesson-global-search d-none d-xl-flex" action="{{ route('courses') }}" method="GET" role="search"><i class="fas fa-search"></i><input type="search" name="query" placeholder="Search lessons, topics..." aria-label="Search lessons and topics"></form>
                        <a href="{{ route('myNotification') }}" class="mupo-lesson-notification" aria-label="Notifications"><i class="far fa-bell"></i>@if(auth()->user()->unreadNotifications->count())<span>{{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}</span>@endif</a>
                        <a href="{{ route('users.settings') }}" class="mupo-lesson-profile"><span>{{ strtoupper(substr(auth()->user()->name,0,1)) }}{{ strtoupper(substr(strrchr(' '.auth()->user()->name,' '),1,1)) }}</span><b>{{ auth()->user()->name }}</b><small>Learner</small><i class="fas fa-chevron-down"></i></a>
                        <button type="button" class="mupo-tool-btn mupo-focus-toggle d-none d-lg-flex" id="mupoFocusToggle" title="Focus Mode" aria-pressed="false"><i class="fas fa-expand-alt"></i><span>Focus</span></button>
                        <button type="button" class="mupo-tool-btn mupo-mobile-contents play_toggle_btn d-none" title="Course Content"><i class="fas fa-list"></i><span>Contents</span></button>
                    </div></div>
                </div>
            </div></div></div>
        </div>
    </header>

    <div class="course_fullview_wrapper {{$lesson->is_quiz == 1 ? '' : 'video'}} {{$lesson->host == 'Editor' ? 'flex-column justify-content-start p-4' : ''}}">
        <div class="mupo-lesson-context">
            <div class="mupo-context-icon" aria-hidden="true"><i class="far fa-file-alt"></i></div>
            <div>
                <strong>{{ optional($currentChapter)->name ?? 'Course Content' }}</strong>
                <span>Lesson {{ $currentLessonNumber }} of {{ $totalLessonCount ?: $total }} &nbsp;•&nbsp; {{ MinuteFormat($lesson->duration) }}</span>
            </div>
            <span class="mupo-lesson-status {{ $isCurrentLessonComplete ? 'completed' : '' }}">
                {{ $isCurrentLessonComplete ? 'Completed' : 'In Progress' }}
            </span>
        </div>
        @if ($lesson->is_quiz == 1)
            @if (count($result) != 0)
                <div class="quiz_score_wrapper w-100 mt_70">
                    @if (!isset($_GET['done']))
                        <div class="quiz_test_header">
                            <h3>{{ __('student.Your Exam Score') }}</h3>
                        </div>
                        <div class="quiz_test_body">
                            {{-- <h3>{{ __('student.Congratulations! You’ve completed') }} {{ $course->quiz->title }}</h3> --}}



                            @if ($result['publish'] == 1)

                                @if ($result['status'] != 'Failed')
                                    <h3 class="success">{{__('student.Congratulations!')}}</h3>
                                @else
                                    <h3 class="failed">
                                        <span>{{__('frontend.You have failed')}}.</span> {{__('frontend.Wishing you luck the next time')}}
                                    </h3>
                                @endif
                                <p class="subtitle">{{__('frontend.You have completed')}} {{$lesson->lessonQuiz->title}}</p>

                                <div class="">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="score_view_wrapper">
                                                <div class="single_score_view">
                                                    {{-- <p>{{ __('student.Exam Score') }}:</p> --}}
                                                    <ul class="quiz_exam_score_details">
                                                        <li class="correct">
                                                            <label class="primary_checkbox2 d-flex">
                                                                <input checked="" type="checkbox" disabled>
                                                                <div class="icon">
                                                                    <svg width="15" height="15" viewBox="0 0 15 15"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M1.61719 9.18847L5.78764 13.4892C7.75009 7.85194 9.38446 5.37824 13.0859 2.02051"
                                                                            stroke="currentColor" stroke-width="3"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="label_name">{{ $result['totalCorrect'] }}
                                                                    {{ __('student.Correct Answer') }}</span>
                                                            </label>
                                                        </li>
                                                        <li class="wrong">
                                                            <label class="primary_checkbox2 error_ans d-flex">
                                                                <input checked="" name="qus" type="checkbox"
                                                                       disabled>
                                                                <div class="icon">
                                                                    <svg width="12" height="12" viewBox="0 0 12 12"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M1.75781 10.2427L10.2431 1.75739"
                                                                              stroke="currentColor" stroke-width="2"
                                                                              stroke-linecap="round"
                                                                              stroke-linejoin="round"></path>
                                                                        <path d="M10.2431 10.2426L1.75781 1.75732"
                                                                              stroke="currentColor" stroke-width="2"
                                                                              stroke-linecap="round"
                                                                              stroke-linejoin="round"></path>
                                                                    </svg>

                                                                </div>
                                                                <span class="label_name">{{ $result['totalWrong'] }}
                                                                    {{ __('student.Wrong Answer') }}</span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="single_score_view d-flex">
                                                    <div>
                                                        <div>
                                                            <p>{{__('student.Exam Score')}}: {{ $result['score'] }}
                                                                Out of {{ $result['totalScore'] }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                {{__('frontend.Result')}}:
                                                                <span>
                                                                    @if ($result['status'] != 'Failed')
                                                                        {{ __('frontend.Passed') }}
                                                                    @else
                                                                        {{ __('frontend.Failed') }}
                                                                    @endif
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sumit_skip_btns d-flex gap-3 align-items-center flex-wrap">
                                    @if (isset($result) && $result['status'] != 'Failed')
                                        <form action="{{ route('lesson.complete') }}" method="post">
                                            @csrf
                                            <input type="hidden" value="{{ $course->id }}" name="course_id">
                                            <input type="hidden" value="{{ $lesson->id }}" name="lesson_id">
                                            <input type="hidden" value="1" name="status">
                                            <button type="submit"
                                                    class="quiz_primary_btn border-0">{{ __('student.Done') }}</button>
                                        </form>
                                    @endif
                                    @if (count($preResult) != 0)
                                        <button type="button"
                                                class="theme_line_btn  showHistory quiz_secondary_btn border-0">{{ __('frontend.View History') }}</button>
                                    @endif
                                    <a href="{{ $lesson->lessonQuiz->show_ans_sheet == 1 ? route('quizResultPreview', $_GET['quiz_result_id'] ?? 0) : '#' }}"
                                       data-quiz_test_id="{{ $_GET['quiz_result_id'] ?? 0 }}"
                                       title="{{ $lesson->lessonQuiz->show_ans_sheet != 1 ? __('quiz.Answer Sheet is currently locked by Teacher') : '' }}"
                                       class=" font_1 font_16 f_w_600 theme_text3 quiz_secondary_btn ">{{ __('student.See Answer Sheet') }}</a>
                                </div>
                            @else
                                <h3>{{ __('quiz.Please wait till completion marking process') }}</h3>
                            @endif


                            <div id="historyDiv" class="pt-5 " style="display:none;">
                                @if (count($preResult) != 0)
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>{{ __('common.Date') }}</th>
                                            <th>{{ __('quiz.Marks') }}</th>
                                            <th>{{ __('quiz.Percentage') }}</th>
                                            <th>{{ __('common.Rating') }}</th>
                                            <th>{{ __('common.Details') }}</th>
                                        </tr>
                                        @foreach ($preResult as $pre)
                                            <tr>
                                                <td>{{ $pre['date'] }}</td>
                                                <td>{{ $pre['score'] }}/{{ $pre['totalScore'] }}</td>
                                                <td>{{ $pre['mark'] }}%</td>
                                                <td class="{{ $pre['text_color'] }}">
                                                    @if ($pre['status'] != 'Failed')
                                                        {{ __('frontend.Passed') }}
                                                    @else
                                                        {{ __('frontend.Failed') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ $lesson->lessonQuiz->show_ans_sheet == 1 ? route('quizResultPreview', $pre['quiz_test_id']) : '#' }}"
                                                       data-quiz_test_id="{{ $pre['quiz_test_id'] }}"
                                                       title="{{ $lesson->lessonQuiz->show_ans_sheet != 1 ? __('quiz.Answer Sheet is currently locked by Teacher') : '' }}"
                                                       class=" font_1 font_16 f_w_600 theme_text3    @if ($lesson->lessonQuiz->show_ans_with_explanation == 1)
                                       submit_q_btn
                                       @endif ">{{ __('student.See Answer Sheet') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                            @if ($lesson->lessonQuiz->show_ans_with_explanation == 1)
                                <div class="mt-3">
                                    <x-quiz-details-question-list :quiz="$lesson->lessonQuiz"/>
                                </div>
                            @endif
                        </div>
                    @else
                        <h3 class="text-center">{{ __('student.Congratulations! You’ve completed') }}
                            {{ $lesson->lessonQuiz->title }}</h3>

                    @endif
                </div>
            @else
                <div class="quiz_questions_wrapper w-100 mt_70 ms-5 me-5">
                    <!-- quiz_test_header  -->

                    @if ($alreadyJoin != 0 && $lesson->lessonQuiz->multiple_attend == 0)
                        <div class="quiz_test_header d-flex justify-content-between align-items-center">
                            <div class="quiz_header_left text-center">
                                <h3>{{ __('frontend.Sorry! You already attempted this quiz') }}</h3>
                            </div>


                        </div>
                    @else
                        <div class="quiz_test_header d-flex justify-content-between align-items-center">
                            <div class="quiz_header_left">
                                <h3>{{ $lesson->lessonQuiz->title }}
                                </h3>
                            </div>

                            <div class="quiz_header_right">
                                <span class="question_time">
                                <span>{{__('frontend.Remaining')}}:</span>
                                <span>
                                    @php
                                        $timer = 0;

                                        if (!empty($lesson->lessonQuiz->question_time_type == 1)) {
                                            $timer = $lesson->lessonQuiz->question_time;
                                        } else {
                                            $timer = $lesson->lessonQuiz->question_time * count($questions);
                                        }

                                    @endphp

                                    <span id="timer">{{ $timer }}:00</span> {{ __('quiz.Min') }}</span>
                                </span>
                                {{-- <p>{{ __('student.Left of this Section') }}</p> --}}
                            </div>
                        </div>
                        <form action="{{ route('quizSubmit') }}" method="POST" id="quizForm">
                            <input type='hidden' name="from" value="course">
                            <input type="hidden" name="courseId" value="{{ $course->id }}">
                            <input type="hidden" name="quizType" value="1">
                            <input type="hidden" name="quizId" value="{{ $lesson->lessonQuiz->id }}">
                            <input type="hidden" name="question_review" id="question_review"
                                   value="{{ $lesson->lessonQuiz->question_review }}">
                            <input type="hidden" name="start_at" value="">
                            <input type="hidden" name="quiz_test_id" value="">
                            <input type="hidden" name="quiz_start_url" value="{{ route('quizTestStart') }}">
                            <input type="hidden" name="single_quiz_submit_url" value="{{ route('singleQuizSubmit') }}">
                            @csrf

                            <div class="quiz_test_body ">
                                <div class="tabControl">
                                    <div class="row">
                                        <div class="col-xl-12">

                                            @php
                                                $count2 = 1;
                                            @endphp

                                            <div class="question_list_header">
                                                <div class="question_list_top">
                                                    <p>{{ __('quiz.Question') }} <span
                                                            id="currentNumber">{{ $count2 }}</span>
                                                        {{ __('common.out of') }} {{ count($questions) }}</p>
                                                </div>
                                            </div>
                                            <div class="nav question_number_lists" id="nav-tab" role="tablist">
                                                @if (isset($questions))
                                                    @foreach ($questions as $key2 => $assign)
                                                        <a class="nav-link questionLink link_{{ $assign->id }} {{ $key2 == 0 ? 'skip_qus' : 'pouse_qus' }}"
                                                           data-bs-toggle="tab" href="#pills-{{ $assign->id }}"
                                                           role="tab" aria-controls="nav-home"
                                                           data-qus="{{ $assign->id }}"
                                                           aria-selected="true">{{ $count2 }}</a>
                                                        @php
                                                            $count2++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="tab-content" id="pills-tabContent">
                                                @php
                                                    $count = 1;
                                                @endphp
                                                @if (isset($questions))
                                                    @foreach ($questions as $key => $assign)
                                                        @php
                                                            $options = [];
    if (isset($assign->questionBank->questionMu)) {
if ($assign->questionBank->shuffle==1){
    $options = $assign->questionBank->questionMu;
}else{
    $options = $assign->questionBank->questionMuInSerial;
}
                                                                                                                          }
                                                        @endphp
                                                        <div
                                                            class="tab-pane fade  {{ $key == 0 ? 'active show' : '' }} singleQuestion"
                                                            data-qus-id="{{ $assign->id }}"
                                                            data-qus-type="{{ $assign->questionBank->type }}"
                                                            id="pills-{{ $assign->id }}" role="tabpanel"
                                                            aria-labelledby="pills-home-tab{{ $assign->id }}">
                                                            <div class="question_list_header">

                                                            </div>
                                                            <div class="multypol_qustion mb_30">
                                                                <h4 class="font_18 f_w_700 mb-0">
                                                                    @if(@$assign->questionBank->type=="C")
                                                                        {!! getClozeOptions(@$assign->questionBank) !!}
                                                                    @else
                                                                        {!! @$assign->questionBank->question !!}
                                                                    @endif
                                                                </h4>
                                                                @if($assign->questionBank->type=="M" && @$quiz->show_total_correct_answer == 1)
                                                                    <small>({{ __('quiz.Choose') }} <span
                                                                            class="questionAnsTotal text-danger fw-bold">
                                                                                        {{ count($options->where('status', 1)) }}</span>
                                                                        @if (count($options->where('status', 1)) <= 1)
                                                                            {{ __('quiz.answer') }})
                                                                        @else
                                                                            {{ __('quiz.answers') }})
                                                                        @endif
                                                                    </small>
                                                                @endif
                                                            </div>
                                                            <input type="hidden" class="question_type"
                                                                   name="type[{{ $assign->questionBank->id }}]"
                                                                   value="{{ @$assign->questionBank->type }}">
                                                            <input type="hidden" class="question_id"
                                                                   name="question[{{ $assign->questionBank->id }}]"
                                                                   value="{{ @$assign->questionBank->id }}">

                                                            {{--                                                            @if ($assign->questionBank->type == 'M')--}}
                                                            {{--                                                                <ul class="quiz_select">--}}
                                                            {{--                                                                    @if (isset($assign->questionBank->questionMu))--}}
                                                            {{--                                                                        @foreach (@$assign->questionBank->questionMu as $option)--}}
                                                            {{--                                                                            <li>--}}
                                                            {{--                                                                                <label--}}
                                                            {{--                                                                                    class="primary_bulet_checkbox d-flex">--}}
                                                            {{--                                                                                    <input class="quizAns"--}}
                                                            {{--                                                                                           name="ans[{{ $option->question_bank_id }}][]"--}}
                                                            {{--                                                                                           type="checkbox"--}}
                                                            {{--                                                                                           value="{{ $option->id }}">--}}

                                                            {{--                                                                                    <span--}}
                                                            {{--                                                                                        class="checkmark mr_10"></span>--}}
                                                            {{--                                                                                    <span--}}
                                                            {{--                                                                                        class="label_name">{{ $option->title }}--}}
                                                            {{--                                                                                    </span>--}}
                                                            {{--                                                                                </label>--}}
                                                            {{--                                                                            </li>--}}
                                                            {{--                                                                        @endforeach--}}
                                                            {{--                                                                    @endif--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            @else--}}
                                                            {{--                                                                <div style="margin-bottom: 20px;">--}}
                                                            {{--                                                                    <textarea class="textArea lms_summernote quizAns"--}}
                                                            {{--                                                                              id="editor{{ $assign->id }}" cols="30"--}}
                                                            {{--                                                                              rows="10"--}}
                                                            {{--                                                                              name="ans[{{ $assign->questionBank->id }}]"></textarea>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            @endif--}}
                                                            @php
                                                                $qusBank=$assign->questionBank;
                                                                   $already = null;
                                                            @endphp

                                                            @if($assign->questionBank->type=="M")
                                                                @include(theme('partials._quiz_multiple_type'),compact('qusBank','already'))
                                                            @elseif($assign->questionBank->type=="O")
                                                                @include(theme('partials._quiz_sorting_type'),compact('qusBank','already'))
                                                            @elseif($assign->questionBank->type=="X")
                                                                @include(theme('partials._quiz_matching_type'),compact('qusBank','already'))
                                                            @elseif($assign->questionBank->type=="P")
                                                                @php
                                                                    $puzzleQus = $options->where('type',1);
                                                                $puzzleAns = $options->where('type',0);
                                                                @endphp
                                                                @include(theme('partials._quiz_puzzle_type'),compact('qusBank','already'))
                                                            @elseif($assign->questionBank->type=="S" || $assign->questionBank->type=="L")
                                                                <div style="margin-bottom: 20px;">
                                                                                <textarea
                                                                                    class="textArea lms_summernote quizAns"
                                                                                    id="editor{{ $assign->id }}"
                                                                                    cols="30" rows="10"
                                                                                    name="ans[{{ $assign->questionBank->id }}]"></textarea>
                                                                </div>
                                                            @endif

                                                            @if (!empty($assign->questionBank->image))
                                                                <div class="ques_thumb mb_50 mt-4">
                                                                    <img src="{{assetPath($assign->questionBank->image) }}"
                                                                         class="img-fluid" alt="">
                                                                </div>
                                                            @endif
                                                            <div
                                                                class="sumit_skip_btns d-flex align-items-center mb_50">
                                                                @if (count($questions) != $count)
                                                                    <span class="quiz_primary_btn  mr_20 next"
                                                                          data-question_id="{{ $assign->questionBank->id }}"
                                                                          data-assign_id="{{ $assign->id }}"
                                                                          data-question_type="{{ $assign->questionBank->type }}"
                                                                          id="next">{{ __('student.Continue') }}</span>
                                                                    <span
                                                                        class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn skip quiz_secondary_btn"
                                                                        id="skip">{{ __('student.Skip') }}
                                                                        {{ __('frontend.Question') }}</span>
                                                                @else
                                                                    <button type="button"
                                                                            data-question_id="{{ $assign->questionBank->id }}"
                                                                            data-assign_id="{{ $assign->id }}"
                                                                            data-question_type="{{ $assign->questionBank->type }}"
                                                                            class="submitBtn theme_btn small_btn  mr_20 quiz_primary_btn">
                                                                        {{ __('student.Submit') }}
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>



                @include(theme('partials._quiz_submit_confirm_modal'))
                @include(theme('partials._quiz_start_confirm_modal'))
            @endif

        @elseif($lesson->is_assignment == 1)
            @if (isModuleActive('Assignment'))

                @php

                    $assignment_info = $lesson->assignmentInfo;
                    if (Auth::check()) {
                        $submit_info = Modules\Assignment\Entities\InfixSubmitAssignment::assignmentLastSubmitted($assignment_info->id, Auth::user()->id);

                        if (Auth::user()->role_id == 1) {
                            $sty = '-150px';
                        } else {
                            if ($submit_info != null) {
                                $sty = '50px';
                            } else {
                                $sty = '280px';
                            }
                        }
                    } else {
                        $submit_info = null;
                        if ($submit_info != null) {
                            $sty = '50px';
                        } else {
                            $sty = '280px';
                        }
                    }
                @endphp
                <div class="col-lg-12 ps-5">

                    <style>
                        .assignment_info {
                            margin-top: 10px;
                        }
                    </style>
                    <div class="table-responsive-md table-responsive-sm assignment-info-table">
                        <table class="table">
                            <thead>
                            <h3 class="mb-0 ">{{ __('assignment.Assignment') }} {{ __('common.Details') }}</h3>
                            </thead>
                            <tr class="nowrap">
                                <td>
                                    {{ __('common.Title') }}
                                </td>
                                <td>
                                    : {{ @$assignment_info->title }}
                                </td>
                                <td>
                                    {{ __('courses.Course') }}
                                </td>
                                <td>
                                    @if ($assignment_info->course->title)
                                        : {{ @$assignment_info->course->title }}
                                    @else
                                        : {{ __('frontend.Not Assigned') }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="nowrap">
                                <td>
                                    {{ __('assignment.Marks') }}
                                </td>
                                <td>
                                    : {{ @$assignment_info->marks }}
                                </td>
                                <td>
                                    {{ __('assignment.Min Percentage') }}
                                </td>
                                <td>
                                    : {{ @$assignment_info->min_parcentage }}%
                                </td>
                            </tr>
                            @if ($submit_info != null)
                                <tr class="nowrap">
                                    <td>
                                        {{ __('assignment.Obtain Marks') }}
                                    </td>
                                    <td>
                                        : {{ @$submit_info->marks }}
                                    </td>
                                    <td>
                                        {{ __('common.Status') }}
                                    </td>
                                    <td>
                                        :

                                        @if ($submit_info->assigned->pass_status == 1)
                                            {{ __('frontend.Pass') }}
                                        @elseif($submit_info->assigned->pass_status == 2)
                                            {{ __('frontend.Fail') }}
                                        @else
                                            {{ __('frontend.Not Marked') }}
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>
                                    {{ __('assignment.Submit Date') }}
                                </td>
                                <td>
                                    : {{ showDate(@$assignment_info->last_date_submission) }}
                                </td>
                                <td>
                                    {{ __('assignment.Attachment') }}
                                </td>
                                <td>
                                    @if (fileExists($assignment_info->attachment))
                                        : <a href="{{assetPath(@$assignment_info->attachment) }}"
                                             download="{{ @$assignment_info->title }}_attachment">{{ __('common.Download') }}</a>
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>


                    <div class="row assignment_info">
                        <div class="col-lg-2">
                            {{ __('assignment.Description') }}
                        </div>
                        <div class="col-lg-12">
                            {!! @$assignment_info->description !!}
                        </div>
                    </div>

                    @php
                        $todate = today()->format('Y-m-d');
                    @endphp
                    @if (empty($submit_info))
                        @if (isset($assignment_info->last_date_submission) && Auth::user()->role_id == 3)
                            @if (
                                $todate <= $assignment_info->last_date_submission ||
                                    (isset($submit_info) && $submit_info->assigned->pass_status == 0))
                                @include(theme('partials._assignment_submit_section'))
                            @endif
                        @else
                            @if (isset($submit_info) && $submit_info->assigned->pass_status == 0 && Auth::user()->role_id == 3)
                                @include(theme('partials._assignment_submit_section'))
                            @endif
                        @endif
                    @endif

                </div>
            @endif
        @else

            <script>
                const course_id = "{{ $lesson->course_id }}"
            </script>


            @push('js')
                <script>
                    $("#autoNext").change(function () {
                        if ($(this).is(':checked')) {
                            localStorage.setItem('autoNext', 1);
                        } else {
                            localStorage.setItem('autoNext', 0);

                        }

                    });
                    if (localStorage.getItem('autoNext') == 0) {
                        $("#autoNext").prop('checked', false);
                    }
                    $("#autoNext").trigger('change');

                    function lessonAutoComplete(course_id, lesson_id) {
                        let status = $('#single_lesson_' + lesson_id).find('[type=checkbox]');
                        if (status.is(":checked")) {
                            return true;
                        }
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });


                        $.ajax({
                            type: 'GET',
                            "_token": "{{ csrf_token() }}",
                            url: '{{ route('lesson.complete.ajax') }}',
                            data: {
                                course_id: course_id,
                                lesson_id: lesson_id
                            },
                            success: function (data) {
                                if ($('#autoNext').is(':checked')) {
                                    @if (isModuleActive('Org') && $lesson->host == 'SCORM')
                                    $('#single_lesson_' + lesson_id).find('[type=checkbox]').prop('checked', true);
                                    @else
                                    reaload();
                                    @endif

                                }

                            }
                        });

                        function reaload() {
                            if ($('#next_lesson_btn').length) {
                                jQuery('#next_lesson_btn').click();
                            } else {
                                location.reload();
                            }
                        }

                        if (window.outerWidth < 425) {
                            $('.courseListPlayer').toggleClass("active");
                            $('.course_fullview_wrapper').toggleClass("active");
                        }
                    }
                </script>
            @endpush



            @if ($lesson->host == 'Vimeo')
                @php
                    if (Str::contains($lesson->video_url, '&')) {
                        $video_id = explode('=', $lesson->video_url);
                        $video_id = youtubeVideo($video_id[1]);
                    } else {
                        $video_id = getVideoId(showPicName(@$lesson->video_url));
                    }
                @endphp

                <div id="video-id" data-plyr-provider="{{strtolower($lesson->host)}}"
                     data-plyr-embed-id="{{$video_id}}"></div>

            @endif


            @if ($lesson->host == 'VdoCipher')
                <div id="embedBox" class="video_iframe"></div>

                <script>
                    (function (v, i, d, e, o) {
                        v[o] = v[o] || {
                            add: function V(a) {
                                (v[o].d = v[o].d || []).push(a);
                            }
                        };
                        if (!v[o].l) {
                            v[o].l = 1 * new Date();
                            a = i.createElement(d);
                            m = i.getElementsByTagName(d)[0];
                            a.async = 1;
                            a.src = e;
                            m.parentNode.insertBefore(a, m);
                        }
                    })(
                        window,
                        document,
                        "script",
                        "https://cdn-gce.vdocipher.com/playerAssets/1.6.10/vdo.js",
                        "vdo"
                    );
                    vdo.add({
                        otp: "{{ $lesson->otp }}",
                        playbackInfo: "{{ $lesson->playbackInfo }}",
                        theme: "9ae8bbe8dd964ddc9bdb932cca1cb59a",
                        container: document.querySelector("#embedBox"),
                        autoplay: true
                    });
                </script>

                <script>
                    var isRedirect = false;

                    function onVdoCipherAPIReady() {


                        let video = vdo.getObjects()[0];


                        setInterval(function () {
                            if (video.ended) {
                                if (!isRedirect) {
                                    if (!completeRequest) {
                                        lessonAutoComplete(course_id, {{ showPicName(Request::url()) }});
                                        completeRequest = true;
                                    }
                                    isRedirect = true;
                                }
                            }
                        }, 1000);
                    }
                </script>
            @endif

            @if (isModuleActive('BunnyStorage') && $lesson->host == 'BunnyStorage')
                @php
                    $time = Carbon::now()
                        ->addDay(1)
                        ->unix();
                    if ($lesson->bunnyLesson && $lesson->bunnyLesson->service_type == 'stream') {
                        $url = 'https://iframe.mediadelivery.net/embed/' . $lesson->bunnyLesson->library_id . '/' . $lesson->bunnyLesson->video_id;
                        $sha256 = hash('sha256', $lesson->bunnyLesson->token_authentication_key . $lesson->bunnyLesson->video_id . $time);
                        $url .= '?token=' . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                        $lesson_src = $url;
                    } elseif ($lesson->bunnyLesson && $lesson->bunnyLesson->service_type == 'storage') {
                        $bunnyStreamController = new BunnyStreamController();
                        $path = 'https://' . $lesson->bunnyLesson->zone_name . '.b-cdn.net/' . $lesson->bunnyLesson->name;
                        $url = $bunnyStreamController->sign_bcdn_url($path, $lesson->bunnyLesson->token_authentication_key, $time);
                        $lesson_src = $url;
                    } else {
                        $lesson_src = $lesson->video_url;
                    }
                @endphp


                <iframe src="{{ $lesson_src }}" loading="lazy" style="border: none; height: 100%; width: 100%;"
                        frameborder="0" controls="1"
                        allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"
                        allowfullscreen>
                </iframe>
            @endif

            @if ($lesson->host == 'Self' || $lesson->host == 'Storage')
                <video class="" id="video-id" controls autoplay>
                    <source src="{{assetPath($lesson->video_url) }}" type="video/mp4"/>
                    <source src="{{assetPath($lesson->video_url) }}" type="video/ogg">
                </video>
            @endif

            @if ($lesson->host == 'Editor')
                <style>
                    .lesson_content_text ul{
                        padding-left: 2rem;
                        margin: 0;
                    }
                    html[dir='rtl'].lesson_content_text ul{
                        padding-left: 0;
                        padding-right: 2rem;
                        margin: 0;
                    }
                    .lesson_content_text ul li{
                        list-style-type: unset;
                    }
                </style>
                <section class="mupo-editor-heading" aria-labelledby="mupo-current-lesson-title" style="--mupo-lesson-cover:url('{{ getCourseImage($course->thumbnail) }}')">
                    <div class="mupo-editor-copy">
                        <div class="mupo-editor-kicker">{{ optional($currentChapter)->name ?? 'Course Content' }}</div>
                        <h1 id="mupo-current-lesson-title">{{ $lesson->name }}</h1>
                        <p>Work through the lesson content below at your own pace. When you are finished, use Complete &amp; Continue to record your progress and move to the next lesson.</p>
                    </div>
                    <div class="mupo-hero-meta" aria-label="Lesson information">
                        <span class="mupo-hero-icon"><i class="fas fa-book-open" aria-hidden="true"></i></span>
                        <strong>Lesson {{ $currentLessonNumber }} of {{ $totalLessonCount ?: $total }}</strong>
                        <small><i class="far fa-clock" aria-hidden="true"></i> {{ MinuteFormat($lesson->duration) }}</small>
                    </div>
                </section>
                @include(theme('partials.guided-instructor-player'))
                <div class="lesson_content_text w-100 {{ $isEssentialKnowledge ? 'mupo-essential-knowledge' : '' }}">
                    @if($isEssentialKnowledge)
                        <div class="mupo-objectives-heading">
                            <span><i class="fas fa-bullseye" aria-hidden="true"></i></span>
                            <div><strong>Learning Objectives</strong><small>By the end of this lesson, you should be able to:</small></div>
                        </div>
                    @endif
                    {!! $lesson->editor !!}
                </div>
            @endif
            @if ($lesson->host == 'm3u8')
                <video class="" id="video-id" controls autoplay
                       onended="lessonAutoComplete(course_id, {{ showPicName(Request::url()) }})">
                >
                    <source src="{{ $lesson->video_url }}" type='application/x-mpegURL'/>
                </video>
            @endif



            @if ($lesson->host == 'URL')
                <video class="" id="video-id" controls autoplay>
                    <source src="{{ $lesson->video_url }}" type="video/mp4">
                    <source src="{{ $lesson->video_url }}" type="video/ogg">
                    Your browser does not support the video.
                </video>
            @endif
            @if ($lesson->host == 'AmazonS3')
                <video class=" " id="video-id" controls>
                    <source src="{{ $lesson->video_url }}" type="video/mp4"/>

                </video>
            @endif
            @if ($lesson->host == 'H5P' && isModuleActive('H5P'))
                @include('h5p::player', ['course' => $course, 'lesson' => $lesson])
            @endif
            @if ($lesson->host == 'XAPI' || $lesson->host == 'XAPI-AwsS3')
                <iframe id="video-id" class="video_iframe"
                        src="{{assetPath($lesson->video_url) }}?actor=%7B%22mbox%22%3A%22mailto%3A{{ Settings('email') }}%22%2C%22name%22%3A%22{{ Settings('site_title') }}%22%2C%22objectType%22%3A%22Agent%22%7D&amp;endpoint={{ url('xapi') }}&amp;course_id={{ $course->id }}&amp;lesson_id={{ $lesson->id }}&amp;next_lesson={{ $lesson_ids[$current_index + 1] ?? '' }}"></iframe>
            @endif
            @if ($lesson->host == 'SCORM' || $lesson->host == 'SCORM-AwsS3')
                @if (!empty($lesson->video_url))
                    <iframe class=" video_iframe" id="video-id" src=""
                            @if ($lesson->scorm_version == 'scorm_12') onbeforeunload="API.LMSFinish('');" width="100%"
                            height="100%" onunload="API.LMSFinish('');" @endif></iframe>
                @endif
            @endif

            @if ($lesson->host == 'Iframe' ||  $lesson->host =='Youtube')
                @if (!empty($lesson->video_url))
                    @php
                        $embedUrl = $lesson->video_url;

                        // Convert YouTube watch URL to embed URL
                        if ($lesson->host == 'Youtube') {
                            // Handle youtube.com/watch?v=VIDEO_ID format
                            if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $embedUrl, $matches)) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                            }
                            // Handle youtu.be/VIDEO_ID format
                            elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $embedUrl, $matches)) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                            }
                            // Handle youtube.com/embed/VIDEO_ID format (already correct)
                            elseif (!str_contains($embedUrl, 'youtube.com/embed/')) {
                                // If it's just a video ID
                                $embedUrl = 'https://www.youtube.com/embed/' . $embedUrl;
                            }
                        }
                    @endphp

                    <div class="plyr__video-embed video_iframe" id="video-id">
                        <iframe height="500"
                                src="{{ $embedUrl }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                                allowfullscreen allowtransparency allow="autoplay"></iframe>
                    </div>

                @endif
            @endif


            @if ($lesson->host == 'Image')
                <img src="{{assetPath($lesson->video_url) }}" alt="" class="w-100  h-100">
            @endif

            @if ($lesson->host == 'PDF')
                <script src="{{ assetPath('frontend/infixlmstheme/js/pdf.min.js') }}"></script>
                <script src="{{ assetPath('frontend/infixlmstheme/js/pdfjs-viewer.js') }}"></script>
                <script src="{{ assetPath('frontend/infixlmstheme/js/zoom.js') }}"></script>
                <link rel="stylesheet" href="{{ assetPath('frontend/infixlmstheme/css/pdfjs-viewer.css') }}"/>
                <style>
                    .pdfjs-viewer.h-100 {
                        max-height: calc(100vh - 50px);
                        overflow: auto;
                    }

                    .small_btn_icon {
                        padding: 10px;
                    }
                </style>

                <script>
                    var pdfjsLib = window['pdfjs-dist/build/pdf'];
                    pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ assetPath('frontend/infixlmstheme/js/pdf.worker.min.js') }}';
                </script>
                <div style="border: none;min-height: 400px" class="pdfviewer w-100  h-100">
                    <div class="pdftoolbar text-center row m-0 p-0">
                        <div class="col-12 col-lg-12 my-1">
                            <button class="theme_btn small_btn_icon btn-first" onclick="pdfViewer.first()"><i
                                    class="fa fa-step-backward"></i></button>
                            <button class="theme_btn small_btn_icon btn-prev" onclick="pdfViewer.prev(); return false;">
                                <i class="fa fa-angle-left"></i></button>
                            <span class="pageno"></span>
                            <button class="theme_btn small_btn_icon btn-next" onclick="pdfViewer.next(); return false;">
                                <i class="fa fa-angle-right"></i></button>
                            <button class="theme_btn small_btn_icon btn-last" onclick="pdfViewer.last()"><i
                                    class="fa fa-step-forward"></i></button>
                            <button class="theme_btn small_btn_icon" onclick="pdfViewer.setZoom('out')"><i
                                    class="fa fa-search-minus"></i></button>
                            <span class="zoomval">100%</span>
                            <button class="theme_btn small_btn_icon" onclick="pdfViewer.setZoom('in')"><i
                                    class="fa fa-search-plus"></i></button>
                            <button class="theme_btn small_btn_icon ms-3" onclick="pdfViewer.setZoom('width')"><i
                                    class="fa fa-arrows-alt-h"></i></button>
                            <button class="theme_btn small_btn_icon" onclick="pdfViewer.setZoom('height')"><i
                                    class="fa fa-arrows-alt-v"></i></button>
                            <button class="theme_btn small_btn_icon" onclick="pdfViewer.setZoom('fit')"><i
                                    class="fa fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="pdfjs-viewer h-100">
                    </div>
                </div>

                <script>
                    let pdfViewer = new PDFjsViewer($('.pdfjs-viewer'), {
                        setZoom: -1,
                        maxImageSize: -1,
                        onZoomChange: function (zoom) {
                            zoom = parseInt(zoom * 10000) / 100;
                            $(".zoomval").text(zoom + "%");
                        },
                        onActivePageChanged: function (page, pageno) {
                            $(".pageno").text(pageno + "/" + this.getPageCount());
                        }

                    });
                    pdfViewer.loadDocument("{{assetPath($lesson->video_url) }}").then(function () {
                        // pdfViewer.setZoom('width');
                    });
                    enablePinchZoom(pdfViewer)
                </script>
            @endif
            @if ($lesson->host == 'Word')
                <iframe class="w-100  h-100 mobile-min-height"
                        src="https://docs.google.com/gview?url={{assetPath($lesson->video_url) }}&embedded=true"></iframe>
            @endif
            @if ($lesson->host == 'Excel' || $lesson->host == 'PowerPoint')
                <iframe class="w-100  h-100 mobile-min-height"
                        src="https://view.officeapps.live.com/op/view.aspx?src={{assetPath($lesson->video_url) }}"></iframe>
            @endif

            @if ($lesson->host == 'GoogleDrive')
                {{--                <iframe class="w-100  h-100" controlsList="nodownload"--}}
                {{--                        src="https://drive.google.com/uc?id={{ $lesson->video_url }}&export=view"></iframe>--}}
                <iframe class="w-100  h-100" controlsList="nodownload"
                        src="https://drive.google.com/file/d/{{$lesson->video_url}}/preview"></iframe>
            @endif

            @if ($lesson->host == 'Text')
                <div class="w-100  h-100 textViewer">

                </div>
                <script>
                    $(".textViewer").load("{{assetPath($lesson->video_url) }}");
                </script>
            @endif


            {{-- Iframe video --}}
{{--            @push('js')--}}
{{--                @if ($lesson->host == 'Iframe')--}}
{{--                    <script>--}}
{{--                        $(document).ready(function (e) {--}}
{{--                            if ($('#video-id').length) {--}}
{{--                                var iframe = document.getElementById("video-id");--}}
{{--                                // console.log(iframe);--}}
{{--                                var video = iframe.contentDocument.body.getElementsByTagName("video")[0];--}}
{{--                                var supposedCurrentTime = 0;--}}
{{--                                video.addEventListener('timeupdate', function () {--}}
{{--                                    if (!video.seeking) {--}}
{{--                                        supposedCurrentTime = video.currentTime;--}}
{{--                                    }--}}
{{--                                });--}}
{{--                                // prevent user from seeking--}}
{{--                                video.addEventListener('seeking', function () {--}}
{{--                                    // guard agains infinite recursion:--}}
{{--                                    // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....--}}
{{--                                    var delta = video.currentTime - supposedCurrentTime;--}}
{{--                                    if (Math.abs(delta) > 0.01) {--}}
{{--                                        console.log("Seeking is disabled");--}}
{{--                                        video.currentTime = supposedCurrentTime;--}}
{{--                                    }--}}
{{--                                });--}}
{{--                                // delete the following event handler if rewind is not required--}}
{{--                                video.addEventListener('ended', function () {--}}
{{--                                    if (!completeRequest) {--}}
{{--                                        lessonAutoComplete(course_id, {{ showPicName(Request::url()) }});--}}
{{--                                        completeRequest = true;--}}
{{--                                    }--}}

{{--                                    // reset state in order to allow for rewind--}}
{{--                                    console.log('video end');--}}
{{--                                    supposedCurrentTime = 0;--}}
{{--                                });--}}
{{--                            }--}}
{{--                        });--}}
{{--                    </script>--}}
{{--                @endif--}}
{{--            @endpush--}}
            @if ($lesson->host == 'Zip')
                <style>
                    .parent {
                        position: fixed;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .child {
                        position: relative;
                        font-size: 10vw;
                    }
                </style>
                <div class="w-100 parent  h-100 ">
                    <div class="">
                        <div class="row">
                            <div class="col  text-center">
                                <div class="child">
                                    <a class="theme_btn " href="{{assetPath($lesson->video_url) }}"
                                       download="">{{ __('frontend.Download File') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        @endif
        {{-- </div> --}}


        <input type="hidden" id="url" value="{{ url('/') }}">
        <div class="floating-title position-fixed">
            <p class="font_16 d-flex align-items-center">
                <span class="header__common_btn me-2 play_toggle_btn"><i
                        class="ti-menu-alt"></i></span> {{ @$total }} {{ __('common.Lessons') }}
            </p>
        </div>
        <div class="course__play_warp courseListPlayer ">
            <div id="mupoCoursePanelContent">
            <div class="play_warp_header"><div class="mupo-content-head"><div><h3>Course Progress</h3></div><strong>{{ $percentage }}%</strong></div><div class="mupo-progress-line"><span style="width:{{ $percentage }}%"></span></div><div class="mupo-content-sub">{{ $completedLessonCount }} of {{ $totalLessonCount ?: $total }} lessons completed</div></div>
            <div class="mupo-side-search"><div class="mupo-side-search-wrap"><i class="fas fa-search"></i><input type="search" id="mupoLessonSearch" placeholder="Search lessons..." autocomplete="off"></div></div>
            <div class="course__play_list">
                @php
                    $i = 1;
                @endphp
                <div class="theme_according mb_30 accordion" id="accordion1">
                    @foreach ($chapters as $k => $chapter)
                        <div class="accordion-item">
                            <div class="accordion-header" id="heading{{ $chapter->id }}">
                                <h5 class="mb-0">
                                    <button class="accordion-button {{ $lesson->chapter_id == $chapter->id ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $chapter->id }}" aria-expanded="{{ $lesson->chapter_id == $chapter->id ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $chapter->id }}">
                                        {{ $chapter->name }} <br>
                                        <span class="course_length nowrap">
                                            @if (!isModuleActive('Assignment'))
                                                {{ count($chapter->lessons->where('is_assignment', 0)) }}
                                            @else
                                                {{ count($chapter->lessons) }}
                                            @endif

                                            {{ __('frontend.Lectures') }}
                                        </span>
                                    </button>
                                </h5>
                            </div>
                            <div class="collapse {{ $lesson->chapter_id == $chapter->id ? 'show' : '' }}" id="collapse{{ $chapter->id }}"
                                 aria-labelledby="heading{{ $chapter->id }}" data-bs-parent="#accordion1">
                                <div class="accordion-body">
                                    <div class="curriculam_list">
                                        @if (isset($lessons))

                                            @foreach ($lessons as $key => $singleLesson)
                                                @if ($singleLesson->chapter_id == $chapter->id)
                                                    @php
                                                        if ($singleLesson->is_quiz == 1 && $singleLesson->quiz->count() == 0) {
                                                            continue;
                                                        }
                                                        if ($singleLesson->is_assignment == 1 && !isModuleActive('Assignment')) {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <div class="single_play_list"
                                                         id="single_lesson_{{ $singleLesson->id }}">
                                                        <a class="mupo-curriculum-lesson-link @if (showPicName(Request::url()) == $singleLesson->id) active @endif"
                                                           data-lesson-id="{{ $singleLesson->id }}"
                                                           @if(request()->route('lesson_id') == $singleLesson->id) aria-current="page" @endif
                                                           href="{{ route('fullScreenView', [$course->id, $singleLesson->id]) }}">

                                                            @if ($singleLesson->is_quiz == 1)
                                                                <div class="course_play_name">

                                                                    <label class="primary_checkbox d-flex mb-0">
                                                                        <input type="checkbox"
                                                                               {{ $singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : '' }}
                                                                               disabled>
                                                                        <span class="checkmark mr_15"
                                                                              style="cursor: not-allowed"></span>

                                                                        <i class="ti-check-box"></i>
                                                                    </label>
                                                                    @foreach ($singleLesson->quiz as $quiz)
                                                                        <span class="quizLink">
                                                                            <span class="quiz_name">{{ $i }}.
                                                                                {{ @$quiz->title }}</span>
                                                                        </span>
                                                                </div>
                                                                @endforeach
                                                            @else
                                                                <div class="course_play_name">
                                                                    @if (request()->route('lesson_id') == $singleLesson->id)
                                                                        <div
                                                                            class="remember_forgot_pass d-flex justify-content-between">
                                                                            <label class="primary_checkbox d-flex mb-0">
                                                                                @if ($isEnrolled)
                                                                                    <input type="checkbox"
                                                                                           {{ $singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : '' }}
                                                                                           disabled>
                                                                                    <span style="cursor: not-allowed"
                                                                                          class="checkmark mr_15"></span>
                                                                                    <i class="ti-control-play"></i>
                                                                                @else
                                                                                    <i class="ti-control-play"></i>
                                                                                @endif
                                                                            </label>
                                                                        </div>
                                                                    @else
                                                                        <label class="primary_checkbox d-flex mb-0">
                                                                            <input type="checkbox"
                                                                                {{ $singleLesson->completed && $singleLesson->completed->status == 1 ? 'checked' : '' }}>
                                                                            <span style="cursor: not-allowed"
                                                                                  class="checkmark mr_15"></span>

                                                                            <i class="ti-control-play"></i>
                                                                        </label>
                                                                    @endif

                                                                    <span>{{ $i }}.
                                                                    {{ $singleLesson->name }} </span>
                                                                </div>
                                                                <span
                                                                    class="course_play_duration nowrap">{{ MinuteFormat($singleLesson->duration) }}</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center text-center">
                    @if ($certificate && $certificate->id > 0  && !Settings('manually_assign_certificate'))
                        @if ($quizPass)
                            @auth()
                                @if ($percentage >= 100)
                                    @if (isModuleActive('Survey') && $course->survey)
                                        @if (Settings('must_survey_before_certificate'))
                                            @if (auth()->user()->attendSurvey($course->survey))
                                                <a href="{{ route('getCertificate', [$course->id, $course->title]) }}"
                                                   class="theme_btn certificate_btn mt-5 mb-5">
                                                    {{ __('frontend.Get Certificate') }}
                                                </a>
                                                @if (isModuleActive('MyClass'))
                                                    <a href="{{ route('get-transcript', [$course->id, auth()->user()->id]) }}"
                                                       class="theme_btn certificate_btn mt-5 mb-5 ms-2"
                                                       target="__blank">{{ __('class.Get Transcript') }}</a>
                                                @endif
                                            @else
                                                <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#assignSubmit"
                                                        class="theme_btn certificate_btn mt-5 mb-5">
                                                    {{ __('frontend.Survey') }}
                                                </button>
                                                <small>
                                                    {{ __('frontend.You must attend survey before getting certificate') }}
                                                </small>
                                            @endif
                                        @else
                                            @if (!auth()->user()->attendSurvey($course->survey))
                                                <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#assignSubmit"
                                                        class="theme_btn certificate_btn mt-5 mb-5 me-1">
                                                    {{ __('frontend.Survey') }}
                                                </button>
                                            @endif
                                            <a href="{{ route('getCertificate', [$course->id, $course->title]) }}"
                                               class="theme_btn certificate_btn mt-5 mb-5 ms-1">
                                                {{ __('frontend.Get Certificate') }}
                                            </a>
                                            @if (isModuleActive('MyClass'))
                                                <a href="{{ route('get-transcript', [$course->id, auth()->user()->id]) }}"
                                                   class="theme_btn certificate_btn mt-5 mb-5 ms-2"
                                                   target="__blank">{{ __('class.Get Transcript') }}</a>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{ route('getCertificate', [$course->id, $course->title]) }}"
                                           class="theme_btn certificate_btn mt-5 mb-5">
                                            {{ __('frontend.Get Certificate') }}
                                        </a>
                                        @if (isModuleActive('MyClass'))
                                            <a href="{{ route('get-transcript', [$course->id, auth()->user()->id]) }}"
                                               class="theme_btn certificate_btn mt-5 mb-5 ms-2"
                                               target="__blank">{{ __('class.Get Transcript') }}</a>
                                        @endif
                                    @endif
                                @endif
                            @endauth
                        @endif
                    @endif

                </div>
            </div>
                <div class="pb-5 mb-5 d-none">
                    <div>{{ __('frontend.Current Time') }}: <span id="currentTime">0</span></div>
                    <div>{{ __('frontend.Total Time') }} : <span id="totalTime">0</span></div>
                    <div>{{ __('frontend.Status') }} : <span class="status"></span></div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade " id="ShareLink" tabindex="-1" role="dialog" aria-labelledby=" " aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('frontend.Share this course') }}

                    </h5>
                </div>

                <div class="modal-body">


                    <div class="row mb-20">
                        <div class="col-md-12">
                            <input type="text" required class="primary_input mb_20" name=""
                                   value="{{ URL::current() }}">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="social_btns ">
                                <a target="_blank"
                                   href="https://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}"
                                   class="social_btn fb_bg"> <i class="fab fa-facebook-f"></i>
                                </a>
                                <a target="_blank"
                                   href="https://twitter.com/intent/tweet?text={{ $course->title }}&amp;url={{ URL::current() }}"
                                   class="social_btn Twitter_bg"> <i class="fab fa-twitter"></i> </a>
                                <a target="_blank"
                                   href="https://pinterest.com/pin/create/link/?url={{ URL::current() }}&amp;description={{ $course->title }}"
                                   class="social_btn Pinterest_bg"> <i class="fab fa-pinterest-p"></i> </a>
                                <a target="_blank"
                                   href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ URL::current() }}&amp;title={{ $course->title }}&amp;summary={{ $course->title }}"
                                   class="social_btn Linkedin_bg"> <i class="fab fa-linkedin-in"></i> </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade " id="courseRating" tabindex="-1" role="dialog" aria-labelledby=" " aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('frontend.Rate this course') }}

                    </h5>
                </div>
                <div class="modal-body">


                    <div class="row mb-20">
                        <div class="col-md-12">
                            <div class="rating_star text-end">

                                @php
                                    $PickId = $course->id;
                                @endphp
                                @if (Auth::check())
                                    @if (Auth::user()->role_id == 3)
                                        @if (!in_array(Auth::user()->id, $reviewer_user_ids))
                                            <div class="star_icon d-flex align-items-center justify-content-between">
                                                <a class="rating">
                                                    <input type="radio" id="star5" name="rating" value="5"
                                                           class="rating"/><label class="full" for="star5"
                                                                                  id="star5" title="Awesome - 5 stars"
                                                                                  onclick="Rates(5, {{ @$PickId }})"></label>

                                                    <input type="radio" id="star4" name="rating" value="4"
                                                           class="rating"/><label class="full" for="star4"
                                                                                  title="Pretty good - 4 stars"
                                                                                  onclick="Rates(4, {{ @$PickId }})"></label>

                                                    <input type="radio" id="star3" name="rating" value="3"
                                                           class="rating"/><label class="full" for="star3"
                                                                                  title="Meh - 3 stars"
                                                                                  onclick="Rates(3, {{ @$PickId }})"></label>
                                                    <input type="radio" id="star2" name="rating" value="2"
                                                           class="rating"/><label class="full" for="star2"
                                                                                  title="Kinda bad - 2 stars"
                                                                                  onclick="Rates(2, {{ @$PickId }})"></label>

                                                    <input type="radio" id="star1" name="rating" value="1"
                                                           class="rating"/><label class="full" for="star1"
                                                                                  title="Bad  - 1 star"
                                                                                  onclick="Rates(1,{{ @$PickId }})"></label>

                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <p class="font_14 f_w_400 mt-0"><a href="{{ url('login') }}"
                                                                       class="theme_color2">{{ __('frontend.Sign In') }}</a>
                                        {{ __('frontend.or') }} <a class="theme_color2"
                                                                   href="{{ url('register') }}">{{ __('frontend.Sign Up') }}</a>
                                        {{ __('frontend.as student to post a review') }}</p>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
                </div>

                <form action="{{ route('submitReview') }}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="course_id" id="rating_course_id" value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                            <textarea class="form-control" name="review" name="" id=""
                                      placeholder="{{ __('frontend.Write your review') }}" cols="30"
                                      rows="10">{{ old('review') }}</textarea>
                            <span class="text-danger" role="alert">{{ $errors->first('review') }}</span>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn me-2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn " type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include(theme('partials._qna_modal'))
    <div id="logDisplay">
    </div>
    @if (isModuleActive('Survey') && $course->survey)
        @include(theme('partials._survey_model'))
    @endif
    @if(isModuleActive("WhatsappSupport"))
        @include('whatsappsupport::partials._popup')
    @endif

    <div class="mupo-bottom-nav">
        <div>@if($previousLessonId)<a href="javascript:void(0)" class="mupo-nav-btn" onclick="goFullScreen({{ $course->id }},{{ $previousLessonId }})"><i class="fas fa-arrow-left"></i><span>Previous Lesson</span></a>@else<span class="mupo-nav-btn disabled"><i class="fas fa-arrow-left"></i><span>Previous Lesson</span></span>@endif</div>
        <div class="mupo-bottom-center"><strong>Lesson {{ $currentLessonNumber }} of {{ $totalLessonCount ?: $total }}</strong><span>{{ optional($currentChapter)->name ?? 'Course Content' }}</span></div>
        <div class="mupo-bottom-right">
            @if($lesson->is_quiz != 1)
                <button type="button" class="mupo-complete-btn completeAndPlayNext" data-course-id="{{ $course->id }}" data-lesson-id="{{ $lesson->id }}" data-next-lesson-id="{{ $nextLessonId }}" data-completed="{{ $isCurrentLessonComplete ? '1' : '0' }}"><i class="fas {{ $isCurrentLessonComplete ? 'fa-check-circle' : 'fa-check' }}"></i><span class="complete-button-label">{{ $nextLessonId ? 'Complete & Continue' : ($isCurrentLessonComplete ? 'Completed' : 'Mark as Complete') }}</span>@if($nextLessonId)<i class="fas fa-arrow-right"></i>@endif</button>
            @elseif($nextLessonId)<a href="javascript:void(0)" class="mupo-complete-btn" onclick="goFullScreen({{ $course->id }},{{ $nextLessonId }})">Complete &amp; Continue <i class="fas fa-arrow-right"></i></a>@endif
        </div>
    </div>

@endsection
@push('js')
    @if(isModuleActive("WhatsappSupport"))
        <script src="{{assetPath('whatsapp-support/scripts.js')}}{{assetVersion()}}"></script>
    @endif

    <script>
        $(document).ready(function () {
            const portalBody = document.body;
            const portalSidebar = document.getElementById('mupoLearnerSidebar');
            const portalCollapse = document.getElementById('mupoSidebarCollapse');
            const portalOpen = document.getElementById('mupoLearningNavOpen');
            const portalClose = portalSidebar ? portalSidebar.querySelector('.sidebar_close_icon') : null;
            const portalOverlay = document.getElementById('mupoLearningNavOverlay');

            function setPortalNavOpen(open) {
                portalBody.classList.toggle('mupo-portal-nav-open', Boolean(open));
                if (portalOpen) {
                    portalOpen.setAttribute('aria-expanded', open ? 'true' : 'false');
                }
            }

            if (window.innerWidth >= 1280 && localStorage.getItem('mupoLearnerSidebarCollapsed') === '1') {
                portalBody.classList.add('mupo-sidebar-collapsed');
            }

            if (portalCollapse) {
                portalCollapse.addEventListener('click', function () {
                    portalBody.classList.toggle('mupo-sidebar-collapsed');
                    localStorage.setItem(
                        'mupoLearnerSidebarCollapsed',
                        portalBody.classList.contains('mupo-sidebar-collapsed') ? '1' : '0'
                    );
                });
            }
            if (portalOpen) portalOpen.addEventListener('click', function () { setPortalNavOpen(true); });
            if (portalClose) portalClose.addEventListener('click', function () { setPortalNavOpen(false); });
            if (portalOverlay) portalOverlay.addEventListener('click', function () { setPortalNavOpen(false); });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') setPortalNavOpen(false);
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 992) setPortalNavOpen(false);
            });

            if ($('.active').length) {
                let active = $('.active');
                let parent = active.parents('.collapse').first();
                parent.addClass('show');
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            let course = '{{ $course->id }}';
            let lesson = '{{ $lesson->id }}';

            $(document).off('click.mupoLessonRoute', '.mupo-curriculum-lesson-link')
                .on('click.mupoLessonRoute', '.mupo-curriculum-lesson-link', function (event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    const destination = this.href;
                    if (!destination || this.getAttribute('aria-current') === 'page') return;
                    window.location.assign(destination);
                });

            /*       $("iframe").each(function () {
                       //Using closures to capture each one
                       var iframe = $(this);
                       iframe.on("load", function () { //Make sure it is fully loaded
                           iframe.contents().click(function (event) {
                               iframe.trigger("click");
                           });

                       });

                       iframe.click(function () {
                           $.ajax({
                               type: 'POST',
                               "_token": "{{ csrf_token() }}",
                            url: '{{ route('lesson.complete.ajax') }}',
                            data: {course_id: course, lesson_id: lesson},
                            success: function (data) {

                            }
                        });
                    });
                });*/

            if (window.outerWidth < 425) {
                $('.courseListPlayer').toggleClass("active");
                $('.course_fullview_wrapper').toggleClass("active");
            }


            // Keep the lesson curriculum visible consistently on desktop.
            function keepCurriculumVisible() {
                if (window.innerWidth >= 1200) {
                    $('.courseListPlayer').removeClass('active');
                    $('.course_fullview_wrapper').removeClass('active');
                    $('.floating-title').hide();
                }
            }
            keepCurriculumVisible();
            $(window).on('resize', keepCurriculumVisible);


            $('#mupoLessonSearch').on('input', function () {
                const query = String($(this).val() || '').trim().toLowerCase();
                $('#accordion1 .accordion-item').each(function () {
                    const chapter = $(this);
                    let visibleLessons = 0;
                    chapter.find('.single_play_list').each(function () {
                        const row = $(this);
                        const match = !query || row.text().toLowerCase().indexOf(query) !== -1;
                        row.toggle(match);
                        if (match) visibleLessons++;
                    });
                    const chapterMatch = !query || chapter.find('.accordion-button').first().text().toLowerCase().indexOf(query) !== -1;
                    chapter.toggle(chapterMatch || visibleLessons > 0);
                    if (query && visibleLessons > 0) chapter.find('.collapse').addClass('show');
                });
            });

            // Reliable completion flow: save first, update the UI, then continue.
            $(document).off('click.mupoComplete', '.completeAndPlayNext').on('click.mupoComplete', '.completeAndPlayNext', function (event) {
                event.preventDefault();
                const button = $(this);
                if (button.data('busy') === 1) {
                    return;
                }

                const nextLessonId = parseInt(button.attr('data-next-lesson-id') || '0', 10);
                const originalLabel = button.find('.complete-button-label').text();
                button.data('busy', 1).prop('disabled', true).addClass('is-saving');
                button.find('.complete-button-label').text('Saving progress...');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('lesson.complete.ajax') }}',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: course,
                        lesson_id: lesson
                    }
                }).done(function (data) {
                    if (data === false || (data && data.success === false)) {
                        button.prop('disabled', false).data('busy', 0).removeClass('is-saving');
                        button.find('.complete-button-label').text(originalLabel);
                        if (window.toastr) {
                            toastr.error('We could not save your progress. Please try again.');
                        } else {
                            alert('We could not save your progress. Please try again.');
                        }
                        return;
                    }

                    $('#single_lesson_' + lesson).find('[type=checkbox]').prop('checked', true);
                    button.attr('data-completed', '1');
                    button.find('i').removeClass('fa-check').addClass('fa-check-circle');

                    if (nextLessonId > 0) {
                        button.find('.complete-button-label').text('Completed - Opening next lesson...');
                        window.setTimeout(function () {
                            goFullScreen(parseInt(course, 10), nextLessonId);
                        }, 350);
                    } else {
                        button.find('.complete-button-label').text('Course Lesson Completed');
                        button.removeClass('is-saving').addClass('is-complete');
                        button.prop('disabled', false).data('busy', 0);
                    }
                }).fail(function (xhr) {
                    button.prop('disabled', false).data('busy', 0).removeClass('is-saving');
                    button.find('.complete-button-label').text(originalLabel);
                    const message = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'We could not save your progress. Please try again.';
                    if (window.toastr) {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                });
            });
        });
    </script>

    @if ($lesson->host == 'Self' || $lesson->host == 'AmazonS3' || $lesson->host == 'URL' || $lesson->host == 'Youtube' || $lesson->host == 'Iframe'|| $lesson->host == 'Vimeo')
        <script src="{{assetPath('plugins/plyr/plyr.js')}}" type="application/javascript"></script>
        <link rel="stylesheet" href="{{assetPath('plugins/plyr/plyr.css')}}">
        <script>

            const player = new Plyr('#video-id', {
                controls: [
                    'play-large', 'rewind', 'play', 'fast-forward', '{{Settings('show_seek_bar')?'progress':''}}', 'current-time',
                    'duration', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'
                ],
                autoplay: true,
                muted: false,
                volume: 0.8,
                clickToPlay: true,
                seekTime: 5,
                speed: {selected: 1, options: [0.5, 1, 1.5, 2]},
                fullscreen: {enabled: true, fallback: true},
                keyboard: {focused: true, global: false},
                tooltips: {controls: true, seek: true},
                youtube: {
                     controls: 1,
                    modestBranding: false,
                    showinfo: 1,
                    rel: 1,
                    iv_load_policy: 3,
                    cc_load_policy: 1,
                    autoplay: false,
                    loop: false,
                    mute: false,
                    start: 0,
                    end: null
                }
            });

            player.on('ended', () => {
                lessonAutoComplete(course_id, {{ showPicName(Request::url()) }})
            });


        </script>

    @endif

    @if ($lesson->host == 'm3u8')
        <script>
            let myFP = fluidPlayer(
                'video-id', {
                    "layoutControls": {
                        "controlBar": {
                            "autoHideTimeout": 3,
                            "animated": true,
                            "autoHide": true
                        },
                        "htmlOnPauseBlock": {
                            "html": null,
                            "height": null,
                            "width": null
                        },
                        "autoPlay": true,
                        "mute": false,
                        "hideWithControls": true,
                        "allowTheatre": true,
                        "playPauseAnimation": true,
                        "playbackRateEnabled": true,
                        "allowDownload": false,
                        "playButtonShowing": true,
                        "fillToContainer": true,
                        "posterImage": "{{getCourseImage($course->image)}}",
                        "doubleClickFullscreen": true,
                        "keyboardControl": true,
                    },

                    "vastOptions": {
                        "adList": [],
                        "adCTAText": false,
                        "adCTATextPosition": ""
                    }
                });
        </script>
    @endif
    <script src="{{ assetPath('frontend/infixlmstheme/js/app.js') }}{{assetVersion()}}"></script>
    <script src="{{ assetPath('backend/js/jquery-ui.js') }}{{assetVersion()}}"></script>
    <script src="{{ assetPath('backend/js/jquery.ui.touch-punch.min.js') }}{{assetVersion()}}"></script>

    <script src="{{ assetPath('frontend/infixlmstheme/js/class_details.js') }}"></script>
    <script src="{{ assetPath('frontend/infixlmstheme/js/full_screen_video.js') }}"></script>
    <script src="{{ asset('mupo/assets/js/guided-instructor.js') }}?v={{ filemtime(public_path('mupo/assets/js/guided-instructor.js')) }}"></script>
    @if ($lesson->is_quiz == 1)
        @if (!$result)
            <script src="{{ assetPath('frontend/infixlmstheme/js/quiz_start.js') }}"></script>
        @endif
        @include(theme('partials._quiz_exp_script'))
    @endif



    @include(theme('partials.fullscreen_video._summernote_script'))
    @include(theme('partials.fullscreen_video._scorm_script'))
@endpush
