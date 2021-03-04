<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friends;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Invite;
use App\Notifications\InviteNotification;
use Str;
use URL;


class FriendsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('registration_view');
    }


    public function invite_view()
    {
        return view('invite');
    }

    public function getRegister()
    {
       return view('Auth.friends_register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Friends::select("name")
                ->where("name","LIKE","%{$request->query}%")
                ->get();

        return response()->json($data);
    }


// invitation method
    public function process_invites(Request $request)
{
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:users,email'
      ]);


      $validator->after(function ($validator) use ($request) {
        if (Invite::where('email', $request->input('email'))->exists()) {
            $validator->errors()->add('email', 'There exists an invite with this email!');
        }
      });


      if ($validator->fails()) {
        return redirect(route('invite_view'))
            ->withErrors($validator)
            ->withInput();
     }

      do {
        $token = Str::random(20);
         } while (Invite::where('token', $token)->first());


      Invite::create([
        'token' => $token,
        'email' => $request->input('email')
      ]);


      $url = URL::temporarySignedRoute(

         'registers', now()->addMinutes(300), ['token' => $token]
     );

      Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));


      return redirect('/home')->with('success', 'The Invite has been sent successfully');
 }


    public function registration_view($token)
    {
        $invite = Invite::where('token', $token)->first();
        return view('auth.friends_register',['invite' => $invite]);
    }
}
