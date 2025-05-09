<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    //

    public function index(Request $request)
    {

        $request->validate([
            'per_page' => 'integer|nullable',
            'page' => 'integer|nullable',
        ]);

        $per_page = $request->query('per_page');
        $page = $request->query('page');

        if(  $per_page || $page) {
            return new ProductCollection(Product::where('available', true)->paginate($per_page ?? 10)); 
        }

        // get all products available
        return new ProductCollection(Product::where('available', true)->get());
    }


}
