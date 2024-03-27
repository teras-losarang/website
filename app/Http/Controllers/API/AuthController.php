<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sign\InRequest;
use App\Http\Requests\Sign\UpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    protected $user, $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function up(UpRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "password" => Hash::make($request->password ?? "password")
        ]);

        try {
            $role = $this->role->where("id", $this->user::CUSTOMER)->first();
            $user = $this->user->create($request->all())
                ->syncRoles($role);

            DB::commit();
            return TerasMessage::created("$user->name has been added!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function in(InRequest $request)
    {
        DB::beginTransaction();

        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return TerasMessage::warning('email atau password anda salah!');
        }

        if (!Hash::check($request->password, $user->password)) {
            return TerasMessage::warning('email atau password anda salah!');
        }

        try {
            $role = $user->roles->pluck('name')->toArray();
            $token = $user->createToken('api', $role)->plainTextToken;

            DB::commit();
            return TerasMessage::render([
                "user" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "role_id" => $user->roles[0]->id,
                    "created_at" => $user->created_at,
                    "updated_at" => $user->updated_At,
                ],
                "token" => $token
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function me()
    {
        return auth()->user();
    }

    public function out()
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            DB::commit();
            return TerasMessage::success('logout successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return TerasMessage::error($th->getMessage());
        }
    }
}
