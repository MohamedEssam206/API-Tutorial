<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    use GeneralTrait;



    public function login(Request $request)
    {
        try {
            //Validation
            $rules = [
                'email' => 'required|exists:admins,email',
                'password' => 'required'
                ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //Login

            $credentials = $request->only(['email','password']);

            $token = Auth::guard('admin-api')->attempt($credentials);
            if (!$token)
                return $this->returnError('E3001' , 'بيانات الدخول غير صحيحه');

            $admin = Auth::guard('admin-api')->user();
            // هنا بتقوله يا ادمن حطلي التوكين بتاعت الادمن في Api-Token افضل
            $admin-> Api_Token = $token;
            //return token
            return $this->returnData('admin' , $admin , 'تم استرجاع البيانات بنجاح ');

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex ->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // معني الكلام ده اني هيجيلي ريكويست من ال header اسمه auth-token الكلام ده موجود في postman
        $token =$request-> header('auth-token');
        // الامر ده بيعرفك لو في توكين اعملها invalidate بمعني اصح موتها يعني محدش يستحدمها تاني , ولو مفيش توكين رجعلي ماسدج
        if ($token){
            try {
                JWTAuth::setToken($token)->invalidate(); // Logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('E3001' , 'Some Thing Went Wrongs');
            }
            return $this->returnsuccessMessage('Logged Out Successfully');
        }else{
            $this->returnError('E3001' , 'Some Thing Went Wrongs');
        }
    }

}
