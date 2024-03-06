<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sign\UpRequest;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function in()
    {
    }

    public function out()
    {
    }
}
