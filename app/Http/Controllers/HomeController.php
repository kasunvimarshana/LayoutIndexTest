<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session as Session;
use DB;
use \Exception;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Post as Post;
use App\Tag as Tag;

class HomeController extends Controller
{
    //
    public function index(Request $request){
        $data = array();
        $current_user = auth()->user();
        $date_today = Carbon::now()->format('Y-m-d');
        $posts = Post::with(['user', 'tags', 'postTags']);
        if( ($request->has('title')) && ($request->filled('title')) ){
            $title = $request->input('title');
            $posts = $posts->where('title', 'like', '%' . $title . '%');
        }
        if( ($request->has('description')) && ($request->filled('description')) ){
            $description = $request->input('description');
            $posts = $posts->where('description', 'like', '%' . $description . '%');
        }
        if( ($request->has('tag_id')) && ($request->filled('tag_id')) ){
            $tags = $request->input('tag_id');
            $tags = (explode(",", $tags));
            $dataArray = array();
            foreach($tags as $k => $v){
                $v = trim( $v );
                $posts = $posts->whereHas('tags', function($query) use ($v){
                    $query->where('name', 'like', '%' . $v . '%');
                });
            }
        }
        
        $posts = $posts->get();
        if(view()->exists('home')){
            return view('home', ['posts' => $posts]);
        }
    }
}
