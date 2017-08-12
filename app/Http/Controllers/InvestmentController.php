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



    public function list_providers(Request $request){
        Log::info('Request List Investment Provider');
        $providers = DB::table('investment_provider')->get();
        
        return response()->json(['result_code' => 1, 'result_message' => 'Data list investment provider sent!', 'data' => $providers]);
    }
    public function list_products(Request $request){
        $data = json_decode($request->get('data'));
        Log::info('Request List Investment Products');
        $provider = DB::table('investment_provider')->where('id',$data->provider_id)->get();
        print_r($provider);
        
        $products = DB::table('investment_product')->where('provider_id',$data->provider_id)->get();

        if (count($products) == 0) {
            return response()->json(['result_code' => 2, 'result_message' => 'Investment product for this investment provider is not found', 'data' => '']);
        }
        $provider['products'] = $products;
        
        return response()->json(['result_code' => 1, 'result_message' => 'Data list investment products sent!', 'data' => $provider]);
    }
  
    
}
