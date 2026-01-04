<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Services;
use App\Models\Products;

class DashboardController extends Controller
{
    function __construct(
        Services $services,
        Products $products
    ){
        $this->services = $services;
        $this->products = $products;
    }

    public function index()
    {
        $data['services'] = $this->services->with('order_service')->whereHas('order_service',function($query){
                                                $query->where('user_id',auth()->user()->generate);
                                            })
                                            ->orderBy('created_at','asc')
                                            ->get();

        $data['products'] = $this->products->where('status','Active')->latest()->get();

        return view('users.dashboard.index',$data);
    }
}
