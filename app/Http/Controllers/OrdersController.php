<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Order;
use App\Product;
use Auth;

class OrdersController extends Controller
{
  public function index()
  {
    $order = Order::all();

    return Response::json($order);
  }

  public function store(Request $request)
  {
    $rules = [
      'productID' => 'required',
      'quantity' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(["error" => "You need to fill out all fields."]);
    }

    $product = Product::find($request->input('productID'));
    if(empty($product))

    {
      return Response::json(["error" => "Product not found."]);
    }

    if($product->availability==0)

    {
      return Response::json(["error" => "Product is unavailable."]);
    }

    $order = new Category;
    $order->userID = Auth::user()->id;
    $order->productID = $request->input('productID');
    $order->quantity = $request->input('quantity');
    $order->totalPrice = $request->input('totalPrice');
    $order->comment = $request->input('comment');
    $order->save();

    return Response::json(["success" => "Success! You did it!"]);
  }

    public function update($id, Request $request)
    {
      $rules = [
        'productID' => 'required',
        'quantity' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
        return Response::json(["error" => "You need to fill out all fields."]);
      }

      $order->userID = Auth::user()->id;
      $order->productID = $request->input('productID');
      $order->quantity = $request->input('quantity');
      $order->totalPrice = $request->input('amount')*$product->price;
      $order->comment = $request->input('comment');
      $order->save();

      return Response::json(["success" => "Order Updated!"]);
    }

    public function show($id)
      {
        $order = Order::find($id);

        return Response::json($order);
      }

    public function destroy($id)
      {
        $order = Order::find($id);

        $order->delete();

        return Respone::json(['success' => 'Order deleted!']);
      }
}
