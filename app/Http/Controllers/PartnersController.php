<?php

namespace App\Http\Controllers;

use App\Bsi;
use App\Niche;
use Illuminate\Http\Request;
use App\Partner;

class PartnersController extends Controller
{
    public function index (Request $req)
    {
        return view('admin.partner_manager', ['niches' => Niche::all(), 'bsi' => Bsi::all(), 'partners' => Partner::all()]);
    }

    public function add(Request $req)
    {
        $this->validate($req, [
            'domain' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'dr' => 'required|integer|max:9999999999',
            'tf' => 'required|integer|max:9999999999',
            'cf' => 'required|integer|max:9999999999',
            'da' => 'required|integer|max:9999999999',
            'traffic' => 'required|integer|max:9999999999',
            'ref_domains' => 'required|integer|max:9999999999',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'company_name' => 'required|string|max:255',
            'paypal_id' => 'required|string|max:255'
        ]);

        if(!empty($req->file('photo'))){
            $filename = strtotime((new \DateTime('now'))->format('Y/m/d H:i:s')) . "_" . $req->first_name . "_" . $req->last_name . ".png";
            $req->file('photo')->move('storage/photo_partners', $filename);
        }else{
            $filename = 'user_anonim.png';
        }

        if(!$req->no_mo){
            $req->no_mo = 0;
        }

        $partner = new Partner();
        $partner->domain = $req->domain;
        $partner->cost = $req->cost;
        $partner->month_placements = $req->no_mo;
        $partner->description = $req->description;
        $partner->dr = $req->dr;
        $partner->tf = $req->tf;
        $partner->cf = $req->cf;
        $partner->da = $req->da;
        $partner->traffic = $req->traffic;
        $partner->ref_domains = $req->ref_domains;
        $partner->first_name = ucfirst($req->first_name);
        $partner->last_name = ucfirst($req->last_name);
        $partner->company_name = $req->company_name;
        $partner->email = $req->email;
        $partner->paypal_id = $req->paypal_id;
        $partner->photo = $filename;
        $partner->bsi()->associate(Bsi::find($req->bsi));
        $partner->niche()->associate(Niche::find($req->niche));
        $partner->save();

        return redirect()->action('PartnersController@index');
    }

    public function delete(Request $req)
    {
        if(!$req->id){
            return response()->json(['error']);
        }

        Partner::find($req->id)->delete();

        return response()->json(['success']);
    }

    public function search(Request $req)
    {
        if($req->search){
            $partner = Partner::where('domain', 'like', '%' . $req->search . '%');
        }else{
            $partner = Partner::query();
        }

        if($req->bsi){
            $partner->where('bsi_id', $req->bsi);
        }

        if($req->price){
            $range_price = explode('-', $req->price);
            if(count($range_price) > 1){
                $partner->whereBetween('cost', $range_price);
            }else{
                $partner->where('cost', '>=', $range_price[0]);
            }
        }

        if($req->dr){
            $partner->where('dr', $req->dr);
        }

        if($req->tf){
            $partner->where('tf', $req->tf);
        }

        if($req->cf){
            $partner->where('cf', $req->cf);
        }

        if($req->da){
            $partner->where('da', $req->da);
        }

        if($req->traffic){
            $partner->where('traffic', $req->traffic);
        }

        if($req->ref_domains){
            $partner->where('ref_domains', $req->ref_domains);
        }

        if($req->niche){
            $partner->where('niche_id', $req->niche);
        }

        $partners = $partner->get();

        return view('admin.partner_manager', ['niches' => Niche::all(), 'bsi' => Bsi::all(), 'partners' => $partners]);
    }

    public function edit(Request $req)
    {
        $partner = Partner::find($req->id);

        foreach ($req->all() as $key => $val){

            if($key == '_token' || $key == 'id'){
                continue;
            }

            if($key == 'month_placements' && !$val){
                $val = 0;
            }

            if($key == 'niche'){
                $partner->niche()->dissociate();
                $partner->niche()->associate(Niche::find($val));
                continue;
            }elseif($key == 'bsi'){
                $partner->$key()->associate(Bsi::find($val));
                continue;
            }elseif($key == 'photo'){
                if(!empty($req->file('photo'))){
                    $filename = strtotime((new \DateTime('now'))->format('Y/m/d H:i:s')) . "_" . $partner->first_name . "_" . $partner->last_name . ".png";
                    $req->file('photo')->move('storage/photo_partners', $filename);
                    $partner->photo = $filename;
                    continue;
                }
                continue;
            }else{
                $partner->$key = $val;
                continue;
            }

        }

        $partner->save();

        return redirect()->route('partners');
    }
}
