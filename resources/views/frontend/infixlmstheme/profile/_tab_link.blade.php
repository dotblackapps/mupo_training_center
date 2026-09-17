<style>
    .primary_input {
        border-radius: 30px !important
    }
</style>
<ul class="nav nav-tabs ms-0 mb-3 border-0">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab"
           href="#basic_information_tab"><i class="far fa-user"></i>{{__('profile.basic_information')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#change_password_tab"><i class="fas fa-lock"></i>{{__('profile.change_password')}}</a>
    </li>
    @if(isModuleActive('TwoFA') && Settings('enable_student_two_fa'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#fa_tab">{{__('profile.2FA')}}</a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#images_tab"><i class="far fa-image"></i>{{__('profile.images')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#about_tab"><i class="far fa-address-card"></i>{{__('common.About')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#education_tab"><i class="fas fa-graduation-cap"></i>{{__('profile.education')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#experience_tab"><i class="fas fa-briefcase"></i>{{__('profile.experience')}}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#skills_tab"><i class="fas fa-tools"></i>{{__('profile.skills')}}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#financial_tab"><i class="fas fa-wallet"></i>{{__('profile.financial')}}</a>
    </li>

    {{--    <li class="nav-item">--}}
    {{--        <a class="nav-link" data-bs-toggle="tab" href="#api_tab">{{__('profile.api')}}</a>--}}
    {{--    </li>--}}

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#extra_info_tab"><i class="fas fa-info-circle"></i>{{__('profile.extra_information')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#identity_tab"><i class="far fa-id-card"></i>{{__('profile.identity_and_documents')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#social_tab"><i class="fas fa-address-book"></i>{{__('profile.social_and_contact')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#delete_account_tab"><i class="fas fa-user-times"></i>{{__('profile.delete_account')}}</a>
    </li>
</ul>
