<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        Department::firstOrCreate([
            'name' => 'Phòng kỹ thuật',
        ]);

        Department::firstOrCreate([
            'name' => 'Phòng IT',
        ]);

        Department::firstOrCreate([
            'name' => 'Phòng kinh doanh'
        ]);
    }
}