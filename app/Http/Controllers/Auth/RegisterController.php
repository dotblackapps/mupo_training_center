<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\StudentCustomField;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\FrontendManage\Entities\LoginPage;
use Modules\Payment\Entities\Cart;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    public function RegisterForm()
    {
        abort_if(!Settings('student_reg'), 404);
        abort_if(saasPlanCheck('student'), 404);

        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();

        return view(theme('auth.register'), compact('page', 'custom_field'));
    }

    public function LmsRegisterForm()
    {
        abort_if(!isModuleActive('LmsSaas') && !isModuleActive('LmsSaasMD'), 404);
        abort_if(SaasDomain() != 'main', 404);

        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();

        return view(theme('auth.lms_register'), compact('page', 'custom_field'));
    }

    public function showRegistrationForm()
    {
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();

        return view(theme('auth.register'), compact('page', 'custom_field'));
    }

    public function register(Request $request)
    {
        if (isModuleActive('LmsSaasMD')) {
            ini_set('max_execution_time', 10000);
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Force self-registered users to be active.
        $user->status = 1;
        $user->is_active = 1;
        $user->email_verify = 1;
        $user->email_verified_at = now();
        $user->save();

        event(new Registered($user));

        // Do NOT auto-login after registration.
        Auth::logout();

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect()->route('login')
                ->with('success', 'Registration successful. Please login.');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50', 'unique:users,phone'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'dob' => ['nullable', 'date'],
            'company' => ['nullable', 'string', 'max:255'],
            'identification_number' => ['nullable', 'string', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'in:male,female,prefer_not_to_say'],
            'student_type' => ['nullable', 'string', 'in:personal,corporate'],
            'institute' => ['nullable', 'string', 'max:255'],
        ];

        if (saasEnv('NOCAPTCHA_FOR_REG') == 'true' && !($data['type'] ?? '' == "Instructor")) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        if (isset($data['is_lms_signup'])) {
            $rules['institute_name'] = ['required', 'string', 'max:255'];
            $rules['domain'] = ['required', 'string', 'max:20', 'unique:lms_institutes'];
        }

        if (currentTheme() == 'tvt') {
            $rules['level'] = ['required'];
        }

        return Validator::make($data, $rules, validationMessage($rules));
    }

    protected function create(array $data)
    {
        if (isset($data['type']) && $data['type'] == "Instructor") {
            $role = 2;
        } else {
            $role = 3;
        }

        if (isset($data['is_lms_signup'])) {
            $role = 1;
        }

        if (isModuleActive('Organization') && isset($data['account_type']) && $data['account_type']) {
            $role = $data['account_type'];
        }

        if (isModuleActive('TwoFA')) {
            session()->put('email', $data['email']);
            session()->put('password', $data['password']);
        }

        return $this->userRepository->create([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'role_id' => $role,

            'dob' => $data['dob'] ?? null,
            'gender' => $data['gender'] ?? null,
            'student_type' => $data['student_type'] ?? null,
            'job_title' => $data['job_title'] ?? null,
            'identification_number' => $data['identification_number'] ?? null,
            'company' => $data['company'] ?? null,
            'institute' => $data['institute'] ?? null,
            'institute_id' => null,

            'password' => Hash::make($data['password']),

            'language_id' => Settings('language_id') ?? '19',
            'language_name' => Settings('language_name') ?? 'English',
            'language_code' => Settings('language_code') ?? 'en',
            'language_rtl' => Settings('language_rtl') ?? '0',
            'country' => Settings('country_id'),

            'username' => null,
            'is_lms_signup' => $data['is_lms_signup'] ?? null,
            'institute_name' => $data['institute_name'] ?? null,
            'domain' => str_replace(' ', '', $data['domain'] ?? null),
            'referral' => generateUniqueId(),
            'level' => $data['level'] ?? '',
            'special_commission' => null,
            'referral_code' => $data['referral_code'] ?? '',

            'status' => 1,
            'is_active' => 1,
            'email_verify' => 1,
            'email_verified_at' => now(),
        ]);
    }

    public function goToCheckout(): bool
    {
        if (session()->get('cart') != null && count(session()->get('cart')) > 0) {
            foreach (session()->get('cart') as $session_cart) {
                $checkHasCourse = Course::find($session_cart['course_id']);

                if ($checkHasCourse) {
                    $enrolledCourse = CourseEnrolled::where('user_id', Auth::user()->id)
                        ->where('course_id', $session_cart['course_id'])
                        ->first();

                    if (!$enrolledCourse) {
                        $hasInCart = Cart::where('course_id', $session_cart['course_id'])
                            ->where('user_id', Auth::user()->id)
                            ->first();

                        if (!$hasInCart) {
                            $price = $checkHasCourse->discount_price != null
                                ? $checkHasCourse->discount_price
                                : $checkHasCourse->price;

                            if (isset(session()->get('coupon')[$checkHasCourse->id])) {
                                $price = session()->get('coupon')[$checkHasCourse->id]['price'];
                            }

                            $cart = new Cart();
                            $cart->user_id = Auth::user()->id;
                            $cart->instructor_id = $session_cart['instructor_id'];
                            $cart->course_id = $session_cart['course_id'];
                            $cart->tracking = getTrx();
                            $cart->price = $price;
                            $cart->save();

                            if ($cart->price == 0) {
                                $paymentController = new PaymentController();
                                $paymentController->directEnroll($cart->course_id, $cart->tracking);
                            }
                        }
                    }
                }
            }
        }

        return Cart::where('user_id', auth()->id())->count() > 0;
    }
}