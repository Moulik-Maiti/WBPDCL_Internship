<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Status::insert([
            ['status' => 'In Progress' , 'colour' => 'blue',],
            ['status' => 'Pending' , 'colour' => 'yellow',],
            ['status' => 'Completed' , 'colour' => 'green',],
            ['status' => 'Rejected' , 'colour' => 'red'],
        ]);
    }
}
