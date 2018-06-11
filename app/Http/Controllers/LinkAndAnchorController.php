<?php

namespace App\Http\Controllers;

use App\Account;
use App\Anchor;
use App\Components\EventComponent;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Order;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

class LinkAndAnchorController extends Controller
{
    public function index (Request $req) {

        $user = Auth::user();

        if($user->hasRole('client')){

            if($req->id){
                $edition_proj = $user->projects()->find($req->id);

                if(!$edition_proj){
                    return redirect()->action('LinkAndAnchorController@index');
                }

                if(!$edition_proj->products->find(1)){
                    return redirect()->action('LinkAndAnchorController@index');
                }
            }else{
                $edition_proj = $user->projects->all();
                foreach($edition_proj as $proj){
                    if(!$proj->products()->find(1)){
                        continue;
                    }else{
                        $edition_proj = $proj;
                        break;
                    }
                }
            }

            $anchors = $edition_proj->anchors;
            if($anchors->count() <= 0){
                $anchors = [];
            }

            $select_id = $edition_proj->id;
            $quantity = $edition_proj->products->find(1)->pivot->quantity;

            if($anchors){
                $count_anchor_need = $quantity - $anchors->count();
            }else{
                $count_anchor_need = $quantity;
            }

            return view('client.link_anchor_manager', [
                'select_id' => $select_id,
                'anchors' => $anchors,
                'quantity' => $quantity,
                'need' => $count_anchor_need,
                'domain' => $edition_proj->url
            ]);

        }elseif ($user->hasAnyRole('super_admin|admin|pm')){

            if($user->hasAnyRole('super_admin|admin')){
                $projects = Project::all()->reject(function ($project){
                    return !$project->account->name;
                });
            }else{
                $accs = $user->accounts();
                if($accs->count() > 0){
                    $projects = array();
                    foreach ($accs->whereNotNull('name')->get() as $acc){
                        foreach ($acc->projects->all() as $pr){
                            $projects[] = $pr;
                        }
                    }
                }else{
                    $projects = [];
                }

            }

            return view('admin.link_anchor', ['projects' => $projects]);
        }
    }

    public function confirm (Request $req) {

        if(!$req->site){
            return redirect()->action('LinkAndAnchorController@index');
        }

        $site = Project::find($req->site);

        /*dd($site->users->find(4)->hasRole('client'));*/

        $quantity = $site->products->find(1)->pivot->quantity;

        if($site->anchors->count() >= $quantity){
            return redirect()->back();
        }else{
            $quantity = $quantity - $site->anchors->count();
        }

        $this->validate($req, [
            'anchor' => 'size:' . $quantity,
            'url' => 'size:' . $quantity,
            'anchor.*' => 'required|string',
            'url.*' => 'required|string'
        ]);

        $to_mail = [];

        for ($i = 0; $i < count($req->anchor); $i++){

            if(empty($req->anchor[$i]) && empty($req->url[$i])){
                continue;
            }

            $site->anchors()->save(new Anchor([
                'text' => $req->anchor[$i],
                'url' => $req->url[$i]
            ]));

            $to_mail['anchors'][] = array('anchor' => $req->anchor[$i], 'link' => $req->url[$i]);
        }

        if($req->description){
            $site->description = $req->description;
            $site->save();
        }

        EventComponent::new_event($site, 'anchor', $site->id);

        $to_mail['subject'] = 'Link & Anchor Confirmed!';
        $to_mail['site'] = $site->id;

        foreach ($site->users as $user) {
            if($user->hasRole('client') && $user->pivot->enable_notifi){
                Mail::to($user)->queue(new UserMail($to_mail, 'mails.anchor_confirm'));
            }
        }

        return redirect()->action('LinkAndAnchorController@index');

    }

    public function show_modal (Request $req) {

        $proj = Project::find($req->id);
        $anch = $proj->anchors;

        return response()->json(['project' => $proj, 'anchor' => $anch]);
    }

    public function admin_edit(Request $req)
    {
        $project = Project::find($req->id);

        foreach($req->anchors as $id => $anchor){

            $anch = $project->anchors->find($id);
            if(!$anch){
                continue;
            }

            $anch->text = $anchor['text'];
            $anch->url = $anchor['url'];
            $anch->save();
        }

        return redirect()->action('LinkAndAnchorController@index');
    }

    public function client_edit(Request $req)
    {
        foreach($req->anchors as $id => $anchor){

            $anch = Anchor::find($id);
            if(!$anch){
                continue;
            }

            $anch->text = $anchor['text'];
            $anch->url = $anchor['url'];
            $anch->save();
        }

        return redirect()->action('LinkAndAnchorController@index');
    }

    public function search_project(Request $req)
    {
        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $projs = Project::where('url', 'like', '%' . $req->search . '%')->get();
        }else{
            $projs = Auth::user()->projects()->where('url', 'like', '%' . $req->search . '%')->get();
        }

        return view('admin.link_anchor', ['projects' => $projs]);
    }
}
