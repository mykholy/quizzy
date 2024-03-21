<?php

namespace App\Http\Controllers\API\Auth;


use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Controllers\AppBaseController;


use App\Http\Requests\API\LoginStudentAPIRequest;
use App\Http\Requests\API\RegisterStudentAPIRequest;
use App\Http\Requests\API\SocailRegisterStudentAPIRequest;
use App\Http\Requests\API\UpdateStudentAPIRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Admin\Coupon;
use App\Models\Admin\PasswordReset;
use App\Models\Admin\Student;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AuthStudentAPIController extends AppBaseController
{

    public function __construct()
    {

        $this->middleware('auth:api-student', ['except' => ['check_teacher', 'socialLogin', 'login', 'check_user', 'register', 'forgetPassword', 'reset', 'sendVerifyPhone', 'VerifyPhoneCode', 'sendVerifyEmail', 'VerifyEmailCode', 'VerifyCode', 'settings']]);
    }


    public function login(LoginStudentAPIRequest $request)
    {

        if ($request->type == "phone")
            $credentials = $request->only(['phone', 'password']);
        else
            $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api-student')->attempt($credentials)) {
            return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');
        }


        //check user is IsActive
        if (!auth('api-student')->user()->is_active) {
            return $this->sendError('حسابك محظور');
        }


        return $this->sendResponse($this->createNewToken($token), 'تسجيل الدخول بنجاح.');


    }


    public function logout()
    {
        auth('api-student')->logout();
        return $this->sendSuccess('تم تسجيل خروج المستخدم بنجاح');

    }

    public function profile()
    {
        $user = auth('api-student')->user();

        return $this->sendResponse(new StudentResource($user), 'تم استرداد المستخدم بنجاح');

    }

    public function recharge_account(Request $request)
    {
        $user = auth('api-student')->user();

        $coupon = Coupon::where('code', $request->code)
            ->first();

        if (empty($coupon)) {
            return $this->sendError('الكوبون خطأ');
        }
        if (!$coupon->is_active)
            return $this->sendError('لقد تم استخدام هذا الكوبون من قبل');

        $user->balance += $coupon->value;
        $user->save();

        $coupon->is_active = 0;
        $coupon->save();

        return $this->sendResponse(new StudentResource($user->refresh()), "تم اضافة {$coupon->value} سؤال الي رصيدك");

    }

    public function updateProfile(UpdateStudentAPIRequest $request)
    {
        try {


            $user = auth('api-student')->user();
            $request_data = $request->except(['password', 'photo']);
            if ($request->has('photo') && $request->photo != null) {
                $request_data['photo'] = uploadImage('students', $request->photo);
            }
            if ($request->has('password') && $request->password != null) {
                $request_data['password'] = bcrypt($request->password);
            }
            $user->fill($request_data);
            $user->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse(new StudentResource($user), 'تم تحديث البيانات بنجاح');

    }

    public function settings()
    {
        $settings = Setting::all();
        if ($settings)
            $settings['logo'] = asset($settings['logo']);

        return $this->sendResponse($settings, 'Settings successfully retrieved');

    }

    public function check_user(Request $request)
    {

        if ($user = Student::where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->orWhere('provider_id', $request->email)
            ->first()) {
            return $this->sendResponse(new StudentResource($user), 'Student already exists.');

        }


        return $this->sendError('Student not exists.');


    }

    public function register(RegisterStudentAPIRequest $request)
    {

        $request_data = [
            'password' => bcrypt($request->password),
            'is_active' => true
        ];
        if ($request->has('photo') && $request->photo != null) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }


        $client = Student::create(array_merge(
            $request->validated(),
            $request_data
        ));


        //check user is IsActive
        if (!$client->is_active) {
            return $this->sendError(trans('lang.api.user_block'));
        }

        if (!$token = auth('api-student')->login($client)) {
            return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');
        }
        if ($client->email)
            $this->sendVerifyEmail($client);

        $client->balance = 50;
        $client->save();

        return $this->sendResponse($this->createNewToken($token), 'Account Created.');


    }

    public function socialLogin(SocailRegisterStudentAPIRequest $request)
    {

        $request_data = $request->all();
        $request_data['name'] = $request->get('name', $request->provider_id);
        $request_data['email'] = $request->get('email', $request->provider_id . "@gmail.com");
        $request_data['is_active'] = true;
        if ($request->has('photo') && $request->photo != null) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }


        if ($client = Student::where('provider_id', $request->provider_id)->first()) {
            if (!$client->is_active) {
                return $this->sendError(trans('lang.api.user_block'));
            }

            if (!$token = auth('api-student')->login($client)) {
                return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');
            }

            return $this->sendResponse($this->createNewToken($token), 'تم تسجيل الدخول بنجاح.');
        }


        $client = Student::create($request_data);


        //check user is IsActive
        if (!$client->is_active) {
            return $this->sendError(trans('lang.api.user_block'));
        }

        if (!$token = auth('api-student')->login($client)) {
            return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');
        }

        return $this->sendResponse($this->createNewToken($token), 'تم انشاء الحساب بنجاح.');


    }


    protected function createNewToken($token)
    {
        $user = Student::find(auth('api-student')->id());
        if (!$user)
            return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');


        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api-student')->factory()->getTTL() * 60,
            'user' => new StudentResource($user)
        ];
        return $data;


    }

    public function forgetPassword(Request $request)
    {

        $request->validate([
//            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15e',
            'email' => 'required',
        ]);
        $type = "phone";
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $type = "email";
        }
        $user = Student::where('email', $request->email)
            ->orWhere('phone', $request->email)->first();

        if (!$user)
            return $this->sendError('الطالب غير موجود', 200);


        $passwordReset = PasswordReset::updateOrCreate(
            [
                'email' => $request->email,
                'token' => mt_rand(100000, 999999)
            ]
        );
        if ($type == "email")
            send_mail(['name' => $user->name, 'code' => $passwordReset->token, 'subject' => 'Forget Password'], $user->email, "reset");
        else
            sendSMS($user->phone, 'This is code:  ' . $passwordReset->token);

        return $this->sendResponse([
            'email' => $passwordReset->email,
//            'code' => $passwordReset->token,
        ], 'Done');
    }

    public function sendVerifyEmail($user = null)
    {
        if (!$user) {
            $request = request();
            $request->validate([
//            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15e',
                'email' => 'required',
            ]);
            $user = Student::where('email', $request->email)->first();

            if (!$user)
                return $this->sendError('الطالب غير موجود', 200);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            [
                'email' => $user->email,
                'token' => mt_rand(100000, 999999)
            ]
        );
        send_mail(['name' => $user->name, 'code' => $passwordReset->token, 'subject' => 'Verify Email'], $user->email);
        return $this->sendResponse([
            'email' => $passwordReset->email,
//            'code' => $passwordReset->token,
        ], 'Done');
    }

    public function VerifyEmailCode(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required|string'
        ]);
        $user = Student::where('email', $request->email)->first();
        if (!$user)
            return $this->sendError('لا يمكننا العثور على مستخدم لديه هذا البريد الإلكتروني.', 200);

        $passwordReset = PasswordReset::where([
            ['token', $request->code],
            ['email', $user->email]
        ])->first();

        if (!$passwordReset)
            return $this->sendError('هذا الرمز غير صالح.', 200);

        if (Carbon::parse($passwordReset->created_at)->addMinutes(env('EXPIRE_PASSWORD', 30))->isPast()) {
            return $this->sendError('انتهت صلاحية هذا الرمز.', 200);
        }


        $user->markEmailAsVerified();


        return $this->sendResponse(null, 'Email Verified Successfully');
    }

    public function sendVerifyPhone($user = null)
    {
        if (!$user) {
            $request = request();
            $request->validate([
                'phone' => 'required|string',
//                'email' => 'required',
            ]);
            $user = Student::where('phone', $request->phone)->first();

            if (!$user)
                return $this->sendError('الطالب غير موجود', 200);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            [
                'email' => $user->phone,
                'token' => mt_rand(100000, 999999)
            ]
        );
        sendSMS($user->phone, 'This is code:  ' . $passwordReset->token);
        return $this->sendResponse([
            'phone' => $passwordReset->email,
//            'code' => $passwordReset->token,
        ], 'Done');
    }

    public function VerifyPhoneCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required|string'
        ]);
        $user = Student::where('phone', $request->phone)->first();
        if (!$user)
            return $this->sendError('لا يمكننا العثور على مستخدم لديه هذا البريد الإلكتروني.', 200);

        $passwordReset = PasswordReset::where([
            ['token', $request->code],
            ['email', $user->phone]
        ])->first();

        if (!$passwordReset)
            return $this->sendError('كود التحقق غير صحيح.', 200);

        if (Carbon::parse($passwordReset->created_at)->addMinutes(env('EXPIRE_PASSWORD', 30))->isPast()) {
            return $this->sendError('تم انتهاء صلاحية الكود.', 200);
        }


        $user->phone_verified = 1;
        $user->save();


        return $this->sendResponse(null, 'تم التحقق من الهاتف بنجاح');
    }


    public function reset(Request $request)
    {
        $request->validate([
//            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15e',
            'email' => 'required',
            'password' => 'required|string|confirmed',
            'code' => 'required|string'
        ]);
        $user = Student::where('email', $request->email)->orWhere('phone', $request->email)->first();
        if (!$user)
            return $this->sendError('لا يمكننا العثور على مستخدم لديه هذا البريد الإلكتروني.', 200);

        $passwordReset = PasswordReset::where([
            ['token', $request->code],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)
            return $this->sendError('رمز إعادة تعيين كلمة المرور هذا غير صالح.', 200);

        if (Carbon::parse($passwordReset->created_at)->addMinutes(env('EXPIRE_PASSWORD', 30))->isPast()) {
            return $this->sendError('انتهت صلاحية رمز إعادة تعيين كلمة المرور هذا.', 200);
        }


        $user->password = bcrypt($request->password);
        $user->save();


        return $this->sendResponse(null, 'تم إعادة تعيين كلمة المرور بنجاح');
    }


    public function VerifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required|string'
        ]);
        $user = Student::where('email', $request->email)->orWhere('phone', $request->email)->first();
        if (!$user)
            return $this->sendError('لا يمكننا العثور على مستخدم لديه هذا البريد الإلكتروني.', 200);

        $passwordReset = PasswordReset::where([
            ['token', $request->code],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)
            return $this->sendError('هذا الرمز غير صالح.', 200);

        if (Carbon::parse($passwordReset->created_at)->addMinutes(env('EXPIRE_PASSWORD', 30))->isPast()) {
            return $this->sendError('انتهت صلاحية هذا الرمز.', 200);
        }


        return $this->sendSuccess('Done');
    }

    public function check_teacher(Request $request)
    {

        $res = init_user("teacher");

        return $res ? $this->sendSuccess('Done') : $this->sendError('Erro', 404);
    }

    public function notifications(Request $request)
    {
        // Retrieve the authenticated user
        $user = auth('api-student')->user();

        // Retrieve the unread notifications for the user
        $unreadNotifications = $user->unreadNotifications;

        // Mark the notifications as read (optional)
        $user->unreadNotifications->markAsRead();

        return $this->sendResponse($unreadNotifications,'Done');
    }


}
