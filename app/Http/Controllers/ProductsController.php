<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Product;
use Auth;
use JWTAuth;

class ProductsController extends Controller
{
  public function __construct()
  {
    $this->middleware("jwt.auth", ["only" => ["index", "store", "update", "show", "destroy"]]);
  }
    public function index()
    {
      $product = Product::all();

      return Response::json($product);
    }

    public function store(Request $request)
    {
      $rules = [
      'name' => 'required',
      'categoryID' => 'required',
      'availability' => 'required',
      'price' => 'required',
      'description' => 'required',
      'image' => 'required',
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

    $category = Category::find($request->input("categoryID"));
    if(empty($category))

    {
      return Response::json(["error" => "Category not found!"]);
    }

    $product = new Product;
    $product->name = $request->input('name');
    $product->categoryID = $request->input('categoryID');
    $product->availability = $request->input('availability');
    $product->price = $request->input('price');
    $product->description = $request->input('description');

    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $product->image = $request->root(). "/storage/".$imageName;

    $product->save();

    return Response::json(["success" => "Success! You did it!"]);
    }

    public function update($id, Request $request)
    {
      $rules = [
      'name' => 'required',
      'categoryID' => 'required',
      'availability' => 'required',
      'price' => 'required',
      'description' => 'required',
      'image' => 'required',
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

    $product = Product::find($id);

    $product->name = $request->input('name');
    $product->categoryID = $request->input('categoryID');
    $product->availability = $request->input('availability');
    $product->price = $request->input('price');
    $product->description = $request->input('description');

    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $product->image = $request->root(). "/storage/".$imageName;

    $product->save();

    return Response::json(["success" => "Product Updated!"]);
    }

    public function show($id)
    {
      $product = Product::find($id);

      return Response::json($product);
    }

  public function destroy($id)
    {
      $product = Product::find($id);

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      $product->delete();

      return Response::json(["success" => "Product deleted."]);
    }
}
