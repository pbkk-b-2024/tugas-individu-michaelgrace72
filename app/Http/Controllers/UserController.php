<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use App\Models\User;

class UserController extends Controller
{
    //
    public function generateApiKey(Request $request){
        $user = $request->user();
        $user->api_key = Str::random(40);
        $user->save();
        return redirect()->route('documentation',['api_key' => $user->api_key])->with('success', 'API Key generated successfully.');
    }
}
