<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Order;

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
      'name' => 'required',
      'productId' => 'required',
      'quantity' => 'required',
      'totalPrice' => 'required',
      'comment' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(["error" => "You need to fill out all fields."]);
    }

    $order = new Category;
    $order->name = $request->input('name');
    $order->productId = $request->input('productId');
    $order->quantity = $request->input('quantity');
    $order->totalPrice = $request->input('totalPrice');
    $order->comment = $request->input('comment');
    $order->save();

    return Response::json(["success" => "Success! You did it!"]);
  }

    public function update($id, Request $request)
    {
      $rules = [
        'name' => 'required',
        'productId' => 'required',
        'quantity' => 'required',
        'totalPrice' => 'required',
        'comment' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
        return Response::json(["error" => "You need to fill out all fields."]);
      }

      $order->name = $request->input('name');
      $order->productId = $request->input('productId');
      $order->quantity = $request->input('quantity');
      $order->totalPrice = $request->input('totalPrice');
      $order->comment = $request->input('comment');
      $order->save();

      return Response::json(["success" => "Order Updated!"]);
    }

    public function show($id)
      {
        $order = Order::find($id);

        return Response::json($order);
      }

    public function delete($id)
      {
        $order = Order::find($id);

        $order->delete();

        return Respone::json(['success' => 'Order deleted!']);
      }
}
