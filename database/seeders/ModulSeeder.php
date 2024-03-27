<?php

namespace Database\Seeders;

use App\Models\Modul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moduls = [
            [
                "sort" => 5,
                "name" => "Lihat Semua",
                "slug" => "Lihat Semua",
                "icon" => "assets/img/img-product-default.png",
                "status" => 1
            ],
            [
                "sort" => 1,
                "name" => "Makanan",
                "slug" => "Makanan",
                "icon" => "assets/img/img-product-default.png",
                "status" => 1
            ],
            [
                "sort" => 2,
                "name" => "Minuman",
                "slug" => "Minuman",
                "icon" => "assets/img/img-product-default.png",
                "status" => 1
            ],
            [
                "sort" => 3,
                "name" => "Terdekat",
                "slug" => "Terdekat",
                "icon" => "assets/img/img-product-default.png",
                "status" => 1
            ],
            [
                "sort" => 4,
                "name" => "Terlaris",
                "slug" => "Terlaris",
                "icon" => "assets/img/img-product-default.png",
                "status" => 1
            ],
        ];

        foreach ($moduls as $modul) {
            Modul::create($modul);
        }
    }
}
