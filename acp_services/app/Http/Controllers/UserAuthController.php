<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Mail;


Class UserAuthController extends Controller{
    public $success_status=200;
    public $base_app_url="http://localhost:3000";

    public function login(){
       $email=request('email');
       $password= request('password');
       $role= request('role_id');

       $credentials = [
        'email' => $email,
        'password' => $password,
        'role_id' => $role,
        ];


        if(Auth::attempt($credentials)){


            $user= Auth::user();
            if($user->is_active==1){
                return response()->json([
                    'status'=>1,
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
                    'status'=>0,
                    'message'=>'Account is not active',
                    'success_code'=>403,
                        'data'=>[
                            'id'=>$user->id,
                        ],
                ]);
            }
        }
        else{
            return response()->json([
                'status'=>0,
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
                    'status'=>0,
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
                    'password'=>bcrypt($password),
                    'is_active'=>0
                );
                $recently_created=User::create($user_details);
                $username=$firstname.$lastname.($recently_created->id+1000);
                User::where('id', $recently_created->id)->update(['username'=>$username]);

                return response()->json([
                    'status'=>1,
                    'message'=>'Account has been created succesfully',
                    'success_code'=>$this->success_status, //Use for Not Acceptable Data
                    'data'=>[
                        'id'=>$recently_created->id
                    ],
                ]);
            }
        }
        else{
            return response()->json([
                'status'=>0,
                'message'=>'Please fill up all the details',
                'success_code'=>406, //Use for Not Acceptable Data
                'data'=>[],
                ]);
        }
    }

    public function user_email_validation(){
        $email= request('email');
        $role= request('role_id');
        if(User::where('email', $email)->where('role_id', $role)->exists()){
                return response()->json([
                    'status'=>0,
                    'message'=>'User is already exist in our system, Please try different Email Address',
                    'success_code'=>409, //Use For Conflicts
                    'data'=>[],
                ]);
            }
            else{
                return response()->json([
                    'status'=>1,
                    'message'=>'Correct Email Address',
                    'success_code'=>$this->success_status, //Use for Not Acceptable Data
                    'data'=>[],
                ]);
            }
    }


    public function email_verification(){
        $user_id= request('user_id');
        $from_email_url= request('from_email_hit');  //acp101110
        $verification_code= request('verification_code');


        if($user_id!=""){


            $user_data=User::where('id', $user_id)->get()->toArray();
            if($user_data!=null){
                $email=$user_data[0]['email'];

                //User Hits from the email
                if($from_email_url=="acp101110"){
                    if($user_data[0]['verification_code']!=null && $user_data[0]['is_active']==0){
                        
                        if($user_data[0]['verification_code']==$verification_code){
                            //update to active
                            User::where('id', $user_id)->update(['is_active'=>1]);

                            $response_data=array(
                                'status'=>1,
                                'message'=>"Successfully Activated!",
                                'success_code'=>200,
                                'data'=>[
                                    'status'=>'true',
                                    'email'=>$email
                                ]
                            );
                        return response()->json($response_data);
                        //will show already activated screen status=true
                        }
                        else{
                            $response_data=array(
                            'status'=>0,
                            'message'=>"Activation Link has been Expired!",
                            'success_code'=>409,
                                'data'=>[
                                    'status'=>'false',
                                    'email'=>$email
                                ]
                            );
                            return response()->json($response_data);
                        }
                    }
                    else if($user_data[0]['verification_code']!=null && $user_data[0]['is_active']==1){
                        $response_data=array(
                            'status'=>0,
                            'message'=>"Already Activated!",
                            'success_code'=>409,
                            'data'=>[
                                'status'=>'activated',
                                'email'=>$email
                            ]
                        );
                        return response()->json($response_data);
                    }
                }
                // If user Redirects to the verfication page from website
                else{
                    if($user_data[0]['verification_code']!=null && $user_data[0]['is_active']==1){

                        $response_data=array(
                            'status'=>0,
                            'message'=>"Already Activated!",
                            'success_code'=>409,
                            'data'=>[
                                'status'=>'activated',
                                'email'=>$email
                            ]
                        );
                        return response()->json($response_data);
                    }
                    else if($user_data[0]['verification_code']!=null && $user_data[0]['is_active']==0){
                        $verification_code=rand(100000, 999999);
                        User::where('id', $user_id)->update(['verification_code'=>$verification_code]);

                        $this->send_verification_email($user_id, $email, $verification_code);

                        $response_data=array(
                            'status'=>0,
                            'message'=>"We have sent the email to your address!",
                            'success_code'=>409,
                            'data'=>[
                                'status'=>'pending',
                                'email'=>$email
                            ]
                        );
                        return response()->json($response_data);
                    }
                    else if($user_data[0]['verification_code']==null && $user_data[0]['is_active']==0){
                        $verification_code=rand(100000, 999999);
                        User::where('id', $user_id)->update(['verification_code'=>$verification_code]);
                        $this->send_verification_email($user_id, $email, $verification_code);

                        $response_data=array(
                            'status'=>0,
                            'message'=>"We have sent the email to your address!",
                            'success_code'=>409,
                            'data'=>[
                                'status'=>'pending',
                                'email'=>$email
                            ]
                        );
                        return response()->json($response_data);
                    }
                }
            }
            else{
                $response_data=array(
                        'status'=>0,
                        'message'=>"Invalid Account!",
                        'success_code'=>409,
                        'data'=>[
                            'status'=>'invalid',
                        ]
                    );
                    return response()->json($response_data);
            }
            
        }
    }


    public function resend_code(){
        $user_id= request('user_id');

        $user_data=User::where('id', $user_id)->get();

        if($user_data!=""){
            $email= $user_data[0]['email'];
            $code= $user_data[0]['verification_code'];

            $this->send_verification_email($user_id, $email, $code);

            $response_data=array(
                        'status'=>1,
                        'message'=>"Verfication Code has been Sent!",
                        'success_code'=>200,
                        'data'=>[
                            'email'=>$email
                        ]
                    );
            return response()->json($response_data);
        }
    }


    public function send_verification_email($user_id, $email_address, $verification_code){
        $data=array(
            'verification_code'=>$verification_code,
            'email'=>$email_address,
            'user_id'=>$user_id,
            'url_redirection'=>$this->base_app_url.'/verify/'.$user_id.'/acp101110/'.$verification_code
        );
        Mail::send(["html"=>"EmailVerification"],["data"=>$data],function($message) use ($data){
            $message->to([$data['email']])->subject("ACP Verification Code");
            $message->from("acp@academicproviders.com","Academic Prodivers");
        });
    }
}