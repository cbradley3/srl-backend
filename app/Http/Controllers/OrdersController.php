<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Order;
use App\Product;
use Auth;
use JWTAuth;

class OrdersController extends Controller
{
  public function __construct()
  {
    $this->middleware("jwt.auth", ["only" => ["index", "store", "update", "show", "destroy"]]);
  }

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

    $order = new Order;
    $order->userID = Auth::user()->id;
    $order->productID = $request->input('productID');
    $order->quantity = $request->input('quantity');
    $order->totalPrice = $request->input('quantity')*$product->price;
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

      $order = Auth::user();
      if($user->roleID != 1 || $user->id != $order->userID)
      {
        return Response::json(["error" => "Not authorized to change order!"])
      }

      $order->userID = Auth::user()->id;
      $order->productID = $request->input('productID');
      $order->quantity = $request->input('quantity');
      $order->totalPrice = $request->input('quantity')*$product->price;
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

        $order = Auth::user();
        if($user->roleID != 1 || $user->id != $order->userID)
        {
          return Response::json(["error" => "Not Authorized to Delete!"])
        }

        $order->delete();

        return Response::json(['success' => 'Order deleted!']);
      }
}
