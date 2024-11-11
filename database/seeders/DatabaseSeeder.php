<?php

namespace Database\Seeders;

use App\Models\Estreno;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Usuario::factory(10)->create();
        Estreno::factory(10)->create();
        //Table registro
        for($i=1; $i<=10; $i++){
            $estreno = Estreno::find($i);
            $estreno->usuarios()->attach(random_int(1,10));
        }
    }
}
