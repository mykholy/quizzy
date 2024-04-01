<?php

namespace App\Http\Controllers\API\Auth;


use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Controllers\AppBaseController;


use App\Http\Requests\API\LoginTeacherAPIRequest;
use App\Http\Requests\API\LoginTeacherAPIRequest;
use App\Http\Requests\API\RegisterTeacherAPIRequest;
use App\Http\Requests\API\SocailRegisterTeacherAPIRequest;
use App\Http\Requests\API\UpdateTeacherAPIRequest;
use App\Http\Resources\Admin\TeacherResource;
use App\Models\Admin\Coupon;
use App\Models\Admin\PasswordReset;
use App\Models\Admin\Teacher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AuthTeacherAPIController extends AppBaseController
{

    public function __construct()
    {

        $this->middleware('auth:api-teacher', ['except' => [  'login',  'forgetPassword', 'reset',  'VerifyCode']]);
    }


    public function login(LoginTeacherAPIRequest $request)
    {

        if ($request->type == "phone")
            $credentials = $request->only(['phone', 'password']);
        else
            $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api-teacher')->attempt($credentials)) {
            return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');
        }


        //check user is IsActive
        if (!auth('api-teacher')->user()->is_active) {
            return $this->sendError('حسابك محظور');
        }


        return $this->sendResponse($this->createNewToken($token), 'تسجيل الدخول بنجاح.');


    }


    public function logout()
    {
        auth('api-teacher')->logout();
        return $this->sendSuccess('تم تسجيل خروج المستخدم بنجاح');

    }

    public function deleteAccount()
    {

        $teacher= Teacher::find(auth('api-teacher')->id());
        $teacher->delete();
        return $this->sendSuccess('تم حذف المستخدم بنجاح');

    }

    public function profile()
    {
        $user = auth('api-teacher')->user();

        return $this->sendResponse(new TeacherResource($user), 'تم استرداد المستخدم بنجاح');

    }


    public function updateProfile(UpdateTeacherAPIRequest $request)
    {
        try {


            $user = auth('api-teacher')->user();
            $request_data = $request->except(['password', 'photo']);
            if ($request->has('photo') && $request->photo != null) {
                $request_data['photo'] = uploadImage('teachers', $request->photo);
            }
            if ($request->has('password') && $request->password != null) {
                $request_data['password'] = bcrypt($request->password);
            }
            $user->fill($request_data);
            $user->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse(new TeacherResource($user), 'تم تحديث البيانات بنجاح');

    }







    protected function createNewToken($token)
    {
        $user = Teacher::find(auth('api-teacher')->id());
        if (!$user)
            return $this->sendError('البريد الالكتروني او كلمة المرور غير صحيحة');


        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api-teacher')->factory()->getTTL() * 60,
            'user' => new TeacherResource($user)
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
        $user = Teacher::where('email', $request->email)
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
        ], 'تم ارسال الكود بنجاح');
    }





    public function reset(Request $request)
    {
        $request->validate([
//            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15e',
            'email' => 'required',
            'password' => 'required|string|confirmed',
            'code' => 'required|string'
        ]);
        $user = Teacher::where('email', $request->email)->orWhere('phone', $request->email)->first();
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
        $user = Teacher::where('email', $request->email)->orWhere('phone', $request->email)->first();
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



    public function notifications(Request $request)
    {
        // Retrieve the authenticated user
        $user = auth('api-teacher')->user();

        // Retrieve the unread notifications for the user
        $unreadNotifications = $user->unreadNotifications;

        // Mark the notifications as read (optional)
        $user->unreadNotifications->markAsRead();

        return $this->sendResponse($unreadNotifications, 'تم جلب الاشعارات بنجاح');
    }


}
