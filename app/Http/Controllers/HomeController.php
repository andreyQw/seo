<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
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
        $user = Auth::user();

        if($user->hasRole('client')){
            return redirect()->route('clients.index');
        }

        return redirect()->route('feed');
    }

    public function test_mails () {
        Mail::to('jointoitqa@gmail.com')->send(new UserMail(array(), 'mails.final-first-email'));
        Mail::to('jointoitqa@gmail.com')->send(new UserMail(array(), 'mails.final-second-email'));
        Mail::to('jointoitqa@gmail.com')->send(new UserMail(array(), 'mails.final-third-email'));
        /*Mail::to('m.tven18@gmail.com')->send(new UserMail(array(), 'mails.new_order'));
        Mail::to('m.tven18@gmail.com')->send(new UserMail(array(), 'mails.anchor_confirm'));
        Mail::to('m.tven18@gmail.com')->send(new UserMail(array(), 'mails.someone_tagged'));
        Mail::to('m.tven18@gmail.com')->send(new UserMail(array(), 'mails.bio_confirm'));
        Mail::to('m.tven18@gmail.com')->send(new UserMail(array(), 'mails.order_finish'));
        Mail::to('m.tven18@gmail.com')->send(new UserMail(array(), 'mails.placement_gone_live'));*/
    }
}
    