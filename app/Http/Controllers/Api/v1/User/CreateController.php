<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Interfaces\UserRepositoryInterface;

class CreateController extends Controller
{

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
    public function __invoke(UserRequest $request)
    {
        try{
            $user  = $this->userRepository->create($request->all());
            return response()->json([
                'message'       => 'User Created successfully',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Occured on creating user'
            ], 500);
        }
    }
}
