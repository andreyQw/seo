<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Model\Project;
use App\Event;
use App\Feed;
use Carbon\Carbon;

class FeedController extends Controller
{
    public function index ()
    {

        if(Auth::user()->hasAnyRole('client|pm')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)->latest()->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasAnyRole('super_admin|admin')){
            $pid = Project::pluck('id');
            $feed = Feed::whereIn('project_id', $pid)->latest()->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasAnyRole('production|partner')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)
                ->whereIn('event_id', Event::whereIn('type', [
                    'production_doc',
                    'production_topic_approved',
                    'production_content_written',
                    'production_content_edited',
                    'production_content_personalized',
                    'production_live'
                ])->pluck('id'))->latest()->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasRole('writer')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)->where('user_id', Auth::user()->id)->latest()->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();
            // dd($feed);

        }elseif(Auth::user()->hasRole('editor')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)->where('event_id', Auth::user()->id)->latest()->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();
        }

        $tz_this = (new \DateTime('now', new \DateTimeZone((new Carbon('2018-04-20 11:00:03'))->tzName)))->format('P');
        $tz_sydnay = (new \DateTime('now', new \DateTimeZone('Australia/Sydney')))->format('P');

        $dates = [];
        $pid = 0;
        $count = 1;

        foreach ($feed as $f){
            if($pid == 0){
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime())->format('Y-m-d')))
                {
                    $dates['Today'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d')))
                {
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }

            if($pid != $f->project->id){
                $count += 1;
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime())->format('Y-m-d'))){
                    $dates['Today'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }else{
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime())->format('Y-m-d'))){
                    $dates['Today'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }

        }

        return view('feed.news_feed', ['dates' => $dates, 'count_feed' => $feed_count, 'tz' => (int)$tz_sydnay - (int)$tz_this]);
    }

    public function load(Request $req)
    {
        if(Auth::user()->hasAnyRole('client|pm')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)->latest()->skip($req->offset)->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasAnyRole('super_admin|admin')){
            $pid = Project::pluck('id');
            $feed = Feed::whereIn('project_id', $pid)->latest()->skip($req->offset)->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasAnyRole('production|partner')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)
                ->whereIn('event_id', Event::whereIn('type', [
                    'production_doc',
                    'production_topic_approved',
                    'production_content_written',
                    'production_content_edited',
                    'production_content_personalized',
                    'production_live'])->pluck('id'))
                ->latest()->skip($req->offset)->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasAnyRole('writer')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)
                ->whereIn('event_id', Event::whereIn('type', ['production_content_written'])->pluck('id'))
                ->latest()->skip($req->offset)->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();

        }elseif(Auth::user()->hasAnyRole('editor')){
            $pid = Auth::user()->projects()->pluck('id');
            $feed = Feed::whereIn('project_id', $pid)
                ->whereIn('event_id', Event::whereIn('type', ['production_content_edited'])->pluck('id'))
                ->latest()->skip($req->offset)->take(20)->get();
            $feed_count = Feed::whereIn('project_id', $pid)->count();
        }

        $last_date = (new \DateTime(strtolower($req->date)))->format('Y-m-d');

        $dates = [];
        $pid = $req->pid;
        $count = ($req->count%2 == 0) ? 2 : 1;

        foreach ($feed as $f){

            if($pid != $f->project->id){
                $count += 1;
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime($last_date)){
                    $dates['continue'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }else{
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime($last_date)){
                    $dates['continue'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }

        }

        $tz_this = (new \DateTime('now', new \DateTimeZone((new Carbon('2018-04-20 11:00:03'))->tzName)))->format('P');
        $tz_sydnay = (new \DateTime('now', new \DateTimeZone('Australia/Sydney')))->format('P');

        return response()->view('feed.load_feed', ['dates' => $dates, 'tz' => (int)$tz_sydnay - (int)$tz_this]);

    }
}
