<?php

namespace App\Http\Controllers\API;

use App\Enums\ModulTypeEnum;
use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Models\Modul;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    protected $modul;

    public function __construct(Modul $modul)
    {
        $this->modul = $modul;
    }

    public function __invoke(Request $request)
    {
        $data = [];

        $type = ModulTypeEnum::HEADER;
        if ($request->has('type')) {
            $type = $request->type;
        }

        $moduls = $this->modul->query()->where('status', $this->modul::ACTIVE)->where('type', $type)->orderBy('sort', 'asc')->get();

        foreach ($moduls as $key => $modul) {
            $data[$key] = [
                "name" => $modul->name,
                "icon" => asset("storage/$modul->icon"),
            ];

            if ($type == ModulTypeEnum::CONTENT) {
                $data[$key]['products'] = $this->getProducts($modul->productCategories());
            }
        }

        return TerasMessage::render([
            "data" => $data
        ]);
    }

    protected function getProducts($categories)
    {
        $data = [];

        foreach ($categories->paginate(10) as $key => $category) {
            $data[] = [
                "name" => $category->product->name,
                "slug" => $category->product->slug,
                "description" => $category->product->description,
                "stock" => $category->product->stock,
                "price" => $category->product->price,
            ];
        }

        return $data;
    }
}
