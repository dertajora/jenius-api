<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log; 
use App\Model\InvestmentProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class InvestmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * to use Crypt, you should set your APP_KEY configuration in .env . You could simply use 32 random string. 
     */



    public function list_provider(Request $request){
        Log::info('Request List Investment Provider');
        $providers = DB::table('investment_provider')->get();
        
        return response()->json(['result_code' => 1, 'result_message' => 'Data list investment provider sent!', 'data' => $providers]);
    }
  
    
}
