<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user()
    {
        return response([
            'user' =>auth()->user(),
        ], 200);
    }

    public function update(Request $request){
        $attrs = $request->validate([
            'name' =>'required|string',

        ]);
        $image = $this->saveImage($request->image, 'profiles');

        auth()->user()->update([
            'name' => $attrs['name'],
            'image' => $image,
        ]);

        return response([
            'message' => 'User Updated',
            'user' =>auth()->user(),
        ], 200);
    }
}
