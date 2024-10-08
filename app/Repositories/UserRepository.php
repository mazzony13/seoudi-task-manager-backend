<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function list($data)
    {
        $query = User::where('id','<>',auth()->user()->id);
        if(isset($data['search']))
        $query->when($data['search'], function ($q) use($data) {
            return $q->where('name', 'Like', '%'.$data['search'].'%')->orWhere('email', 'Like', '%'.$data['search'].'%');
        });
        if(auth()->user()->hasRole('user'))
        {
            $query->role('user');
        }

        return  $query->paginate($data['per_page'] ?? 10);
    }

    public function get(string $uuid)
    {
        return User::where('uuid',$uuid)->first() ?? null;
    }

    public function delete(string $uuid)
    {
        $user = User::where('uuid',$uuid)->first();
        if(!$user)
            return false;

         if(auth()->user()->hasRole('super-admin') && $user->hasRole('super-admin'))
         {
             $admins = User::role('super-admin')->count();

             if($admins ==1)
                 return 'last-admin';
         }
       $user->delete();
       return true;
    }

    public function create(array $data)
    {
        $user = User::create($data);
        $user->syncRoles($data['role']);
        return $user;
    }

    public function update(string $uuid, array $data)
    {
        $user = User::where('uuid',$uuid)->first();

        if(!$user)
            return false;

        return $user->update($data);
    }

}
