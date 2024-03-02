<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    protected $user, $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        $data = [
            "users" => $this->user->whereHas('roles', function ($query) {
                $query->where('id', User::ADMIN);
            })->get()
        ];

        return view('user.admin.index', $data);
    }

    public function create()
    {
        $data = ["user" => null];
        return view('user.admin.form', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|max:255"
        ]);

        $request->merge([
            "password" => Hash::make($request->password ?? "password")
        ]);

        try {
            $this->user->create($request->all())
                ->syncRoles($this->role->findById($this->user::ADMIN, "api")->first());

            DB::commit();
            return back()->with("success", "Pengguna baru berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail($id);

        return view('user.admin.form', compact("user"));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "email" => [
                "required",
                "email",
                Rule::unique('users')->ignore($id)
            ],
        ]);

        $user = $this->user->findOrFail($id);

        try {
            $user->update($request->all());

            DB::commit();
            return back()->with("success", "Pengguna berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $user = $this->user->findOrFail($id);

        try {
            $user->delete();

            DB::commit();
            return back()->with("success", "Pengguna berhasil dihapus.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
}
