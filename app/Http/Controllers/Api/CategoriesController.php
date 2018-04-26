<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryCollection;

class CategoriesController extends ApiController
{
	public function index()
	{
		return $this->success(new CategoryCollection(Category::all()));
		// return new CategoryCollection(Category::all());
	}
}
