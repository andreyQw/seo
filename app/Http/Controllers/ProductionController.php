<?php

namespace App\Http\Controllers;

use App\Account;
use App\Model\Project;
use App\Production;
use App\User;
use App\Writer;
use App\Editor;
use Illuminate\Http\Request;
use App\Partner;
use App\Anchor;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;
use App\Components\EventComponent;


class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productions = Production::where('client_approved','Approved')->get();
        $partners = [];
        $partners_id =[];
        foreach ($productions as $production){
            $partners_id = $production->groupBy('partner_id')
                ->distinct()->pluck('partner_id');
        }
        foreach ($partners_id as $id) {
            $partners[] = Partner::find($id);
        }
        return view('production.topic')
            ->withPartners($partners)
            ->withProductions($productions);
    }
    public function search_partner(Request $request)
    {
        if($request->search_partner){
        $partners = Partner::where('domain','like','%'.$request->search_partner.'%')
            ->get();
        if(count($partners)) {
            foreach ($partners as $partner) {
                $productions = Production::where('client_approved', 'Approved')
                    ->where('partner_id', $partner->id)
                    ->get();
            }
        }
        else $productions = Production::where('id',0)->get();
        return view('production.topic')
            ->withPartners($partners)
            ->withProductions($productions);
        }
        else
            return redirect()->route('production.index');
    }

    public function search_live(Request $request)
    {
        if($request->search_partner){
            $partners = Partner::where('domain','like','%'.$request->search_partner.'%')
                ->get();
            if(count($partners)) {
                foreach ($partners as $partner) {
                    $productions = Production::where('client_approved', 'Approved')
                        ->where('partner_id', $partner->id)
                        ->get();
                }
            }
            else $productions = Production::where('id',0)->get();
            return view('production.live_manager')
                ->withPartners($partners)
                ->withProductions($productions);
        }
        else
            return redirect()->route('production.live_manager');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function content_manager()
    {
        $productions = Production::where('client_approved','Approved')
            ->where('topic_approved','Approved')
            ->get();
        $writers = Writer::all();
        return view('production.content_manager')
            ->withWriters($writers)
            ->withProductions($productions);
    }
    public function content_search(Request $request)
    {
        $writers = Writer::all();
        if($request->keyword){
            $partners = Partner::where('domain','like','%'.$request->keyword.'%')
                ->get();
            if(count($partners)) {
                foreach ($partners as $partner) {
                    $productions = Production::where('client_approved', 'Approved')
                        ->where('partner_id', $partner->id)
                        ->where('topic_approved', 'Approved')
                        ->get();
                    if($request->key_priority) {
                        $productions = $productions->where('priority', $request->key_priority);
                    }
                }
            }
            else $productions = Production::where('id',0)->get();
            return view('production.content_manager')
                ->withWriters($writers)
                ->withProductions($productions);
        }
        else
            return redirect()->route('production.content_manager');

    }

    public function editor_manager()
    {
        $productions = Production::where('client_approved','Approved')
            ->where('topic_approved','Approved')
            ->where('content_written','Finished')
            ->whereNotNull('writer_id')
            ->get();
        $editors = Editor::all();
//        dd($productions);
        return view('production.editor_manager')
            ->withEditors($editors)
            ->withProductions($productions);
    }
    public function editor_search(Request $request)
    {
        $editors = Editor::all();
        if($request->keyword){
            $partners = Partner::where('domain','like','%'.$request->keyword.'%')
                ->get();
            if(count($partners)) {
                foreach ($partners as $partner) {
                    $productions = Production::where('client_approved', 'Approved')
                        ->where('partner_id', $partner->id)
                        ->where('topic_approved', 'Approved')
                        ->get();
                    if($request->key_priority) {
                        $productions = $productions->where('priority', $request->key_priority);
                    }
                }
            }
            else $productions = Production::where('id',0)->get();
            return view('production.editor_manager')
                ->withEditors($editors)
                ->withProductions($productions);
        }
        else
            return redirect()->route('production.editor_manager');

    }

    public function personalization_manager()
    {
        $productions = Production::where('client_approved','Approved')
            ->where('topic_approved','Approved')
            ->where('content_written','Finished')
            ->where('content_edited','Finished')
            ->whereNotNull('writer_id')
            ->whereNotNull('editor_id')
            // ->where('overall','!=','Finished')
            ->get();
        return view('production.personalization_manager')
            ->withProductions($productions);
    }
    public function personalization_search(Request $request)
    {
        if($request->keyword){
            $partners = Partner::where('domain','like','%'.$request->keyword.'%')
                ->get();
            if(count($partners)) {
                foreach ($partners as $partner) {
                    $productions = Production::where('client_approved', 'Approved')
                        ->where('partner_id', $partner->id)
                        ->where('topic_approved', 'Approved')
                        ->where('content_written','Finished')
                        ->where('content_edited','Finished')
                        ->get();
                    if($request->key_priority) {
                        $productions = $productions->where('priority', $request->key_priority);
                    }
                }
            }
            else $productions = Production::where('id',0)->get();
            return view('production.personalization_manager')
                ->withProductions($productions);
        }
        else
            return redirect()->route('production.personalization_manager');

    }

    public function live_manager()
    {
        $productions = Production::where('client_approved', 'Approved')
        // ->where('topic_approved', 'Approved')
        // ->where('content_written','Finished')
        // ->where('content_edited','Finished')
        // ->whereNotNull('content')
        ->where('overall','Finished')
        ->where('payment','!=','Paid')
        ->get();
        $partners = [];
        $partners_id =[];
        foreach ($productions as $production){
            $partners_id = $production->groupBy('partner_id')
                ->distinct()->pluck('partner_id');
            foreach($production->partner->anchors as $anchor){
                $prod = Production::where('project_id',$anchor->project_id)
                    ->where('partner_id',$anchor->partner_id)->first();
                if($prod) {
                    $prod->live_link = $anchor->url;
                    $prod->save();
                }
            };
        }
        foreach ($partners_id as $id) {
            $partners[] = Partner::find($id);
        }
        return view('production.live_manager')
            ->withPartners($partners)
            ->withProductions($productions);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $production = Production::find($request->production_id);
        // dd($production);
        $user_id = Auth::user()->id;
        $filename = $request->file('choose_file')->store('');
        $path = $request->file('choose_file')->move('storage/content',$filename);
        EventComponent::new_event(Project::find($request->project_id), 'production_doc',
            $request->production_id , $user_id);
        $production->content = $filename;
        if($production->bio_status == 'Finished' && $production->archor_status == 'Finished'){
            $production->overall = 'Finished';
        }
        else {
            $production->overall = 'Working';
        }
        $production->save();

        return redirect()->back();

    }

    public function topic_ajax(Request $request)
    {
        $productions = Production::find($request->production_id);
        $project = Project::find($productions->project_id);
        $user_id = Auth::user()->id;
        if($request->name == 'priority'){
            $productions->priority = $request->x;
            $productions->save();
        }
        if($request->name == 'topic_approved'){
            $productions->topic_approved = $request->x;
            $productions->save();
            EventComponent::new_event( $project, 'production_topic_approved',
                $productions->id, $user_id);

        }
        if($request->name == 'writer'){
            $productions->writer_id = $request->x;
            $productions->save();
        }
        if($request->name == 'editor'){
            $productions->editor_id = $request->x;
            $productions->save();
        }
        if($request->name == 'rsos'){
            $productions->rsos = $request->x;
            $productions->save();
        }
        if($request->name == 'keywords'){
            $productions->keywords = $request->x;
            $productions->save();
        }
        if($request->name == 'payment'){
            $productions->payment = $request->x;
            $productions->save();
        }
        if($request->name == 'bio_status'){
            $productions->bio_status = $request->x;
            $productions->save();
        }
        if($request->name == 'archor_status'){
            $productions->archor_status = $request->x;
            $productions->save();
        }
        if($request->name == 'topic'){
            $productions->topic = $request->x;
            $productions->save();
        }
        
        if($request->name == 'content_written'){
            $productions->content_written = $request->x;
            $productions->save();
            if($request->x == 'Finished' ){
            EventComponent::new_event( $project, 'production_content_written',
                $productions->id, $user_id);
            }
        }
        if($request->name == 'content_edited'){
            $productions->content_edited = $request->x;
            $productions->save();
            if($request->x == 'Finished' ){
            EventComponent::new_event( $project, 'production_content_edited',
                $productions->id, $user_id);
            }
        }
        if($request->name == 'content_personalized'){
            $productions->content_personalized = $request->x;
            $productions->save();
            if($request->x == 'Finished' ){
            EventComponent::new_event( $project, 'production_content_personalized',
                $productions->id, $user_id);
            }
        }
        if($request->name == 'content_status'){
            $productions->content_status = $request->x;
            $productions->save();
            if($productions->content_status == 'Live') {
                EventComponent::new_event( $project, 'production_live',
                    $productions->id, $user_id);
            }
        }
        if($request->name == 'live_link'){
            $productions->live_link = $request->x;
            $productions->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }

    public function download_doc_content($id) {
        return response()->download('storage/content/' . Production::find($id)->content);
    }
}
