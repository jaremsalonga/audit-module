<?php

namespace App\Services;

use App\Events\AuditLogEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService {

     /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {}

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $userStore = $this->store($request);

        $response = response()->json(['data' => []], 201);

        event(new AuditLogEvent($userStore, $response));   

        return $response; 
    }


    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response($user);
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {

            $user = User::where('email', $request->email)->first();

            $response = response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

            event(new AuditLogEvent(Auth::user()->toArray(), $response));   

            return $response;
        }
    }   
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully',
        ], 200);
    }    
}