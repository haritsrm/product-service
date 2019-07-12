<?php

use App\User;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

$router->get('/', function () {
    $products = Product::all();
    return $products;
});

$router->get('/{id}', function ($id) {
    $product = Product::find($id);
    if ($product) {
        return [
            'data' => $product
        ];
    }
    return [
        'status' => false,
        'message' => 'Product tidak ditemukan'
    ];
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/my_products', function () {
        $products = Auth::user()->products;
        return [
            'data' => $products
        ];
    });

    $router->post('/', function (Request $req) {
        $product = new Product;
        $product->category_uuid = Category::find($req->category_uuid) ? $req->category_uuid : 0;
        $product->name = $req->name;
        $product->description = $req->description;
        $product->price = $req->price;
        $product->time_limit = $req->time_limit;
        $product->time_start = $req->time_start;
        $product->user_uuid = $req->user()->uuid;
        if ($product->save()) {
            return [
                'status' => true,
                'message' => "berhasil menambahkan $product->name"
            ];
        }
        else {
            return [
                'status' => false,
                'message' => "data wajib diisi"
            ];
        }
    });

    $router->put('/{id}', function ($id, Request $req) {
        $product = Product::find($id);
        if ($product) {
            $product->category_uuid = Category::find($req->category_uuid) ? $req->category_uuid : 0;
            $product->name = $req->name;
            $product->description = $req->description;
            $product->price = $req->price;
            $product->time_limit = $req->time_limit;
            $product->time_start = $req->time_start;
            $product->user_uuid = $req->user()->uuid;
            if ($product->save()) {
                return [
                    'status' => true,
                    'message' => "berhasil mengubah detail $product->name"
                ];
            }
            else {
                return [
                    'status' => false,
                    'message' => "gagal mengubah detail $product->name"
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Product tidak ditemukan'
        ];
    });

    $router->delete('/{id}', function ($id) {
        $product = Product::find($id);
        if ($product) {
            if ($product->delete()) {
                return [
                    'status' => true,
                    'message' => "berhasil manghapus $product->name"
                ];
            }
            else {
                return [
                    'status' => false,
                    'message' => "gagal menghapus $product->name"
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Product tidak ditemukan'
        ];
    });
});