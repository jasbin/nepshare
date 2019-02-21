<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;

class PagesController extends Controller
{
    public function index(){
        $posts = Posts::orderBy('created_at',  'desc')->paginate(3);  //note if paginate(3) then paginate appears after post is >3
        return view('pages.home')->with('posts',$posts);
        // return view('pages.home')->with('title', $title);

    }

    public function about(){
        $title = "ABOUT";
        return view('pages.about')->with('title', $title);
    }

    public function services(){
        $data = array(
            'title' => "SERVICES",
            'services' =>['WEB DESIGN','MOBILE APP', 'DESKTOP APP'],
            'categories' =>[
                'a'=>'category a',
                'b'=>'category b'
            ]
        );
        return view('pages.services')->with($data);
    }
}
