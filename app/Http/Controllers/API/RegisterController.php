<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error: ' . $validator->errors()->first());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user;
        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] =  $user;
            return $this->sendResponse($success, 'User login successfully.');
        } else{
            return $this->sendError('Unauthorised.');
        }
    }

    /**
     * Current Device Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function currentDeviceLogout(Request $request)
    {
        // dd(Auth::user());
        $result = $request->user()->token()->delete();
        // Or we can use $result = $request->user()->token()->revoke();

        if($result)
        {
            return $this->sendResponse([], 'User logout successfully.');
        }
        else
        {
            return $this->sendError('Unauthorised.');
        }
    }

    /**
     * All Devices Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function allDevicesLogout(Request $request)
    {
        $result = $request->user()->tokens()->delete();
        if($result)
        {
            return $this->sendResponse([], 'User logout successfully.');
        }
        else
        {
            return $this->sendError('No active sessions found.');
        }
    }

    /**
     * All Devices Logout Except Current Device api
     *
     * @return \Illuminate\Http\Response
     */
    public function allDevicesExceptCurrentDeviceLogout(Request $request)
    {
        $user = $request->user();
        $result = $user->tokens()->where('id', '<>', $user->token()->id)->delete();
        if($result)
        {
            return $this->sendResponse([], 'User logout successfully.');
        }
        else
        {
            return $this->sendError('No other active sessions found.');
        }
    }
}
