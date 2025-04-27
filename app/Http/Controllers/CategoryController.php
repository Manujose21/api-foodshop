<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //

    public function index(){

        
        return new CategoryCollection(Category::all());
    }

}
