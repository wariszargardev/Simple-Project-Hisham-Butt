<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Jobs\ForgotPasswordJob;
use App\Models\ResetPassword;
use App\Models\User;
use App\Models\UserToken;
use App\Traits\MediaTrait;
use Str;

class UserRepository extends AbstractRepository
{
    use MediaTrait;
    private $model;

    public function __construct(User $user)
    {
        $this->model= $user;
    }

    public function registerUser($data){
        $image = $this->verifyAndUpload($data, 'profile_picture');
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
            'age' => $data['age'],
            'profile_picture' => $image
        ]);

        $token= $this->saveAndCreateToken($user->id);

        $data= array();
        $data['name']= $user->name;
        $data['token']= $token;

        return response()->json([
            'success'   => true,
            'message'   => 'Login Successfully',
            'data' => $data,
            'status' => 200
        ]);

    }

    public function loginUser($data){
        $user = User::where('email', $data['email'])->first();
        if($user){
            if (\Hash::check($data['password'], $user->password)) {
                $token= $this->saveAndCreateToken($user->id);

                $data= array();
                $data['name']= $user->name;
                $data['token']= $token;

                return response()->json([
                    'success'   => true,
                    'message'   => 'Login Successfully',
                    'data' => $data,
                    'status' => 200
                ]);
            }
            else{
                return response()->json([
                    'success'   => false,
                    'message'   => 'Invalid credentials',
                    'status' => 400
                ]);
            }
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Invalid credentials',
                'status' => 400
            ]);
        }

    }

    private function saveAndCreateToken($user_id ,$stringLength=16){
        $token = Str::random($stringLength);

        UserToken::where('user_id', $user_id)->delete();

        UserToken::create([
           'user_id' => $user_id,
           'token' => $token,
        ]);

        return encrypt($token);
    }

    public function getProfile($data){
        return response()->json([
            'success'   => true,
            'message'   => 'User Profile',
            'data' => new UserResource($data['user']),
            'status' => 200
        ]);
    }

    public function updateProfile($data){

        $user= $data['user'];
        if($data->profile_picture){
            $image = $this->verifyAndUpload($data, 'profile_picture');
            $user->profile_picture = $image;
        }

        if($data->password){
            $user->password= \Hash::make($data['password']);
        }
        $user->name= $data['name'];
        $user->age= $data['age'];

        $user->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Profile updated successfully',
            'data' => new UserResource($data['user']),
            'status' => 200
        ]);

    }

    public function forgotPassword($data){
        $user = User::where('email', $data['email'])->first();

        if($user){
            $token= $this->createAndSaveForgotPasswordToken($user->id);

            dispatch(new ForgotPasswordJob($user->email, $token));

            return response()->json([
                'success'   => true,
                'message'   => 'Link send to your email',
                'data' => [],
                'status' => 200
            ]);
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Invalid Email',
                'status' => 400
            ]);
        }
    }

    public function resetPassword($data){
        $resetPasswordToken = ResetPassword::where('token', decrypt($data['token']))->first();

        if($resetPasswordToken){
            $user = $resetPasswordToken->user;

            if($user){
                $user->password= \Hash::make($data['password']);
                $user->save();

                $resetPasswordToken->delete();

                return response()->json([
                    'success'   => true,
                    'message'   => 'Password updated successfully',
                    'data' => new UserResource($user),
                    'status' => 200
                ]);
            }
            else{
                return response()->json([
                    'success'   => false,
                    'message'   => 'Invalid Token',
                    'status' => 400
                ]);
            }
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Invalid Token',
                'status' => 400
            ]);
        }

    }

    private function createAndSaveForgotPasswordToken($user_id ,$stringLength=16){
        $token = Str::random($stringLength);

        ResetPassword::where('user_id', $user_id)->delete();

        ResetPassword::create([
            'user_id' => $user_id,
            'token' => $token,
        ]);

        return encrypt($token);
    }


}
