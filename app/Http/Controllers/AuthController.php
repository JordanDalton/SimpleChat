<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller {

    public function loginOrRegister( Request $request  )
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        // Does the user exist in the database.
        $user = User::whereEmail($request->get('email'))->first();

        // If user exists we will try to log them in
        if( $user )
        {
            if( Auth::attempt($request->only('email', 'password')))
            {
                return ['logged_in' => csrf_token() ];
            }

            return response()->json(['login' => ['Invalid login credentials.']], 422);
        }

        // Create the user record.
        $user = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        // Log the user in.
        Auth::loginUsingId($user->id);

        return [ 'logged_in' => csrf_token() ];
    }

}
