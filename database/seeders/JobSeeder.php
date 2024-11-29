<?php

namespace Database\Seeders;

use App\Models\Job;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create([
            'name' => '123 Queen Street, Auckland',
            'detail' => 'Repaint living room and bedrooms with a light beige color, including prep work and priming.',
            'date' => '2024-03-25',
            'revenue' => 1200.00,
            'material_cost' => 300.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '45 Victoria Street, Wellington',
            'detail' => 'Scrape old paint, pressure wash, and apply two coats of weather-resistant paint.',
            'date' => '2024-03-27',
            'revenue' => 1800.00,
            'material_cost' => 400.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '89 Albert Street, Tauranga',
            'detail' => 'Repair cracks in wooden doors and repaint them with white semi-gloss paint.',
            'date' => '2024-03-28',
            'revenue' => 800.00,
            'material_cost' => 200.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '12 Khyber Pass Road, Christchurch',
            'detail' => 'Apply light gray paint to walls and white paint to ceilings in a 5-room office.',
            'date' => '2024-03-30',
            'revenue' => 2500.00,
            'material_cost' => 600.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '34 Devonport Road, Hamilton',
            'detail' => 'Fix chipped areas on interior walls and match existing paint color.',
            'date' => '2024-04-01',
            'revenue' => 700.00,
            'material_cost' => 150.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '90 Ponsonby Road, Auckland',
            'detail' => 'Sand down and repaint the wooden fence with weatherproof brown paint.',
            'date' => '2024-04-03',
            'revenue' => 600.00,
            'material_cost' => 120.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '56 Willis Street, Wellington',
            'detail' => 'Prime and paint hallway walls with off-white paint for a fresh look.',
            'date' => '2024-04-05',
            'revenue' => 1100.00,
            'material_cost' => 250.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '78 Victoria Street, Tauranga',
            'detail' => 'Sand, repair, and paint wooden shutters with deep green paint.',
            'date' => '2024-04-07',
            'revenue' => 950.00,
            'material_cost' => 180.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '123 Lambton Quay, Christchurch',
            'detail' => 'Clean, prime, and paint garage walls and ceiling in light gray.',
            'date' => '2024-04-10',
            'revenue' => 1400.00,
            'material_cost' => 320.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '45 Remuera Road, Auckland',
            'detail' => 'Repaint dining room walls with an eggshell white finish, including trim.',
            'date' => '2024-04-12',
            'revenue' => 900.00,
            'material_cost' => 180.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '345 Albert Street, Wellington',
            'detail' => 'Paint a single feature wall in the living room with dark blue paint.',
            'date' => '2024-04-15',
            'revenue' => 500.00,
            'material_cost' => 90.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '67 Colombo Street, Tauranga',
            'detail' => 'Sand and paint garage door with durable black enamel paint.',
            'date' => '2024-04-17',
            'revenue' => 400.00,
            'material_cost' => 80.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '12 Queen Street, Auckland',
            'detail' => 'Repair holes in drywall and repaint bedroom with pastel green paint.',
            'date' => '2024-04-20',
            'revenue' => 1100.00,
            'material_cost' => 240.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '78 Ponsonby Road, Hamilton',
            'detail' => 'Sand and repaint deck with weatherproof stain for outdoor durability.',
            'date' => '2024-04-22',
            'revenue' => 1300.00,
            'material_cost' => 300.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '56 Victoria Street, Christchurch',
            'detail' => 'Repaint walls and ceiling with a clean white finish for a modern look.',
            'date' => '2024-04-25',
            'revenue' => 2800.00,
            'material_cost' => 650.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '34 Devonport Road, Tauranga',
            'detail' => 'Paint walls with washable paint and white ceiling paint for a classroom.',
            'date' => '2024-04-27',
            'revenue' => 1700.00,
            'material_cost' => 400.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '90 Queen Street, Auckland',
            'detail' => 'Repaint porch railing and floorboards with weatherproof paint.',
            'date' => '2024-04-30',
            'revenue' => 800.00,
            'material_cost' => 190.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '45 Albert Street, Wellington',
            'detail' => 'Cover scuffed areas on interior walls and apply matching paint.',
            'date' => '2024-05-02',
            'revenue' => 600.00,
            'material_cost' => 110.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '123 Khyber Pass Road, Hamilton',
            'detail' => 'Paint interior and exterior of a new shed with durable paint.',
            'date' => '2024-05-05',
            'revenue' => 1500.00,
            'material_cost' => 350.00,
            'status' => 1,
        ]);

        Job::create([
            'name' => '12 Willis Street, Christchurch',
            'detail' => 'Prime and paint ceiling with matte white paint for an even finish.',
            'date' => '2024-05-08',
            'revenue' => 900.00,
            'material_cost' => 180.00,
            'status' => 1,
        ]);
    }
}
