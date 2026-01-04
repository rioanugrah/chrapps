<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Servers;

use Validator;

class ProductController extends Controller
{
    function __construct(
        Products $products,
        Servers $servers
    ){
        $this->middleware('permission:product-list', ['only' => ['index']]);
        // $this->middleware('permission:product-create', ['only' => ['index']]);
        $this->middleware('permission:product-store', ['only' => ['simpan']]);
        $this->middleware('permission:product-view', ['only' => ['detail']]);
        // $this->middleware('permission:product-edit', ['only' => ['index']]);
        $this->middleware('permission:product-update', ['only' => ['update']]);
        // $this->middleware('permission:product-delete', ['only' => ['index']]);
        $this->products = $products;
        $this->servers = $servers;
    }

    public function index()
    {
        $data['products'] = $this->products->with('server')->orderBy('created_at','desc')->get();
        $data['servers'] = $this->servers->where('status','Active')->orderBy('created_at','desc')->get();

        return view('backend.products.index',$data);
    }

    public function simpan(Request $request)
    {
        $rules = [
            'product_name'  => 'required',
            'product_price'  => 'required',
            'product_duration'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            'product_name.required'   => 'Product Name wajib diisi.',
            'product_price.required'   => 'Product Price wajib diisi.',
            'product_duration.required'   => 'Product Duration wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();
            $input['id'] = Str::uuid()->toString();

            $simpanProduct = $this->products->create($input);

            if ($simpanProduct) {
                $message_title="Berhasil !";
                $message_content= "Product ".$request->product_name." Berhasil Dibuat";
                $message_type="success";
                $message_succes = true;
            }

            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );

            return response()->json($array_message);

        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function detail($id)
    {
        $product = $this->products->find($id);

        if (empty($product)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Produk Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'product_name'  => 'required',
            'product_price'  => 'required',
            'product_duration'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            'product_name.required'   => 'Product Name wajib diisi.',
            'product_price.required'   => 'Product Price wajib diisi.',
            'product_duration.required'   => 'Product Duration wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();

            $simpanProduct = $this->products->find($request->id)->update($input);

            if ($simpanProduct) {
                $message_title="Berhasil !";
                $message_content= "Product ".$request->product_name." Berhasil Diupdate";
                $message_type="success";
                $message_succes = true;
            }

            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );

            return response()->json($array_message);

        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

}
