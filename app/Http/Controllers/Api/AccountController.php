<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function me($id) {
        $user = User::find($id);
        return response()->json([
            'data' => $user
        ]);
    }
}
