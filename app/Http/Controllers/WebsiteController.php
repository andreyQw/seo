<?php

namespace App\Http\Controllers;

use App\Anchor;
use App\Bio;
use App\Model\Order;
use App\Model\Product;
use App\Model\Project;
use App\Account;
use App\Niche;
use App\Partner;
use App\Production;
use App\UpdateClient;
use App\UpdateNobs;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Components\EventComponent;
use App\Feed;
use App\User;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;


class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $projects = Project::all();
        }else{
            $projects = Auth::user()->projects;
        }

        $niches = Niche::all();
        $accs = Account::whereNotNull('name')->get();

        return view('admin.website_manager', ['projects' => $projects, 'niches' => $niches, 'accounts' => $accs]);

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|string|max:255',
            'company' => 'required',
            'niche' => 'required',
            'placements' => 'required|integer'
        ]);

        $proj = new Project(['url' => $request->url]);
        $proj->account()->associate(Account::find($request->company));
        $proj->save();

        $proj->users()->attach(Account::find($request->company)->users->pluck('id'));

        EventComponent::new_event($proj, 'project', $proj->id);

        $proj->products()->attach(1, ['quantity' => $request->placements]);

        if(!empty($request->file('image')) && !empty($request->text)){
            $filename = time() . "_bio.png";
            $request->file('image')->move('storage/bio_img', $filename);
            $proj->bio()->save(new Bio(['text' => $request->text, 'image' => $filename]));
        }

        for($i = 0; $i < count($request->anchor); $i++){
            if(empty($request->link[$i]) || empty($request->anchor[$i]) || $i == 0) continue;
            $proj->anchors()->save(new Anchor(['text' => $request->anchor[$i], 'url' => $request->link[$i]]));
        }

        return redirect()->action('WebsiteController@index');

    }

    public function del_partner(Request $request)
    {
        $production = Production::where('project_id',$request->project_id)
            ->where('partner_id',$request->partner_id)->first();
        $production->del_partner_id = 1;
        $production->save();
    }

     public function add_partner(Request $request)
    {
        // dd($request);
        $project_id = $request->project_id;
        $productions = Production::where('project_id',$project_id)->get();
        foreach ($productions as $production) {
            if ($production->del_partner_id && $production->client_approved != 'Approved') {
                $production->delete();
            }
        }
        $partner_arr = array();
        if(!empty($request->new_partner_id)){
            foreach ($request->new_partner_id as $partner){               
                    $production = new Production();
                    $production->project_id = $project_id;
                    $production->partner_id = $partner;
                    $production->save();
                    $partner_arr['parts'][] = Partner::find($partner);
            }                
        }
        if(!empty($partner_arr)){
            $partner_arr['subject'] = 'New Site Add to Quality Control';
            $partner_arr['id'] = $request->project_id;
            foreach (Project::find($request->project_id)->users as $user) {
                if($user->hasRole('client') && $user->pivot->enable_notifi){
                    Mail::to($user)->queue(new UserMail($partner_arr, 'mails.new_websites'));
                }
            }
        }
        return redirect()->back();
    }
    public function show($id)
    {
        $project = Project::find($id);
        $products = Product::all();
        $partners = Partner::all();
        $productions = Production::where('project_id',$id)
        // ->where('client_approved','<>','Approved')
            ->get();
        $quantity = DB::table('order_product')
            ->where('project_id',$id)
            ->get();

        return view('website.dashboard')
            ->withProducts($products)
            ->withPartners($partners)
            ->withProject($project)
            ->withQuantity($quantity)
            ->withProductions($productions);
    }

    public function edit($id)
    {

    }

    public function load_updates_nobs (Request $request)
    {
//        dd($request);
        $production_id = $request->production_id;
        $production = Production::find($production_id);
//        dd($production);
        $anchor = Anchor::where('project_id', $production->project_id)
            ->where('partner_id', $production->partner_id)->first();
        $feeds = Feed::where('table_id',$production_id)
            ->whereIn('event_id',[7,8,9,10,11])->get();
        $users = User::whereNull('stop_sending')->get();
        return response()->view('website.update',[
            'users' => $users,
            'feeds' => $feeds,
            'anchor' => $anchor
        ]);

    }

    public function store_comment_nobs (Request $request)
    {
        if(!$request->comment){
            return redirect()->back();
        }

        $comment = new UpdateNobs();
        $comment->text = $request->comment;
        if(!empty($request->recipients)){
            $comment->recipients = serialize($request->recipients);
        }
        $comment->user()->associate(Auth::user());
        $comment->feed()->associate(Feed::find($request->feed));
        $comment->save();
        return redirect()->back();
    }

    public function store_comment_client (Request $request)
    {
        if(!$request->comment){
            return redirect()->back();
        }

        $comment = new UpdateClient();
        $comment->text = $request->comment;
        if(!empty($request->recipients)){
            $comment->recipients = serialize($request->recipients);
        }
        $comment->user()->associate(Auth::user());
        $comment->feed()->associate(Feed::find($request->feed));
        $comment->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function search(Request $req)
    {

        if(empty($req->search)){
            return redirect()->action('WebsiteController@index');
        }

        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $projs = Project::where('url', 'like', '%' . $req->search . '%')->get();
        }else{
            $projs = Auth::user()->projects()->where('url', 'like', '%' . $req->search . '%')->get();
        }

        $niches = Niche::all();
        $accs = Account::whereNotNull('name')->get();

        return view('admin.website_manager', ['projects' => $projs, 'niches' => $niches, 'accounts' => $accs]);

    }
}
