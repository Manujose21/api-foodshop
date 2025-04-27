<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    //

    public function index()
    {
        // get all products available
        return new ProductCollection(Product::where('available', true)->get());
    }

}
