<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Database\Settings;
use App\Database\Archives; 
use App\Database\Notifiers;
use App\Database\Teams;
use App\Database\Concepts;

class PrivCode extends Controller
{	

	public function main(){
        $setting   = Settings::get();
        $notifiers = Notifiers::orderBy('published', 'desc')->offset(0)->limit(10)->get();
        $teams     = Teams::orderBy('published', 'desc')->offset(0)->limit(10)->get();
        $archives  = Archives::where('status', '1')->where('special', '0')->orderBy('datetime', 'desc')->offset(0)->limit(10)->get();
        $specials  = Archives::where('status', '1')->where('special', '1')->orderBy('datetime', 'desc')->offset(0)->limit(10)->get();
        $onholds   = Archives::where('status', '0')->orderBy('datetime', 'desc')->offset(0)->limit(10)->get();

        return view('main', compact('setting', 'archives', 'notifiers', 'teams', 'specials', 'onholds'));
	}

    public function archive(){
        $title = 'Archives';
    	$setting  = Settings::get();
        $archives = Archives::where('status', '1')->where('special', '0')->orderBy('datetime', 'desc')->paginate(30);
        return view('archive', compact('setting', 'archives', 'title'));
    }

    public function special(){
        $title = 'Special Archives';
    	$setting  = Settings::get();
        $archives = Archives::where('status', '1')->where('special', '1')->orderBy('datetime', 'desc')->paginate(30);
        return view('archive', compact('setting', 'archives', 'title'));
    }
    
    public function onhold(){
        $title = 'Onholds';
        $setting  = Settings::get();
        $archives = Archives::where('status', '0')->orderBy('datetime', 'desc')->paginate(30);
        return view('archive', compact('setting', 'archives', 'title'));
    }

    public function attackerRank(){
        $setting  = Settings::get();
        $attackers = Notifiers::orderBy('published', 'desc')->paginate(30);
        $countofattacker = Notifiers::count();
        $countofteam = Teams::count();
        return view('rank.attacker', compact('setting', 'attackers', 'countofattacker', 'countofteam'));
    }

    public function teamRank(){
        $setting  = Settings::get();
        $teams = Teams::orderBy('published', 'desc')->paginate(30);
        $countofteam = Teams::count();
        return view('rank.team', compact('setting', 'teams', 'countofteam'));
    }

    public function notify(){
        $setting  = Settings::get();
        $concepts = Concepts::get();
        return view('notify', compact('setting', 'concepts'));
    }

    public function view($id){
        $id = (int)$id;
        if($id == 0){
            $id = 1;
        }
        $setting  = Settings::get();
        foreach (Archives::where('id', $id)->get() as $archive) {
            $archive;
        }
        return view('view', compact('setting', 'archive', 'id'));
    }

    public function source($id){
        $id = (int)$id;
        
        if($id == 0){
            $id = 1;
        }

        foreach (Archives::select(['content'])->where('id', $id)->get() as $archive) {
            echo $archive->content;
        }
    }

