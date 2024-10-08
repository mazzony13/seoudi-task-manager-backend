<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Interfaces\UserRepositoryInterface; // get product repository

class ShowController extends Controller
{

     //initiate product repository
     public function __construct(UserRepositoryInterface $productRepository)
     {
         $this->productRepository = $productRepository;
     }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($uuid)
    {
        try{
            $product  = $this->productRepository->get($uuid); // get returned product from repository

            if(!$product)
                return response()->json([
                    'message' => 'User Not Found'
                ], 404);

            return response()->json([
                'data' =>new UserResource($product),

            ]);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Retrieving product'
            ], 500);
        }
    }
}
