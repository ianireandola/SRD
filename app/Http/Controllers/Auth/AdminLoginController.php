<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    protected $redirectTo = '/home';
    
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    public function showLogInForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //1) Validate the form data
         $this->validate($request, [
             'chapa' => 'required|string',
             'password' => 'required|min:3'
         ]);

        /** 
         * 2) Attempt to log the admin in
         *  - Successful -> Redirect to their intended location
         *  - Unsuccessful -> Redirect back to the login with the form data
         * 
         * 
         * It verifies the element of the array credentials(email,password) and assures than they match with some of the database
         * The second parameter just continues with the session in the next time (True) or asks again for the credentials
         * The attempt method returns true (if it is successful) or false (if it is unsuccessful)
         */
        if(Auth::guard('admin')->attempt(['chapa'=> $request->chapa, 'password'=> $request->password], $request->remember))
        {
            //Successful
            //return redirect()->intended(route('admin.dashboard'));
            return redirect('/admin');
        }
        //Unsuccessful
        return redirect()->back()->withInput($request->only('chapa', 'remember'));      
         
    }

    public function username()
    {
        return 'chapa';
    }
}
