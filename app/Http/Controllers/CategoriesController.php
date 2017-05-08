<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Category;

class CategoriesController extends Controller
{
    public function index()
    {
      $category = Category::all();

      return Response::json($category);
    }

    public function store(Request $request)
    {
      $rules = [
        'name' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
        return Response::json(["error" => "You need to fill out all fields."]);
      }

      $category = new Category;
      $category->name = $request->input('category');
      $category->save();
    }

    public function update($id, Request $request)
    {
      $rules = [
        'name' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
        return Response::json(["error" => "You need to fill out all fields."]);
      }

      $category = Category::find($id);

      $category->name = $request->input('category');
      $category->save();

      return Response::json(['success' => 'Category Updated!']);
    }

    public function show($id)
    {
      $categories = Category::find($id);

      return Response::json($category);
    }

    public function delete($id)
    {
      $categories = Category::find($id)

      $categories->delete();

      return Response::json(['success' => "Category deleted!"]);
    }
}
