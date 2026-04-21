<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function store(Request $req) {
        return User::create($req->all());
    }

    public function destroy($id) {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
