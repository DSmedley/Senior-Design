<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function users()
    {
        //Get all users from the database
        $users = User::all();

        return view('admin.users')->with('users', $users);
    }

    public function getUser($id = null)
    {
        //Get user data from specified user
        //Else return error
        if ($id){
            $user = User::where('id', $id)->first();
        }

        //Return to user edit page
        return view('admin.user-edit')->with('user', $user);
    }

    public function banUser($id = null)
    {
        //Check if id is set
        if ($id){
            //Ban user
            User::where('id', $id)->update(['blocked' => '1']);
        }

        //Return to manage users page
        return redirect()->route('admin.users');
    }

    public function unbanUser($id = null)
    {
        //Check if id is set
        if ($id){
            //Ban user
            User::where('id', $id)->update(['blocked' => '0']);
        }

        //Return to manage users page
        return redirect()->route('admin.users');
    }

    public function updateUser(Request $request, $id = null){
        //Handle the user profile edits

        if($request->has('new-password')){
            //Handle user passwword change

            $validatedData = $request->validate([
                'new-password' => 'required|string|min:8|confirmed',
            ]);

            //Change Password
            User::where('id', $id)->update(['password' => bcrypt($request->get('new-password'))]);

            return redirect()->route('admin.user.edit', array('id' => $id))->with("passwordSuccess","Password changed successfully!");
        }

        if($request->has('email')){
            //Handle user email change
            $validatedData = $request->validate([
                'email' => 'required|email|max:255|unique:users|confirmed',
            ]);

            //Change Email
            User::where('id', $id)->update(['email' => $request->get('email')]);

            return redirect()->route('admin.user.edit', array('id' => $id))->with("emailSuccess","Email changed successfully!");
        }

        if($request->has('changeAvatar')){
            //Handle user avatar update
            if($request->hasFile('avatar')){
                //Upload avatar
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename) );

                //Change Avatar
                User::where('id', $id)->update(['avatar' => $filename]);

                return redirect()->route('admin.user.edit', array('id' => $id))->with("avatarSuccess","Avatar changed successfully!");
            }else{
                return redirect()->route('admin.user.edit', array('id' => $id))->with("avatarError","Avatar change failed!");
            }

        }

        if($request->has('changeBio')){
            //handle user bio change
            $validatedData = $request->validate([
                'bio' => 'required|max:191',
            ]);

            //Change Bio
            User::where('id', $id)->update(['bio' => $request->get('bio')]);

            return redirect()->route('admin.user.edit', array('id' => $id))->with("bioSuccess","Bio changed successfully!");
        }


        if($request->has('changeName')){
            //handle username change
            $validatedData = $request->validate([
                'name' => 'required|max:191',
            ]);

            //Change Name
            User::where('id', $id)->update(['name' => $request->get('name')]);

            return redirect()->route('admin.user.edit', array('id' => $id))->with("nameSuccess","Name changed successfully!");
        }

        if($request->has('removeAdmin')){
            //Remove admin rights
            User::where('id', $id)->update(['is_admin' => '0']);

            return redirect()->route('admin.user.edit', array('id' => $id))->with("adminSuccess","Administrative rights removed successfully!");
        }

        if($request->has('grantAdmin')){
            //Remove admin rights
            User::where('id', $id)->update(['is_admin' => '1']);

            return redirect()->route('admin.user.edit', array('id' => $id))->with("adminSuccess","Administrative rights granted successfully!");
        }

    }

    public function create()
    {
        return view('admin.create');
    }
}
