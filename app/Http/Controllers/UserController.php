<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use Image;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user');
    }
    
    public function edit(){
        return view('user.edit');
    }
    
    public function inbox(){
        return view('user.inbox');
    }
    
    public function updateProfile(Request $request){
        //Handle the user profile edits
            
        if($request->has('changePassword')){
            //Handle user passwword change
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                // The passwords matches
                return redirect()->route('user.edit')->with("passwordError","Your current password does not match with the password you provided. Please try again.");
            }

            if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                //Current password and new password are same
                return redirect()->route('user.edit')->with("passwordError","New Password cannot be same as your current password. Please choose a different password.");
            }

            $validatedData = $request->validate([
                'current-password' => 'required',
                'new-password' => 'required|string|min:6|confirmed',
            ]);

            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();
            
            return redirect()->route('user.edit')->with("passwordSuccess","Password changed successfully!");
        }
            
        if($request->has('changeEmail')){
            //Handle user email change
            $validatedData = $request->validate([
                'email' => 'required|email|max:255|unique:users|confirmed',
            ]);

            //Change Email
            $user = Auth::user();
            $user->email = $request->get('email');
            $user->save();
            
            return redirect()->route('user.edit')->with("emailSuccess","Email changed successfully!");
        }
            
        if($request->has('changeAvatar')){
            //Handle user avatar update
            if($request->hasFile('avatar')){
                //Upload avatar
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename) );

                //Change Avatar
                $user = Auth::user();
                $user->avatar = $filename;
                $user->save();
                
                return redirect()->route('user.edit')->with("avatarSuccess","Avatar changed successfully!");
            }else{
                return redirect()->route('user.edit')->with("avatarError","Avatar change failed!");
            }
            
        }
            
        if($request->has('changeBio')){
            //handle user bio change
            $validatedData = $request->validate([
                'bio' => 'required|max:191',
            ]);

            //Change Bio
            $user = Auth::user();
            $user->bio = $request->get('bio');
            $user->save();
            
            return redirect()->route('user.edit')->with("bioSuccess","Bio changed successfully!");
        }
        
            
        if($request->has('changeName')){
            //handle username change
            $validatedData = $request->validate([
                'name' => 'required|max:191',
            ]);

            //Change Name
            $user = Auth::user();
            $user->name = $request->get('name');
            $user->save();
            
            return redirect()->route('user.edit')->with("nameSuccess","Name changed successfully!");
        }
        
    }
}