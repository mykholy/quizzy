<?php

namespace App\Http\Controllers\API\Auth;


use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Controllers\AppBaseController;


use App\Http\Requests\API\LoginClientAPIRequest;
use App\Http\Requests\API\RegisterClientAPIRequest;
use App\Http\Requests\API\SocailRegisterClientAPIRequest;
use App\Http\Resources\Admin\ClientResource;
use App\Models\Admin\Client;

use Illuminate\Http\Request;


class AuthClientAPIController extends AppBaseController
{

    public function __construct()
    {

        $this->middleware('auth:api-client', ['except' => ['socialLogin', 'login', 'check_user', 'register', 'settings']]);
    }


    public function login(LoginClientAPIRequest $request)
    {


        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api-client')->attempt($credentials)) {
            return $this->sendError('Unauthorized');
        }


        //check user is IsActive
        if (!auth('api-client')->user()->is_active) {
            return $this->sendError('Client has been blocked.');
        }


        return $this->sendResponse($this->createNewToken($token), 'Login successfully.');


    }


    public function logout()
    {
        auth('api-client')->logout();
        return $this->sendSuccess('User successfully signed out');

    }

    public function profile()
    {
        $user = auth('api-client')->user();

        return $this->sendResponse(new ClientResource($user), 'User successfully retrieved');

    }

    public function updateProfile(Request $request)
    {
        $user = auth('api-client')->user();
        $request_data = $request->all();
        if ($request->has('photo') && $request->photo != null) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }
        if ($request->has('password') && $request->password != null) {
            $request_data['password'] = bcrypt($request->password);
        }
        $user->fill($request_data);
        $user->save();


        return $this->sendResponse(new ClientResource($user), 'User successfully retrieved');

    }

    public function settings()
    {
        $settings = Setting::all();
        $settings['logo'] = asset($settings['logo']);

        return $this->sendResponse($settings, 'Settings successfully retrieved');

    }

    public function check_user(Request $request)
    {

        if ($user = Client::where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->orWhere('provider_id', $request->email)
            ->first()) {
            return $this->sendResponse(new ClientResource($user), 'Client already exists.');

        }


        return $this->sendError('Client not exists.');


    }

    public function register(RegisterClientAPIRequest $request)
    {

        $request_data = [
            'password' => bcrypt($request->password),
            'is_active' => true
        ];
        if ($request->has('photo') && $request->photo != null) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }


        $client = Client::create(array_merge(
            $request->validated(),
            $request_data
        ));


        //check user is IsActive
        if (!$client->is_active) {
            return $this->sendError(trans('lang.api.user_block'));
        }

        if (!$token = auth('api-client')->login($client)) {
            return $this->sendError('Unauthorized');
        }

        return $this->sendResponse($this->createNewToken($token), 'Account Created.');


    }

    public function socialLogin(SocailRegisterClientAPIRequest $request)
    {

        $request_data = $request->all();
        $request_data['name'] = $request->get('name', $request->provider_id);
        $request_data['email'] = $request->get('email', $request->provider_id . "@gmail.com");
        $request_data['is_active'] = true;
        if ($request->has('photo') && $request->photo != null) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }


        if ($client = Client::where('provider_id', $request->provider_id)->first()) {
            if (!$client->is_active) {
                return $this->sendError(trans('lang.api.user_block'));
            }

            if (!$token = auth('api-client')->login($client)) {
                return $this->sendError('Unauthorized');
            }

            return $this->sendResponse($this->createNewToken($token), 'Login successfully.');
        }


        $client = Client::create($request_data);


        //check user is IsActive
        if (!$client->is_active) {
            return $this->sendError(trans('lang.api.user_block'));
        }

        if (!$token = auth('api-client')->login($client)) {
            return $this->sendError('Unauthorized');
        }

        return $this->sendResponse($this->createNewToken($token), 'Account Created.');


    }


    protected function createNewToken($token)
    {
        $user = Client::find(auth('api-client')->id());
        if (!$user)
            return $this->sendError('Unauthorized');


        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api-client')->factory()->getTTL() * 60,
            'user' => new ClientResource($user)
        ];
        return $data;


    }


}
