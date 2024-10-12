<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterLevelController extends Controller
{
    public function index()
    {
        return view('admin.master_level.index');
    }
}
