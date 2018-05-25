<?php

namespace App\Http\Controllers;

use App\Account;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Niche;
use App\Bio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Mail;
use App\Mail\UserMail;

class AccountController extends Controller
{
    public function registrationSuccess()
    {
        return view('account.registration_success');
    }

    public function setAccountForm()
    {
        $niches = Niche::all();
//        $account = Auth::user()->accounts()->where('owner_id', Auth::id())->first();
        $account = Auth::user()->accounts()->where('owner_id', Auth::id())->first();
//        dd(Auth::user()->orders()->first()->projects);
//        foreach (Auth::user()->orders()->first()->projects as $project){
//            dd($project->bio);
//        }
//        dd($account);
//        dd(Auth::user()->accounts);
//        dd(Auth::user()->accounts()->where('owner_id', Auth::id())->first());
//        dd($niches);
        return view('account.accountSetup', ['niches' => $niches, 'account' => $account]);
    }

    public function editAccount(Request $request)
    {
        $data = $request->all();
//        dd($data);
//        var_dump($data['']);
        $user = Auth::user();
//        dd($user->accounts()->where('owner_id', $user->id)->first());

//        dd($data);
        $rules = [
            'first_name' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
//            'password_confirmation' => 'required_with:password|string|min:6',
//            'company' => 'required|string',
//            'company_email' => 'required|string',
            'niche.*' => 'required|string',
        ];

        $messages = [
            'niche.required'   =>  'Your Niche is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
//            dd($this->getParameters($order));
            return redirect()->back()->withErrors($validator)->withInput();
        };

//        dd($user->password);

//        if( Hash::check( $data['old_pass'], $user->password) == false) {
//            // Password is not matching
////            return redirect()->back()->withErrors('error', 'error_pass');
//            return redirect()->back()->with('error', 'Old password is invalid');
////            dd('Password is not matching');
//        }

//        $new_pass = bcrypt( $data['new_pass'] );
        $user->update(
            [
                'first_name' => $data['first_name'],
                'country' => $data['country'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]
        );
//        dd( URL::to('/'));

        $mailData = array(
            'link' => URL::to('/'),
            'login' => $user->email,
            'first_name' => $user->first_name,
            'new_password' => $data['password'],
        );
        Mail::to($user->email)->send(new UserMail($mailData, 'mails.account_change_pass'));


        if(!empty($request->file('photo'))){
            $filename = strtotime((new \DateTime('now'))
                    ->format('Y/m/d H:i:s')) . "_" . $user->first_name . "_" . $user->last_name . ".png";
            $request->file('photo')->move('storage/photo_users', $filename);
            $user->update(['photo' => $filename]);
        }

        $user->accounts()->where('owner_id', $user->id)->update(
            ['email' => $user->email]
        );

//        dd($data['project_id']);
        foreach ($data['project_id'] as $i => $project_id ){
//            dd($project_id);
            $project = Project::find($project_id);
            $project->niches()->attach($data['niche'][$i]);

            if (!$project->bio){
//                dd('no_bS_to_do_my_bio');
                $bio = new Bio([
                    'help' => true
                ]);
                $project->bio()->save($bio);
            }

//            $project->users()->attach($user->id, ['enable_notifi' => true]);
//            dd($project->niches);
        }

        return redirect()->route('home');
//        return redirect()->route('clients.index');
    }

    public function noBsDoBio(Request $request)
    {
//        dd($request->project_id);
        $project = Project::where('id', $request->project_id)->first();
        $bio = new Bio([
            'help' => true
        ]);
        $project->bio()->save($bio);
//        dd($project);
        return response()->json(['proj_id'=>$request->project_id, 'success'=>true]);
    }

    public function confirmBio(Request $request)
    {
        $data = $request->all();
//        dd($request->file('screen'));
//        dd($data);
//        dd($request);
        $rules = [
            'project_id' => 'required|string',
            'image' => 'required|image',
            'bio_write' => 'required',
        ];

        $messages = [
            'project_id.required'   =>  'Your Bio is required.',
            'screen.required'   =>  'Your Bio image is required.',
            'screen.image'   =>  'Your Bio image must be image.',
            'text.required'   =>  'Your Bio info is required.',
        ];

        $validator = Validator::make($data, $rules, $messages);

//        dd($validator );
        if($validator->fails()){
//            dd($this->getParameters($order));
            return response()->json(['error'=>$validator->errors()->all()]);
        }else{

//            1111111111111111
            $filename = time() . "_bio.png";
            $request->file('image')->move('storage/bio_img', $filename);


            $bio = new Bio([
                'text' => $request->bio_write,
                'image' => $filename,
            ]);

//            dd($bio);
            Auth::user()->projects->find($request->project_id)->bio()->save($bio);

            foreach (Project::find($request->project_id)->users as $user) {
                if($user->hasRole('client') && $user->pivot->enable_notifi){
                    Mail::to($user)->queue(new UserMail(array('text' => $request->text), 'mails.bio_confirm'));
                }
            }
//            111111111111111111111111111

//            return redirect()->action('BioManagerController@index');

            return response()->json(['proj_id'=>$request->project_id, 'success'=>true, 'message'=>'bio was save']);
        }

//        dd($request);
//        dd($_FILES['img']);
//        $bio = Bio::all();


    }


    /**
     *
     * author Maksym Kyselyov
     *
     **/
    public function index()
    {

        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $accs = Account::whereNotNull('name')->get();
        }else{
            $accs = Auth::user()->whereNotNull('name')->get();
        }

        return view('admin.account_manager', ['accounts' => $accs]);

    }

    public function new_account (Request $request)
    {
        $this->validate($request, [
            'name' => 'string|max:255|required',
            'email' => 'email|string|required|max:255',
            'phone' => 'regex:/\d{6,18}/'
        ]);

        if(!empty($request->file('photo'))){
            $filename = time() . "_logo.png";
            $request->file('photo')->move('storage/account_logos', $filename);
        }else{
            $filename = null;
        }

        $acc = new Account([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->client_type,
            'stage' => $request->stage,
            'no_staff' => $request->no_staff,
            'no_websites' => $request->no_websites,
            'logo' => $filename
        ]);

        $acc->save();

        return redirect()->action('AccountController@index');

    }

    public function search (Request $req)
    {
        if(empty($req->search)){
            return redirect()->action('AccountController@index');
        }

        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $accs = Account::where('name', 'like', '%' . $req->search . '%')->get();
        }else{
            $accs = Auth::user()->accounts()->where('name', 'like', '%' . $req->search . '%')->get();
        }

        return view('admin.account_manager', ['accounts' => $accs]);
    }

}

