<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Model\Project;
use App\User;

class UsersController extends Controller
{
    public function index () {

        return view('setting');
    }

    public function change_password (Request $req) {

        $user = Auth::user();
        $req->password = bcrypt($req->password);

        if(!Hash::check($req->get('password'), $user->password)){
            return redirect()->back()->with('error', 'Old password is invalid');
        }

        $this->validate($req, [
            'password' => 'required',
            'new_pass' => 'required|string|min:6',
        ]);

        $user->password = bcrypt($req->new_pass);
        $user->save();

        return redirect()->action('UsersController@index');
    }

    public function change_personal_info (Request $req) {

        $user = Auth::user();
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ];

        if(!empty($req->file('photo'))){
            $filename = strtotime((new \DateTime('now'))->format('Y/m/d H:i:s')) . "_" . $req->first_name . "_" . $req->last_name . ".png";
            $req->file('photo')->move('storage/photo_users', $filename);
            $user->photo = $filename;
        }

        if($req->email != $user->email){
            $rules['email'] = 'required|string|email|max:255|unique:users';
        }

        if(!empty($req->phone)){
            $rules['phone'] = 'regex:/\d{6,18}/';
        }

        $this->validate($req, $rules, [
            'numeric' => 'The phone number must consist only of numbers.'
        ]);

        $user->first_name = ucfirst($req->first_name);
        $user->last_name = ucfirst($req->last_name);
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->save();

        return redirect()->action('UsersController@index');
    }

    public function change_notifi (Request $req) {

        $projs = Auth::user()->projects;
        $enable = array();

        if(!$req->id){
            foreach ($projs as $proj) {
                $proj->pivot->enable_notifi = false;
                $proj->pivot->save();
            }
            return redirect()->action('UsersController@index');
        }

        foreach ($req->id as $key => $value) {
            $enable[] = $key;
        }


        $en_sites = $projs->whereIn('id', $enable);
        foreach ($en_sites as $en) {
            $en->pivot->enable_notifi = true;
            $en->pivot->save();
        }

        $des_sites = $projs->whereNotIn('id', $enable);
        foreach ($des_sites as $des) {
            $des->pivot->enable_notifi = false;
            $des->pivot->save();
        }

        return redirect()->action('UsersController@index');
    }

    public function stop_sending (Request $req) {
        $user = User::find(Auth::user()->id);
        $user->stop_sending = true;
        $user->save();
        return redirect()->back();
    }
}
