<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

Class UserAuthController extends Controller{
    public $success_status=200;

    public function login(){
       $email=request('email');
       $password= request('password');
       $role= request('role');

       $credentials = [
        'email' => $email,
        'password' => $password,
        'role_id' => $role
        ];


        if(Auth::attempt($credentials)){ 
            $user= Auth::user();
            return response()->json([
                'success'=>1,
                'message'=>'Login Successfully',
                'success_code'=>$this->success_status,
                'data'=>[
                    'token'=>$user->createToken('App')->accessToken,
                    'id'=>$user->id,
                    'name'=>$user->username,
                    'email'=>$user->email,
                    'role_id'=>$user->role_id
                ],
            ]);
        }
        else{
            return response()->json([
                'success'=>0,
                'message'=>'Invalid Login Credentials',
                'success_code'=>401, 
                'data'=>[],
                ]);
        }
        
        
    }

    public function tutor_signup(){
        $firstname= request('firstname');
        $lastname= request('lastname');
        $email=request('email');
        $password= request('password');
        $role= 2; //Role 2 means, this is tutor.

        if($firstname!='' && $lastname!='' && $email!='' && $password!='' && $role!=''){
            if(User::where('email', $email)->where('role_id', $role)->exists()){
                return response()->json([
                    'success'=>0,
                    'message'=>'User is already exist in our system, Please try different Email Address',
                    'success_code'=>409, //Use For Conflicts
                    'data'=>[],
                ]);
            }
            else{
                $user_details=array(
                    'role_id'=>$role,
                    'firstname'=>$firstname,
                    'lastname'=>$lastname,
                    'email'=>$email,
                    'password'=>bcrypt($password)
                );
                $recently_created=User::create($user_details);
                $username=$firstname.$lastname.$recently_created->id;

                User::where('id', $recently_created->id)->update(['username'=>$username]);

                return response()->json([
                    'success'=>1,
                    'message'=>'Account has been created succesfully',
                    'success_code'=>$this->success_status, //Use for Not Acceptable Data
                    'data'=>[],
                ]);
            }
        }
        else{
            return response()->json([
                'success'=>0,
                'message'=>'Please fill up all the details',
                'success_code'=>406, //Use for Not Acceptable Data
                'data'=>[],
                ]);
        }
    }
}