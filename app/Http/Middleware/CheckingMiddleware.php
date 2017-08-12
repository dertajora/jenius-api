<?php



namespace App\Http\Middleware;



use Closure;

use App\Model\User;

use Illuminate\Support\Facades\DB;



class CheckingMiddleware

{   

    // before middleware

    public function handle($request, Closure $next)

    {
        // get user info
        $this->user_info = json_decode($request->get('user_info'));
        // check parameter user info
        if(!isset($this->user_info)){
            return response()->json(['result_code' => 3, 'result_message' => 'Invalid Parameter!', 'data' => '']);
        }else{
            $this->expired = $this->check_token_expired($this->user_info->id, $this->user_info->token);
            $this->login_expired = $this->check_login_expired($this->user_info->id, $this->user_info->token);
        }

        // token expired or login expired
        if($this->expired){
            return response()->json(['result_code' => 3, 'result_message' => 'Token expired or user not found!', 'data' => '']);
        }elseif ($this->login_expired) {
            return response()->json(['result_code' => 3, 'result_message' => 'Login expired!', 'data' => '']);
        }

    	return $next($request);
    }



    // terminate middleware

    public function terminate($request, $response)
    {	

    }

    public function check_token_expired($id, $token){
        $user_found = User::where('token', $token)->where('id',$id)->count();
        if ($user_found == 0) {
            return true;
        }else{
            return false;
        }
    }



    public function check_login_expired($id, $token){
        $products = DB::select('select id,name, DATEDIFF(NOW(), last_login_mobileapp) as expired  from users where token = "'.$token.'" and id = "'.$id.'"');
        if(count($products) > 0) {
            if ($products[0]->expired > 3) {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

}







