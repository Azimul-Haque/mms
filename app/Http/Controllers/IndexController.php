<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

use Carbon\Carbon;

use DB, Hash, Auth, Image, File, Session, Artisan;
use Purifier;

class IndexController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest')->only('getLogin');
        // $this->middleware('auth')->only('getProfile');
    }

    public function index()
    {
        return view('index.index');
    }

    public function homeAdhoc()
    {
        return redirect()->route('dashboard.index');
    }

    public function getAbout()
    {
        return view('index.about');
    }

    public function getContact()
    {
        return view('index.contact');
    }

    // public function getExpertise($slug)
    // {
    //     $expertise = Expertise::where('slug', $slug)->first();
    //     return view('index.singleexpertise')->withExpertise($expertise);
    // }

    // public function getDirectors()
    // {
    //     $people = User::where('type', 'Director')
    //                      ->where('activation_status', 1)->get();
    //     return view('index.people')->withPeople($people);
    // }

    // public function getAdvisors()
    // {
    //     $people = User::where('type', 'Advisor')
    //                      ->where('activation_status', 1)->get();
    //     return view('index.people')->withPeople($people);
    // }

    // public function getEmployees()
    // {
    //     $people = User::where('type', 'Employee')
    //                      ->where('activation_status', 1)->get();
    //     return view('index.people')->withPeople($people);
    // }

    // public function getMembers()
    // {
    //     $people = User::where('type', 'Member')
    //                      ->where('activation_status', 1)->get();
    //     return view('index.people')->withPeople($people);
    // }

    // public function getProjects()
    // {
    //     $projects = Project::orderBy('id', 'desc')->get();
    //     return view('index.projects')->withProjects($projects);
    // }

    // public function getProject($slug)
    // {
    //     $project = Project::where('slug', $slug)->first();
    //     $randomprojects = Project::inRandomOrder()->get()->take(7);
    //     return view('index.singleproject')
    //                         ->withProject($project)
    //                         ->withProjects($randomprojects);
    // }


    public function storeFormMessage(Request $request)
    {
        // $this->validate($request,array(
        //     'name'                      => 'required|max:255',
        //     'email'                     => 'required|max:255',
        //     'message'                   => 'required',
        //     'contact_sum_result_hidden'   => 'required',
        //     'contact_sum_result'   => 'required'
        // ));

        // if($request->contact_sum_result_hidden == $request->contact_sum_result) {
        //     $message = new Formmessage;
        //     $message->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        //     $message->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        //     $message->message = htmlspecialchars(preg_replace("/\s+/", " ", $request->message));
        //     $message->save();
            
        //     Session::flash('success', 'আপনার বার্তা আমাদের কাছে পৌঁছেছে। ধন্যবাদ!');
        //     return redirect()->route('index.contact');
        // } else {
        //     return redirect()->route('index.contact')->with('warning', 'যোগফল ভুল হয়েছে! আবার চেষ্টা করুন।')->withInput();
        // }
    }

    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        Artisan::call('route:cache');
        Artisan::call('config:cache');
        Session::flush();
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
