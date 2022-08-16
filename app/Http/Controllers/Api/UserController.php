<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GlobalTraits;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GlobalTraits;

    public function getAllUser(){
        $users = User::all();

        return $this->SendResponse($users , "success all tha users" , 200);
    }
}
