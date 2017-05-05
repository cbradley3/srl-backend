<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      'name' => 'required',
      'email' => 'required',
      'password' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(["error" => "You need to fill out all fields."]);
    }

    }
}