    public function action(Request $request){
        $attacker = trim(strip_tags($request->attacker));
        $team     = trim(strip_tags($request->team));
        $url      = trim(strip_tags($request->url));
        
        if (!preg_match('#^http(s)?://#', $url)) {
            $url = 'http://' . $url;
        }

        // Check XSS, Fake Root
        $arrayDenied = array('/~', '<script>', '<h1>');
        if(inStr($url, $arrayDenied)){
            return response()->json([
                'url' => $url,
                'status' => 'Failed',
                'extra' => 'XSS, Fake Root, Or Fake Subdomain'
            ]);
        }


        $urlParts = parse_url($url);
        $domain   = preg_replace('/^www\./', '', $urlParts['host']);

        $redeface = 0;
        if(Archives::select(['id'])->where('domain', $domain)->count() > 0){
            return response()->json([
                'url' => $url,
                'status' => 'Failed',
                'extra' => 'Added During Last Year'
            ]);
        }


        $response = \Curl::to($url)->withOption('HEADER', true)->get();

        if(!inStr($response, '200 OK')){
            return response()->json([
                'url' => $url,
                'status' => 'Failed',
                'extra' => 'Not Found'
            ]);
        }

        if(inStr($response, $attacker)){
            $status = 1;
        } else {
            if(defaced($response)){
                $status = 0;
            } else {
                return response()->json([
                    'url' => $url,
                    'status' => 'Failed',
                    'extra' => 'Hasn\'t Been Defaced'
                ]);
            }
        }

        // Success
        $wrapper =  fopen('php://temp', 'r+');
        $content =  addslashes(\Curl::to($url)->withOption('VERBOSE', true)->withOption('STDERR', $wrapper)->get());
        $ips = ip($wrapper);
        fclose($wrapper);
        $ip = end($ips);
       
        $ipdetail = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
        
        /*$ipdetail = json_decode(json_encode([
            'geoplugin_countryName' => 'Indonesia',
            'geoplugin_countryCode' => 'ID'
        ]));*/

        
        $mass = 0;
        if(Archives::select(['id'])->where('ip', $ip)->count() > 0){
            $mass = 1;
        }
        $home    = (home(parse_url($url, PHP_URL_PATH))) ? 1 : 0;
        $special = important($domain) ? 1 : 0;
        
        $tbnotifier = Notifiers::where('notifier', $attacker)->limit(1)->get();
        if($tbnotifier->count() == 0) {
            $notifiers            = new Notifiers;
            $notifiers->id        = NULL;
            $notifiers->notifier  = $attacker;
            $notifiers->team      = $team;
            $notifiers->home      = $home; 
            $notifiers->special   = $special;
            $notifiers->mass      = $mass;
            $notifiers->published = $status;
            $notifiers->total     = 1;
            $notifiers->save();
        } else {
            Notifiers::where('notifier', $attacker)->update([
                'team'      => $team,
                'home'      => $tbnotifier[0]->home + $home,
                'special'   => $tbnotifier[0]->special + $special,
                'mass'      => $tbnotifier[0]->mass + $mass,
                'published' => $tbnotifier[0]->published + $status,
                'total'     => $tbnotifier[0]->total + 1
            ]);
        }

        $tbteam = Teams::where('team', $team)->limit(1)->get();
        if($tbteam->count() == 0) {
            $teams            = new Teams;
            $teams->id        = NULL;
            $teams->team      = $team;
            $teams->home      = $home; 
            $teams->special   = $special;
            $teams->mass      = $mass;
            $teams->published = $status;
            $teams->total     = 1;
            $teams->save();
        } else {
            Teams::where('team', $team)->update([
                'home'      => $tbteam[0]->home + $home,
                'special'   => $tbteam[0]->special + $special,
                'mass'      => $tbteam[0]->mass + $mass,
                'published' => $tbteam[0]->published + $status,
                'total'     => $tbteam[0]->total + 1
            ]);
        }

        $os = array(
            'Linux',
            'Windows'
        );

        $archive                = new Archives;
        $archive->id            = NULL;
        $archive->notifier      = $attacker; 
        $archive->team          = $team; 
        $archive->url           = $url;
        $archive->domain        = $domain;
        $archive->ip            = $ip;
        $archive->concept       = $request->poc; 
        $archive->technology    = json_encode([
                                    'os'     => $os[array_rand($os)], 
                                    'server' => server($response)
                                  ]);
        $archive->geolocation   = json_encode([
                                        'country' => ($ipdetail->geoplugin_countryName) ? $ipdetail->geoplugin_countryName : 'Unknown', 
                                        'code'    => ($ipdetail->geoplugin_countryCode) ? $ipdetail->geoplugin_countryCode : 'Unknown'
                                  ]); 
        $archive->content  = $content;
        $archive->home     = (string)$home;
        $archive->special  = (string)$special;
        $archive->mass     = (string)$mass;
        $archive->redeface = (string)$redeface; 
        $archive->status   = (string)$status; 
        $archive->datetime = \Carbon\Carbon::now(); 
        if($archive->save()) {
            return response()->json([
                'url' => $url,
                'status' => 'Success',
                'extra' => ''
            ]);
        } else {
            return response()->json([
                'url' => $url,
                'status' => 'Failed',
                'extra' => 'Please Contact Administrator'
            ]);
        }
        
    }

}