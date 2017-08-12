<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log; 
use App\Model\InvestmentProvider;
use App\Model\InvestmentProduct;
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
        foreach ($providers as $row) {
            $row->status = $this->check_status($row->id);
        }
        return response()->json(['result_code' => 1, 'result_message' => 'Data list investment provider sent!', 'data' => $providers]);
    }

    public function check_status($provider_id){
        $product_open = InvestmentProduct::where('status',1)->where('provider_id',$provider_id)->count();

        if ($product_open > 0 ) {
            return "Currently Open";
        }

        $product_coming_soon = InvestmentProduct::where('status',0)->where('provider_id',$provider_id)->orderBy('open_at','asc')->select('open_at')->first();
        
        if (count($product_coming_soon) != 0) {
            return "Open on ".date('d F Y', strtotime($product_coming_soon['open_at']));
        }else{
            return "Closed";    
        }

    }

    public function list_products(Request $request){
        $data = json_decode($request->get('data'));
        Log::info('Request List Investment Products');

        $provider = DB::table('investment_provider')->where('id',$data->provider_id)->get();
        $products = DB::table('investment_product')->where('provider_id',$data->provider_id)->get();

        if (count($products) == 0) {
            return response()->json(['result_code' => 2, 'result_message' => 'Investment product for this investment provider is not found', 'data' => '']);
        }

        Log::info('Get List Images for Products');
        foreach ($products as $row) {
            $row->product_images = DB::table('product_images')->where('product_id',$row->id)->select('id','image_url')->get();
            if ($row->status == 0) {
                $row->status = "Open on ".date('d F Y', strtotime($row->open_at));
            }elseif ($row->status == 1) {
                $row->status = "Currently Open";
            }elseif ($row->status) {
                $row->status = "Closed";
            }
        }
        
        $provider['products'] = $products;
        
        return response()->json(['result_code' => 1, 'result_message' => 'Data list investment products sent!', 'data' => $provider]);
    }
  
    
}
