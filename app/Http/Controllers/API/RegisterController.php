<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\UserVerify;
use App\Models\CountryCode; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Socialite;
use Google_Client;
use Google_Service_People;

class RegisterController extends Controller
{

    // to register new user

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'status' => 'required|in:Mrs,Ms,Mr',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'c_password' => 'required|same:password',
            'country_code' => 'required',
            'contact_no' => 'required|digits:10',
            'birth_date' => 'required|numeric|min:1|max:31',
            'birth_month' => 'required|numeric|min:1|max:12',
            'birth_year' => 'required|digits:4',
            'terms' => 'required|integer',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $input = $request->all(); 
   
        $user = $this->create($input); 

        $verification_token = Str::random(64);
          
                UserVerify::create([
                      'user_id' => $user->id, 
                      'token' => $verification_token
                    ]);
          
                Mail::send('emails.emailVerificationEmail', ['token' => $verification_token], function($message) use($request){
                      $message->to($request->email);
                      $message->subject('Email Verification Mail');
                  });

        $token = $user->createToken('MyApp')->accessToken;
        Auth::login($user);
        return response()->json(["success" => true, "message" => 'Registered Successfully.' ,"data"=> $user, "token" => $token], 200);
    }

    // login Api

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
               'email' => 'required|string|email|max:255|exists:users',
               'password' => 'required',
           ]);
       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 403);
       }
       $user = User::where('email', $request->email)->first();
       if ($user) 
       {
        //$user = $user->where('email_verified_at','!=',Null)->first();
            if($user)
            {    
               if (Hash::check($request->password, $user->password)) 
               {
                   $token = $user->createToken('MyApp')->accessToken;
                   Auth::login($user);
                   $nuser = User::where('email',$request->email)->first();
                   return response()->json(["success" => true, "message" => 'Login Successfully.' ,"data"=> $nuser, "token" => $token], 200);
               } else 
               {
                   $response = ["message" => "Password mismatch"];
                   return response($response, 401);
               }
            }else
            {
                $response = ["message" =>'Email verification is pending.'];
                return response($response, 401);
            }
        } else 
        {
           $response = ["message" =>'User does not exist'];
           return response($response, 202);
        }
    }

    // insert data in user table for register

    protected function create(array $data)
    {
        $birth = $data['birth_date'].'-'.$data['birth_month'].'-'.$data['birth_year'];
        $date_timestamp = strtotime($birth);
        $birth_date = date('Y-m-d', $date_timestamp); 

        return User::create([
            'name' => $data['first_name'].' '. $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'country_code' => $data['country_code'],
            'contact_no' => $data['contact_no'],
            'birth_date' => $birth_date,
            'status' => $data['status'],
            'terms' => $data['terms'],
            'password' => Hash::make($data['password']),
            'image' => 'public/images/user-avtar.png',
            'type'=>'2',

        ]);
    }

    //  

    protected function sendResetLinkResponse(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) 
        {
            return response(['errors'=>$validator->errors()->all()], 403);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT)
        {
            $message = "Mail send successfully";
        }else
        {
            $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data'=>'','message' => $message];
        return response($response, 200);
    }

    //  

    protected function sendResetResponse(Request $request)
    {
    //password.reset
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) 
        {
            return response(['errors'=>$validator->errors()->all()], 403);
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
            'password' => Hash::make($password)
            ])->save();
            //$user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        });
        if($response == Password::PASSWORD_RESET)
        {
            $message = "Password reset successfully";
        }else
        {
            $message = "Email could not be sent to this email address";
        }
        $response = ['data'=>'','message' => $message];
        return response()->json($response);
    }

    // 

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // 

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        return $user->token;
    }

    // to get the country code
    
    public function getCountryCode()
    {
        $CountryCode = CountryCode::all();
        $data=[];
        if($CountryCode)
        {    
            foreach($CountryCode as $k=>$country)
            {
                $data[$k]['id'] = $country->id;
                $data[$k]['name'] = $country->name;
                $data[$k]['country_code'] = $country->country_code;
                $data[$k]['code'] = $country->code;
            }
            return response()->json(["success" => true, "message" => 'Country Code List.' ,"data"=> $data], 200);
        }
        return response()->json(['success' => false, 'message' => 'No Data'], 202)->header('status', 202);
    }

     public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
  
      return redirect()->route('/crm')->with('message', $message);
    }
}
