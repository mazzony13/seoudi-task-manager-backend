<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Interfaces\UserRepositoryInterface; // get user repository
use Illuminate\Http\Request;

class UpdateController extends Controller
{

    //initiate user repository
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request , $uuid)
    {
        //apply validation roles with uuid for update
        $rules  = (new UserRequest)->rules($uuid);
        $validatedData = $request->validate($rules);

        try{
            $user  = $this->userRepository->update($uuid,$validatedData); // get returned user from repository

            if(!$user)
                return response()->json([
                    'message' => 'User Not Found'
                ], 404);

            return response()->json([
                'message'       => 'User Updated successfully',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Occured on updating user'
            ], 500);
        }
    }
}
