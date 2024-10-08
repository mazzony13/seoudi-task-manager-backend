<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Interfaces\UserRepositoryInterface; // get user repository
use Illuminate\Http\Request;

class IndexController extends Controller
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
    public function __invoke(Request $request)
    {
        try{
            $users  = $this->userRepository->list($request->all());
            return response()->json([
                'data' => UserResource::collection($users)->response()->getData(),
            ]);
        }catch(\Exception $e){
            return $e;
            return response()->json([
                'message' => 'Error Retrieving users'
            ], 500);
        }

    }
}
