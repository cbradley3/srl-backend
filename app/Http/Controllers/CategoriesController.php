<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Category;
use Auth;
use JWTAuth;

class CategoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware("jwt.auth", ["only" => ["store", "update", "show", "destroy"]]);
  }

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

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      $category = new Category;
      $category->name = $request->input('name');
      $category->save();

      return Response::json(['success' => 'Category Created!']);
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

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      $category = Category::find($id);

      $category->name = $request->input('name');
      $category->save();

      return Response::json(['success' => 'Category Updated!']);
    }

    public function show($id)
    {
      $category = Category::find($id);

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      return Response::json($category);
    }

    public function destroy($id)
    {
      $category = Category::find($id);

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      $category->delete();

      return Response::json(['success' => "Category Deleted!"]);
    }
}
