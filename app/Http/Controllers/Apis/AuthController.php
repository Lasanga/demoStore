<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Method to Register an user
     */
    public function register(Request $request)
    {
        //Validation 
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        //Bind values to the object
        $user = User::firstOrNew(['email' => $request->email]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        //Register user
        $user->save();

        //Get auth token
        //$response = $this->getAuthToken($request->email, $request->password);

        //Return access token
        //return response(['auth' => json_decode((string)$response->getBody(), true), 'user' => $user]);
    }

    /**
     * Method to Login an user
     */
    public function login(Request $request)
    {
        //Validation 
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        //Get existing user
        $user = User::where('email', $request->email)->first();

        //User validation
        if ($user != null) {
            //Password validation
            if (Hash::check($request->password, $user->password)) {
                $response = $this->getAuthToken($request->email, $request->password);
            } else {
                return response(['status' => 'error', 'message' => 'Password not matched']);
            }
        } else {
            return response(['status' => 'error', 'message' => 'User not found']);
        }

        //Return access token
        return response(['auth' => json_decode((string)$response->getBody(), true), 'user' => $user]);
    }

    /**
     * Common method to get auth token
     */
    private function getAuthToken($email, $password)
    {
        //Instantiate GuzzleHttpClient
        $http = new Client;

        //Get tokens
        $response = $http->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'XDIKWkKlSdAzcUXJhppgYWBgCmjL7KU3cwjx2Y9R',
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ],
        ]);

        return $response;
    }
}
