<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        try{
            $user  = User::create($request->all());
            $user->syncRoles('user');
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message'       => 'You had been registered successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Occured on register please try again'
            ], 500);
        }
    }

}
