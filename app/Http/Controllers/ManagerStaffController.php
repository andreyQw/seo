<?php

namespace App\Http\Controllers;

use App\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Model\Project;
use Validator;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Components\EventComponent;

class ManagerStaffController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->hasAnyRole('super_admin|admin')){
            $accounts = Account::whereNotNull('name')->get();
        }else{
            $accounts = $user->accounts()->whereNotNull('name')->get();
        }

        $users = User::where('id', '!=', $user->id)->whereNotNull('password')->get();
        return view('admin.user_manager', ['users' => $users, 'accounts' => $accounts]);
    }

    public function create_user (Request $req)
    {
        if(!empty($req->file('photo'))){
            $filename = strtotime((new \DateTime('now'))->format('Y/m/d H:i:s')) . "_" . $req->first_name . "_" . $req->last_name . ".png";
            $req->file('photo')->move('storage/photo_users', $filename);
        }else{
            $filename = 'user_anonim.png';
        }

        $data = array(
            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'email' => $req->email,
            'password' => $req->password,
            'photo' => $filename,
            'role' => $req->role,
        );

        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required',
        ]);

        if($req->name){
            if(User::where('name', $req->name)->count()){
                return redirect()->back()
                    ->with('error', 'Field "Name" need unique');
            }
        }

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $user = new User([

                'first_name' => ucfirst($data['first_name']),
                'last_name' => ucfirst($data['last_name']),
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'photo' => $data['photo'],
                'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ]);

        if(($req->role != 'super_admin' || $req->role != 'admin')){

            if(!$req->accounts_access){
//                dd($req);
                return redirect()->back()
                                 ->with('error', 'Error create user: must add at least one account');
            }

        }else{
            if($req->name){
                $user->name = $req->name;
            }
            $user->save();
            $user->assignRole($req->role);

            if($req->with_user){
                $data['subject'] = 'Welcome to NO-BS Platform!';
                Mail::to($user)->send(new UserMail($data, 'mails.new_user'));
            }

            return redirect()->back();
        }

        $user->save();
        $user->assignRole($req->role);

        foreach ($req->accounts_access as $value) {

            Account::find($value)->save_user($user);

            foreach (Account::find($value)->projects as $project){
                EventComponent::new_event($project, 'user', $user->id);
            }

        };


        if($req->with_user){
            $data['subject'] = 'Welcome to NO-BS Platform!';
            Mail::to($user)->send(new UserMail($data, 'mails.new_user'));
        }

        return redirect()->action('ManagerStaffController@index');

    }

    public function modal_user (Request $req) {

        $user = User::find($req->id);
        $admin = Auth::user();

        $accs = $user->accounts();

        if($admin->hasAnyRole('super_admin|admin')){
            $inaccess = Account::whereNotIn('id', $accs->pluck('id'))->whereNotNull('name')->get();
        }else{
            $inaccess = $admin->accounts()->whereNotIn('id', $accs->pluck('id'))->whereNotNull('name')->get();
        }

        if($admin->hasAnyRole('super_admin|admin')){
            $access = $accs->whereNotNull('name')->get();
        }else{
            $access = $accs->whereIn('id', $admin->accounts()->pluck('id'))->whereNotNull('name')->get();
        }
        
        $user_role = $user->getRoleNames()[0];

        $res_arr = array('user' => $user, 'role' => $user_role, 'access' => $access, 'inaccess' => $inaccess);

        if($admin->hasRole('super_admin')){
            $res_arr['per'] = 0;
        }elseif($admin->hasRole('admin')){
            $res_arr['per'] = 1;
        }

        return response()->json($res_arr);

    }

    public function delete_user (Request $req) {

        $user = User::find($req->id);
        $user->delete();

        return response()->json([
            'success' => 0,
        ]);

    }

    public function info(Request $req)
    {
        return response()->json(['user' => User::find($req->id), 'role' => User::find($req->id)->getRoleNames()[0]]);
    }

    public function edit_info_user (Request $req) 
    {
        $user = User::find($req->id);

        $rules = array(
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        );

        if($req->phone) $rules['phone'] = 'regex:/\d{6,18}/';
        if($req->name) $rules['name'] = 'string|max:255';
        if($req->new_pass) $rules['new_password'] = 'string|max:255|min:8';
        if($user->email != $req->email) $rules['email'] = 'required|string|email|max:255|unique:users';

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        foreach ($req->all() as $key => $value) {
            if($key == "_token" || $key == 'id'){
                continue;
            }

            if($key == 'new_password'){
                if(!empty($value)){
                    $user->password = bcrypt($value);
                    continue;
                }else{
                    continue;
                }
            }

            if($key == 'role'){
                if(!$user->hasRole($value)){
                    $user->removeRole($user->getRoleNames()[0]);
                    $user->assignRole($value);
                    continue;
                }else{
                    continue;
                }
            }

            $user->$key = $value;
        }

        if(!empty($req->file('photo'))){
            $filename = strtotime((new \DateTime('now'))->format('Y/m/d H:i:s')) . "_" . $req->first_name . "_" . $req->last_name . ".png";
            $req->file('photo')->move('storage/photo_users', $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->action('ManagerStaffController@index');
    }

    public function add_site(Request $req)
    {

        // !!!!!!!!!!!!!!!!!!!!!!!!! MODAL WINDOW BUG !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        if(User::find($req->user_id)->accounts()->find($req->acc_id)){
            return response()->json(['success']);
        }

        $res = Account::find($req->acc_id)->save_user(User::find($req->user_id));

        foreach (Account::find($req->acc_id)->projects as $project){
            EventComponent::new_event($project, 'user', $req->user_id);
        }

        return response()->json(['success' => $res]);

    }

    public function delete_site(Request $req)
    {

        Account::find($req->acc_id)->delete_user(User::find($req->user_id));

        return response()->json(['success']);

    }
}
