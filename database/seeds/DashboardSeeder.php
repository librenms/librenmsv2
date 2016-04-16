<?php

use App\Models\Widgets;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data   = ['widget_title' => 'Availability map', 'widget' => 'availability-map', 'base_dimensions' => '4,3'];
        $widget = Widgets::create($data);
    }
}
