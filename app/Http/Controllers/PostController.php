<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session as Session;
use DB;
use \Exception;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Post as Post;
use App\Tag as Tag;
use App\User as User;
use App\Enums\RoleEnum as RoleEnum;

class PostController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function create(Request $request)
    {
        //
        $data = array();
        $current_user = auth()->user();
        $date_today = Carbon::now()->format('Y-m-d');
        
        $posts = Post::with(['user', 'tags', 'postTags'])->where('user_id', '=', $current_user->id);
        $posts = $posts->get();
        
        if(view()->exists('post_create')){
            return view('post_create', ['posts' => $posts]);
        }
    }

    public function store(Request $request)
    {
        //
        $dataArray = array();
        $current_user = auth()->user();
        $date_today = Carbon::now()->format('Y-m-d');
        
        $rules = array(
            'title'    => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput()
                ->with('error','Error!');
        } else {
            try {
                DB::beginTransaction();
                
                $dataArray = array(
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'time_create' => $date_today,
                    'user_id' => $current_user->id
                );

                $postObject = Post::create( $dataArray );
                unset($dataArray);
                
                if( ($request->has('tag_id')) && ($request->filled('tag_id')) ){
                    $tags = $request->input('tag_id');
                    $tags = (explode(",", $tags));
                    $dataArray = array();
                    foreach($tags as $k => $v){
                        $v = trim( $v );
                        $tag = Tag::firstOrCreate([
                            'name' => $v,
                        ]);
                        array_push($dataArray, $tag->id);
                        //$postObject->tags()->attach([ $tag->id ]);
                    }
                    $postObject->tags()->sync( $dataArray );
                }
                
                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error','Error!');
            }
        }
        
        return redirect()->back()->with('success','Success!');
    }

    public function show(Request $request)
    {
        //
    }

    public function edit(Request $request)
    {
        //
        $current_user = auth()->user();
        $data = array();
        
        $rules = array(
            'id'    => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput()
                ->with('error','Error!');
        }
        
        $post_id = $request->input('id');
        $post = Post::find( $post_id );
        $post->load(['user', 'tags', 'postTags']);
        
        return view('post_edit', ['post' => $post]);
    }

    public function update(Request $request)
    {
        //
        $dataArray = array();
        $current_user = auth()->user();
        $date_today = Carbon::now()->format('Y-m-d');
        
        $rules = array(
            'title'    => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput()
                ->with('error','Error!');
        } else {
            try {
                DB::beginTransaction();
                
                $dataArray = array(
                    'title' => $request->input('title'),
                    'description' => $request->input('description')
                );

                $post_id = $request->input('id');
                $postObject = Post::find( $post_id );
                $postObject->update( $dataArray );
                unset($dataArray);
                
                if( ($request->has('tag_id')) && ($request->filled('tag_id')) ){
                    $tags = $request->input('tag_id');
                    $tags = (explode(",", $tags));
                    $dataArray = array();
                    foreach($tags as $k => $v){
                        $v = trim( $v );
                        $tag = Tag::firstOrCreate([
                            'name' => $v,
                        ]);
                        array_push($dataArray, $tag->id);
                        //$postObject->tags()->attach([ $tag->id ]);
                    }
                    $postObject->tags()->sync( $dataArray );
                }
                
                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error','Error!');
            }
        }
        
        return redirect()->back()->with('success','Success!');
    }

    public function destroy(Request $request)
    {
        //
        $current_user = auth()->user();
        $data = array();
        
        $rules = array(
            'id'    => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput()
                ->with('error','Error!');
        }
        
        try {
            DB::beginTransaction();

            $post_id = $request->input('id');
            Post::destroy( $post_id );

            DB::commit();
        }catch(Exception $e){
            DB::rollback(); 
            return redirect()
                ->back()
                ->withInput( $request->except(['password']) )
                ->with('error','Error!');
        }
        
        return redirect()->back()->with('success','Success!');
    }
    
    public function create_admin_dashbord(Request $request){
        //
        $data = array();
        $current_user = auth()->user();
        $date_today = Carbon::now()->format('Y-m-d');
        
        if( $current_user->role_id != RoleEnum::SuperAdmin ){
            return redirect()->back()->with('error','Error!');
        }
        
        $posts = Post::with(['user', 'tags', 'postTags']);
        $posts = $posts->get();
        
        if(view()->exists('post_create')){
            return view('post_create', ['posts' => $posts]);
        }
    }
}
