<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class FriendsController extends Controller
{

    public function index(){

     dd(User::find(1)->friendsmodel());
    }
}
