<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bio;
use App\Model\Project;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

use App\Components\EventComponent;

use Zip;
use Storage;

class BioManagerController extends Controller
{
    public function index (Request $req) {

        $user = Auth::user();

        if($user->hasRole('client')){

            $projs = $user->projects;
            $need_bio = array();
            $confirm_bio = array();
            foreach ($projs as $proj) {
                if(!$proj->bio){
                    $need_bio[] = $proj;
                }elseif(!$proj->bio->help){
                    $confirm_bio[] = $proj;
                }
            }
            return view('client.bio_manager', ['projects' => $need_bio, 'confirmed' => $confirm_bio]);

        }elseif ($user->hasAnyRole('super_admin|admin|pm')){
            
            if($user->hasAnyRole('super_admin|admin')){
                $bios = Bio::where('help', false)->get();
            }else{
                $bios = array();
                foreach ($user->projects as $proj) {
                    if($proj->bio && $proj->bio()->where('help', false)->first()){
                        $bios[] = $proj->bio;
                    }
                }
            }

            return view('admin.bio_manager', ['bios' => $bios]);
        }
    }

    public function help_bio(Request $req)
    {
        if(!$req->id){
            return redirect()->action('BioManagerController@index');
        }

        $bio = new Bio([
                'help' => true
        ]);

        Auth::user()->projects()->find($req->id)->bio()->save($bio);

        return response()->json(['success']);
    }

    public function confirm(Request $req)
    {
        if(!$req->site){
            return redirect()->action('BioManagerController@index');
        }

        if(!empty($req->file('screen'))){
            $filename = time() . "_bio.png";
            $req->file('screen')->move('storage/bio_img', $filename);
        }else{
            return redirect()->back()->with('error', 'Please download file!');
        }

        if(!$req->bio_write){
            return redirect()->back()->with('error', 'Please Bio write!');
        }

        $bio = new Bio([
            'text' => $req->bio_write,
            'image' => $filename,
        ]);

        Auth::user()->projects->find($req->site)->bio()->save($bio);

        foreach (Project::find($req->site)->users as $user) {
            if($user->hasRole('client') && $user->pivot->enable_notifi){
                Mail::to($user)->queue(new UserMail(array('text' => $req->bio_write, 'subject' => 'Bio Confirmed!'), 'mails.bio_confirm'));
            }
        }

        EventComponent::new_event(Project::find($req->site), 'bio', $bio->id);

        return redirect()->action('BioManagerController@index');
    }

    public function view_modal(Request $req)
    {
        $bio = Bio::find($req->id);

        return response()->json(array(
            'id' => $bio->id, 
            'text' => $bio->text, 
            'img' => $bio->image,
            'url' => $bio->project->url,
        ));
    }

    public function edit_bio(Request $req)
    {
        $bio = Bio::find($req->id);

        if(!empty($req->file('image'))){
            $filename = time() . "_bio.png";
            $req->file('image')->move('storage/bio_img', $filename);
            $bio->image = $filename;
        }

        $bio->text = $req->text;
        $bio->save();

        return redirect()->action('BioManagerController@index');
    }

    public function download_bio(Request $req)
    {
        $bio = Bio::find($req->id);
        $path_zip = storage_path() . '/app/public/bios_zip/' . $bio->project->id . '_bio.zip';

        if(file_exists($path_zip)){
            $zip = Zip::open($path_zip);
            $zip->delete($zip->listFiles());
        }else{
            $zip = Zip::create($path_zip);
        }

        Storage::put('public/bios_zip/tmp/' . $bio->id . '_bio.txt', $bio->text);
        
        $zip->add(storage_path() . '/app/public/bio_img/' . $bio->image);
        $zip->add(storage_path() . '/app/public/bios_zip/tmp/' . $bio->id . '_bio.txt');
        $zip->close();

        Storage::delete('public/bios_zip/tmp/' . $bio->id . '_bio.txt');

        return response()->download($path_zip);
    }

    public function search_bio(Request $req)
    {
        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $projs = Project::where('url', 'like', '%' . $req->search . '%')->get();
        }else{
            $projs = Auth::user()->projects()->where('url', 'like', '%' . $req->search . '%')->get();
        }
        $bios = array();
        foreach ($projs as $proj) {
            if($proj->bio && $proj->bio()->where('help', false)->first()){
                $bios[] = $proj->bio;
            }
        }

        return view('admin.bio_manager', ['bios' => $bios]);
    }

    public function requests (Request $req){

        $res_arr = array();

        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $projs = Project::all();
        }else{
            $projs = Auth::user()->projects;
        }

        foreach ($projs as $proj) {
            if($proj->bio && $proj->bio->help){
                $res_arr[] = $proj;
            }
        }

        return view('admin.request_bio_manager', ['projects' => $res_arr]);
    }

    public function add_bio(Request $req)
    {

        if(!Project::find($req->id)){
            return redirect()->action('BioManagerController@requests');
        }

        if(empty($req->file('screen'))){
            return redirect()->back()->with('error', 'Bio image does not exists!');
        }

        if(!$req->text){
            return redirect()->back()->with('error', 'Pleace Bio text write!');
        }

        $filename = time() . "_bio.png";
        $req->file('screen')->move('storage/bio_img', $filename);

        $bio = Project::find($req->id)->bio;
        $bio->image = $filename;
        $bio->text = $req->text;
        $bio->help = false;
        $bio->save();

        EventComponent::new_event(Project::find($req->id), 'bio', $bio->id);

        foreach (Project::find($req->id)->users as $user) {
            if($user->hasRole('client') && $user->pivot->enable_notifi){
                Mail::to($user)->queue(new UserMail(array('text' => $bio->text, 'subject' => 'Bio is Ready!'), 'mails.bio_request'));
            }
        }

        return redirect()->action('BioManagerController@requests');
    }

    public function search_request_bio (Request $req)
    {
        if(!$req->search){
            return redirect()->action('BioManagerController@requests');
        }
        if(Auth::user()->hasAnyRole('super_admin|admin')){
            $projs = Project::where('url', 'like', '%' . $req->search . '%')->get();
        }else{
            $projs = Auth::user()->projects()->where('url', 'like', '%' . $req->search . '%')->get();
        }
        $bios = array();
        foreach ($projs as $proj) {
            if($proj->bio && $proj->bio->help){
                $bios[] = $proj;
            }
        }

        return view('admin.request_bio_manager', ['projects' => $bios]);
    }
}
