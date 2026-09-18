<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserTableController extends Controller
{
    public function index()
    {
        return view('form.index', ['items' => User::query()->paginate(25)]);
    }
}
