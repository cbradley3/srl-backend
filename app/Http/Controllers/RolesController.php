<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Role;
use Auth;
use JWTAuth;

class RolesController extends Controller
{
  public function __construct()
  {
    $this->middleware("jwt.auth", ["only" => ["index", "store", "update", "show", "destroy"]]);
  }
  
    public function index()
    {
      $role = Role::all();

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      return Response::json($role);
    }

    public function store(Request $request)
    {
      $rules=[
      'name' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(["error" => "You need to fill out all fields."]);
    }

    $role = new Role;
    $role->name = $request->input("name");
    $role->save();

    return Response::json(["success"=>"Role has been assigned!"]);

    }

    public function update($id, Request $request)

    {
      $rules=[
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

      $role = Role::find($id);
      $role->name = $request->input('name');
      $role->save();

      return Response::json(["success" => "Role Updated."]);
    }

    public function show($id)

    {
      $role = Role::find($role->$id);

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      return Response::json($role);
    }

    public function destroy($id)

    {
      $role = Role::find($id);

      $user = Auth::user();
      if($user->roleID != 1)

      {
        return Response::json(["error" => "Not Allowed"]);
      }

      $role->delete();

      return Response::json(['success' => 'Role Deleted!']);
    }
}
