<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $users = User::query()->orderBy('phone_verified_at','DESC');
        return $this->success((new UserCollection($users->paginate(10))));
    }
}
