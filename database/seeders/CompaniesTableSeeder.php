<?php

namespace Database\Seeders;

use App\Models\Companies;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Companies::factory()
        ->count(21)
        ->hasEmployees(10)
        ->create();
    }
}
