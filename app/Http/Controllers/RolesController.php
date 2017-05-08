<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use Hash;
use App\User;
use App\Role;

class RolesController extends Controller
{
    public function index()
    {
      $role = Role::all();

      return Response::json($role);
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

    $role = new Role;
    $role->username = $request->input("username");
    $role->email = $request->input("email");
    $role->password = Hash::make($request->input("password"));
    $role->save();

    return Response::json(["success"=>"Role has been assigned!"]);

    }

    public function update($id, Request $request)

    {
      $role = Role::find($id);
      $role->username = $request->input('username')
      $role->password = Hash::make($request->input("password"));
      $role->save();

      return Response::json(["success" => "Role Updated."]);
    }

    public function show($id)

    {
      $role = Role::find($role->$id);

      return Response::json($role);
    }

    public function destroy($id)

    {
      $role = Role::find($id);

      $role->delete();

      return Response::json(['success' => 'Role Deleted!']);
    }
}
