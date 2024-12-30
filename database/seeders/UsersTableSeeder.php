<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::firstOrCreate([
            'email'     => 'super@admin.com'
        ], [
            'name'  => 'super',
            'password'  => bcrypt('oz123$admin$'),
            'is_admin'  => 'yes',
            'is_root'  => 'yes',
            'status' => 'active',
        ]);
        User::factory()->count(10)->create();
    }
}
