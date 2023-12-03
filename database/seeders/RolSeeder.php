<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //FILE JSON
        $file = "database/data/roles.json";
        if (File::exists($file)) {
            $json = File::get($file);

            foreach (json_decode($json) as $obj) {
                Rol::create([
                    'id' => $obj->id,
                    'nombre' => $obj->nombre,
                ]);
            }
        }
    }
}
