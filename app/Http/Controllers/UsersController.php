<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use Hash;
use App\User;


class UsersController extends Controller
{
  public function index()
  {
    $user = User::all();

    return Response::json($user);
  }

  public function store(Request $request)
  {
    $rules=[
      'username' => 'required',
      'email' => 'required',
      'password' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(["error" => "You need to fill out all fields."]);
    }

    $check = User::where("email","=",$request->input("email"))->orWhere("name","=",$request->input("username"))->first();

    if(!empty($check))
    {
      return Response::json(["error"=>"User already exists"]);
    }
    $user = new User;
    $user->username = $request->input("username");
    $user->email = $request->input("email");
    $user->password = Hash::make($request->input("password"));
    $user->roleID = 2;
    $user->save();

    return Response::json(["success"=>"Thanks for signing up!"]);
  }

    public function update($id, Request $request)
    {
      $rules=[
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
        return Response::json(["error" => "You need to fill out all fields."]);
      }

      $check = User::where("email","=",$request->input("email"))->orWhere("name","=",$request->input("username"))->first();

      if(!empty($check))
      {
        return Response::json(["error"=>"User already exists"]);
      }

      else {
        $user->name = $request->input("username");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("password"));
        $user->save();

        return Response::json(["success"=>"Update Complete!"]);
      }
    }

    public function show($id)
    {
      $user = User::find($user->$id);

      return Response::json($user);
    }

    public function destroy($id)

    {
      $user = User::find($id);

      $user->delete();

      return Response::json(['success' => 'User Deleted!']);
    }
}
