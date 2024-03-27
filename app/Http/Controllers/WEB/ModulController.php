<?php

namespace App\Http\Controllers\WEB;

use App\Enums\ModulTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    protected $modul;

    public function __construct(Modul $modul)
    {
        $this->modul = $modul;
    }

    public function index(Request $request)
    {
        $request->session()->put('type', 0);

        if ($request->has('type')) {
            $request->session()->put('type', $request->type);
        }

        $data = [
            "moduls" => $this->modul->where('type', $request->session()->get('type'))->orderBy('sort', 'asc')->get(),
            "types" => ModulTypeEnum::get()
        ];

        return view('modul.index', $data);
    }

    public function create()
    {
        $types = ModulTypeEnum::get();
        return view('modul.create', compact('types'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "type" => "required|in:0,1",
            "icon_file" => "required|image|mimes:png,jpg,jpeg"
        ]);

        $sortMax = $this->modul->selectRaw("MAX(sort) as sort")->where('type', $request->type)->first()->sort + 1;

        try {
            $request->merge([
                "icon" => $request->file("icon_file")->store("icon"),
                "slug" => Str::slug($request->name),
                "status" => 0,
                "sort" => $sortMax
            ]);

            $this->modul->create($request->except(['icon_file']));

            DB::commit();
            return redirect(route('web.modul.index'))->with("success", "Modul berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Modul $modul)
    {
        return view('modul.edit', compact('modul'));
    }

    public function update(Request $request, Modul $modul)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "icon_file" => "image|mimes:png,jpg,jpeg"
        ]);

        $request->merge([
            "slug" => Str::slug($request->name),
        ]);

        try {
            if ($request->hasFile('icon_file')) {
                if ($modul->icon && Storage::exists($modul->icon)) {
                    Storage::delete($modul->icon);
                }

                $request->merge([
                    "icon" => $request->file("icon_file")->store("icon"),
                ]);
            }

            $modul->update($request->all());

            DB::commit();
            return redirect(route('web.modul.index'))->with("success", "Modul berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function updateStatus(Modul $modul)
    {
        DB::beginTransaction();

        try {
            $modul->update([
                "status" => $modul->status == $modul::ACTIVE ? $modul::NON_ACTIVE : $modul::ACTIVE
            ]);

            Session::flash('success', 'Data berhasil disimpan!');

            DB::commit();
            return $modul;
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function updateSort($current, $next)
    {
        DB::beginTransaction();

        $currentModul = $this->modul->where('type', session()->get('type'))->whereSort($current)->first();
        $nextModul = $this->modul->where('type', session()->get('type'))->whereSort($next)->first();

        try {
            $currentModul->update([
                "sort" => $next,
            ]);
            $nextModul->update([
                "sort" => $current,
            ]);

            DB::commit();
            return redirect(route('web.modul.index'))->with("success", "Modul berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function destroy(Modul $modul)
    {
        DB::beginTransaction();

        try {
            if ($modul->icon && Storage::exists($modul->icon)) {
                Storage::delete($modul->icon);
            }

            $modul->delete();

            DB::commit();
            return back()->with("success", "Modul berhasil dihapus.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
}
