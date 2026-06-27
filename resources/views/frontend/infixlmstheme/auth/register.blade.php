@extends(theme('auth.layouts.app'))

@section('content')
    <div class="login_wrapper">
        <div class="login_wrapper_left">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 190px"
                         src="{{ assetPath('uploads/settings/mupo-logo_1.jpeg') }}"
                         alt="MUPO Training Center">
                </a>
            </div>

            <div class="login_wrapper_content">
                <h4>Sign Up Details</h4>

                <form action="{{ route('register') }}" method="POST" id="regForm">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" class="form-control ps-0" required
                                       placeholder="Enter Full Name *"
                                       name="name" value="{{ old('name') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-email"></i></span>
                                </div>
                                <input type="email" class="form-control ps-0" required
                                       placeholder="Enter Email *"
                                       name="email" value="{{ old('email') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-mobile"></i></span>
                                </div>
                                <input type="text" class="form-control ps-0"
                                       placeholder="Enter Phone Number"
                                       name="phone" value="{{ old('phone') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control ps-0"
                                       name="dob" value="{{ old('dob') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('dob') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-lock"></i></span>
                                </div>
                                <input type="password" class="form-control ps-0" required
                                       placeholder="Enter Password *"
                                       name="password"
                                       autocomplete="new-password">
                            </div>
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-lock"></i></span>
                                </div>
                                <input type="password" class="form-control ps-0" required
                                       placeholder="Enter Confirm Password *"
                                       name="password_confirmation">
                            </div>
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-briefcase"></i></span>
                                </div>
                                <input type="text" class="form-control ps-0"
                                       placeholder="Enter Company"
                                       name="company" value="{{ old('company') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('company') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-id-badge"></i></span>
                                </div>
                                <input type="text" class="form-control ps-0"
                                       placeholder="Enter Identification Number"
                                       name="identification_number"
                                       value="{{ old('identification_number') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('identification_number') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-briefcase"></i></span>
                                </div>
                                <input type="text" class="form-control ps-0"
                                       placeholder="Enter Job Title"
                                       name="job_title"
                                       value="{{ old('job_title') }}">
                            </div>
                            <span class="text-danger">{{ $errors->first('job_title') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-user"></i></span>
                                </div>
                                <select name="gender" class="form-control ps-0">
                                    <option value="">Choose Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </div>
                            <span class="text-danger">{{ $errors->first('gender') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-list"></i></span>
                                </div>
                                <select name="student_type" class="form-control ps-0">
                                    <option value="">Choose Student Type</option>
                                    <option value="personal" {{ old('student_type') == 'personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="corporate" {{ old('student_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                </select>
                            </div>
                            <span class="text-danger">{{ $errors->first('student_type') }}</span>
                        </div>

                        <div class="col-md-6 col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-home"></i></span>
                                </div>
                                <select name="institute" class="form-control ps-0">
                                    <option value="">Choose Institute</option>
                                    <option value="PRASA" {{ old('institute') == 'PRASA' ? 'selected' : '' }}>PRASA</option>
                                </select>
                            </div>
                            <span class="text-danger">{{ $errors->first('institute') }}</span>
                        </div>

                        <div class="col-12 mt_20">
                            <div class="remember_forgot_passs d-flex align-items-center">
                                <label class="primary_checkbox d-flex" for="checkbox">
                                    <input type="checkbox" id="checkbox" required>
                                    <span class="checkmark mr_15"></span>
                                    <p>
                                        By signing up, you agree to
                                        <a target="_blank" href="{{ url('terms') }}">Terms of Service</a>
                                        and
                                        <a target="_blank" href="{{ url('privacy') }}">Privacy Policy</a>
                                    </p>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mt_20">
                            <button type="submit" class="theme_btn text-center w-100 disable_btn" disabled id="submitBtn">
                                Register
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <h5 class="shitch_text mb-0">
                You have already an account?
                <a href="{{ route('login') }}">Login</a>
            </h5>
        </div>

        @include(theme('auth.login_wrapper_right'))
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