<?php

namespace Database\Seeders;

use App\Enums\StatusSlugEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class StatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('statuses')->insert([
      'slug' => StatusSlugEnum::Started,
      'description' => "Iniciado",
      'created_at' => Carbon::now(),
    ]);
    DB::table('statuses')->insert([
      'slug' => StatusSlugEnum::FinalizedForm,
      'description' => "Formulário finalizado",
      'created_at' => Carbon::now(),
    ]);
  }
}
