<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Product;

class ProductsController extends Controller
{
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

    $product = new Category;
    $product->name = $request->input('name');
    $product->categoryID = $request->input('categoryId');
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

    $product->name = $request->input('name');
    $product->categoryID = $request->input('categoryId');
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

  public function delete($id)
    {
      $product = Product::find($id);

      $product->delete();

      return Respone::json(['success' => 'Product deleted.']);
    }
}
