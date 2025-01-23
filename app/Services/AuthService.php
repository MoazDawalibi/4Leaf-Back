<?php

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public $columnSearch = "email";

    public function __construct()
    {
        parent::__construct(className: User::class);
    }

    public function indexWithFilter(
        $per_page = 8,
        $page = 1,
        $search = null,
        $role_type = null,) 
    {
        $data = User::when($role_type, function ($q) use ($role_type) {
            return $q->whereRoleType( $role_type);
        });

        if ($search) {
            $data->where($this->columnSearch, 'LIKE', '%' . $search . '%');
        }
    
        $user = $data->paginate($per_page, ['*'], 'page', $page);
        
        return $user;
    }
    public function updateUser(array $data, int $userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            return ['error' => 'User not found'];
        }

        // Update email if provided and ensure it is unique
        // if (isset($data['email'])) {
        //     if (User::where('email', $data['email'])->where('id', '!=', $userId)->exists()) {
        //         return ['error' => 'Email is already used'];
        //     }
        //     $user->email = $data['email'];
        // }

        // Update password if provided
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Update role_type if provided and validate it
        if (isset($data['role_type'])) {
            $validRoles = array_map(fn($role) => $role->value, UserTypeEnum::cases());
            if (!in_array($data['role_type'], $validRoles)) {
                return ['error' => 'Invalid role type'];
            }
            $user->role_type = $data['role_type'];
        }

        // Save the changes
        $user->save();

        return [
            'message' => 'User updated successfully',
            'user' => [
                'email' => $user->email,
                'role_type' => $user->role_type,
            ]
        ];
    }

    public function register(array $data)
    {

        // Check if the email is already in use
        if (User::where('email', $data['email'])->exists()) {
            return ['error' => 'Email is already used'];
        }
    
        // Validate the role type using the UserTypeEnum
        $validRoles = array_map(fn($role) => $role->value, UserTypeEnum::cases());
        if (!in_array($data['role_type'], $validRoles)) {
            return ['error' => 'Invalid role type'];
        }
    
        // Hash the password before storing
        $data['password'] = Hash::make($data['password']);
    
        // Create the user
        $user = $this->className::create($data);
    
        // Generate an access token for the new user
        $token = $user->createToken('RegistrationToken')->plainTextToken;

        return [
            'email' => $user->email,
            'role_type' => $user->role_type,
            'token' => $token,
        ];
    }

    public function login(array $data)
    {
        // Attempt to find the user by email
        $user = User::where('email', $data['email'])->first();

        // Check if the user exists and the password matches
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ['error' => 'Invalid credentials'];
        }

        // Generate an access token for the authenticated user
        $token = $user->createToken($user->role_type)->plainTextToken;

        return [
            'email' => $user->email,
            'role_type' => $user->role_type,
            'token' => $token,
        ];
    }

    public function logout($request)
    {
        // Retrieve the token from the request
        $token = $request->input('token');
    
        // Find the token in the `personal_access_tokens` table
        $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
    
        if ($personalAccessToken) {
            // Delete the token
            $personalAccessToken->delete();
    
            return ['message' => 'Logged out successfully'];
        }
    
        return ['error' => 'Invalid or expired token'];
    }
    

}