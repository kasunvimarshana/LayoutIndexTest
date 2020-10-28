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

use App\User as User;
use App\Role as Role;
use App\Enums\RoleEnum as RoleEnum;

class UserController extends Controller
{
    //
    public function create(){
        $data = array();
        $users = User::with(['role'])->get();
        $roles = Role::get();
        
        if(view()->exists('user_create')){
            return view('user_create', ['users' => $users, 'roles' => $roles]);
        }
    }
    
    public function store(Request $request){
        //
        $dataArray = array();
        
        $rules = array(
            'name'    => 'required',
            'email'    => 'required|unique:users,email',
            'password' => 'required|min:3',
            'role_id' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput( $request->except(['password']) )
                ->with('error','Error!');
        } else {
            try {
                DB::beginTransaction();
                
                $dataArray = array(
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make( $request->input('password') ),
                    'role_id' => $request->input('role_id')
                );

                $userObject = User::create( $dataArray );
                unset($dataArray);
                
                DB::commit();
            }catch(Exception $e){
                DB::rollback(); 
                return redirect()
                    ->back()
                    ->withInput( $request->except(['password']) )
                    ->with('error','Error!');
            }
        }
        
        return redirect()->back()->with('success','Success!');
    }
    
    public function edit(Request $request){
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
        
        $user_id = $request->input('id');
        $user = User::find( $user_id );
        
        $roles = Role::get();
        return view('user_edit', ['user' => $user, 'roles' => $roles]);
    }
    
    public function update(Request $request){
        //
        $dataArray = array();
        
        $rules = array(
            'id'    => 'required',
            'name'    => 'required',
            'email'    => 'required',
            'role_id' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput( $request->except(['password']) )
                ->with('error','Error!');
        } else {
            try {
                DB::beginTransaction();
                
                $dataArray = array(
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'role_id' => $request->input('role_id')
                );
                if( ($request->has('password')) && ($request->filled('password')) ){
                    $dataArray['password'] = Hash::make( $request->input('password') );
                }
                $user_id = $request->input('id');
                $userObject = User::find( $user_id );
                $userObject = $userObject->update( $dataArray );
                unset($dataArray);
                
                DB::commit();
            }catch(Exception $e){
                DB::rollback(); 
                return redirect()
                    ->back()
                    ->withInput( $request->except(['password']) )
                    ->with('error','Error!');
            }
        }
        
        return redirect()->back()->with('success','Success!');
    }

    public function destroy(Request $request){
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

            $user_id = $request->input('id');
            User::destroy( $user_id );

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
    
    public function checkValidUser(Request $request){
        //
        $data = array();
        $userObject = new User();
        $isValidUser = false;
        if ( ($request->has('email')) && ($request->filled('email')) ) {
            $email = $request->input('email');
            $userObject = $userObject->where('email', '=', $email)->first();
        }
        if( ($userObject) && ($userObject->id) ){
            $isValidUser = true;
        }
        $data['isValidUser'] = $isValidUser;
        return Response::json( $data );
    }
}