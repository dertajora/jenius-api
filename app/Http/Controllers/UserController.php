<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log; 
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * to use Crypt, you should set your APP_KEY configuration in .env . You could simply use 32 random string. 
     */



    public function login(Request $request){
        $data = json_decode($request->get('data'));
        Log::info('Request Login');
        if (isset($data->username)) {
            $keyword = $data->username;
        }elseif (isset($data->email)) {
            $keyword = $data->email;
        }

        $user_found = User::where('email', $keyword)->orwhere('username',$keyword)->count();

        if ($user_found == 0) {
            return response()->json(['result_code' => 2, 'result_message' => 'Username tidak ditemukan!', 'data' => '']);
        }else{
            $user = User::where('email', $keyword)->orwhere('username',$keyword)
                        ->select(DB::raw('id,email, name, token, password'))->first();
            
            $password_user = Crypt::decrypt($user['password']);
            
            if($password_user == $data->password){
                $data_user['token'] = $this->getToken(64);
                // update user token
                $user = User::find($user['id']);
                $user->token = $data_user['token'];
                $user->last_login_mobileapp = date('Y-m-d H:i:s');
                $user->save();  
                
                // return user detail
                $user = User::where('email', $keyword)->orwhere('username',$keyword)
                        ->select(DB::raw('id,email, name, token, username, phone,balance'))->first();
                return response()->json(['result_code' => 1, 'result_message' => 'Authentification success!', 'data' => $user]);
            }else{
                return response()->json(['result_code' => 2, 'result_message' => 'Wrong Password!', 'data' => '']);
            }
            
        }

       
    }

    public function user_info(Request $request){
        $user_info = json_decode($request->get('user_info'));
        // find detail user info
        $detail_user = User::where('id',$user_info->id)->select('id','name','email', 'phone', 'username', 'last_login_mobileapp')->first();
        return response()->json(['result_code' => 1, 'result_message' => 'Data user dikirimkan', 'data' => $detail_user]);
    }

    function getToken($length){
         $token = "";
         $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
         $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
         $codeAlphabet.= "0123456789";
         $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
    }

  
    
}
