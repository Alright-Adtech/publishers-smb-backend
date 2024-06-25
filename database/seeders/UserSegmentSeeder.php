<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSegmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('user_segments')->insert([
      'title' => "Veículo de comunicação",
      'created_at' => Carbon::now(),
    ]);
    DB::table('user_segments')->insert([
      'title' => "Anunciante",
      'created_at' => Carbon::now(),
    ]);
    DB::table('user_segments')->insert([
      'title' => "Site de conteúdo especializado",
      'created_at' => Carbon::now(),
    ]);
    DB::table('user_segments')->insert([
      'title' => "Agência",
      'created_at' => Carbon::now(),
    ]);
    DB::table('user_segments')->insert([
      'title' => "Jornalista / Produtos de Conteúdo",
      'created_at' => Carbon::now(),
    ]);
    DB::table('user_segments')->insert([
      'title' => "Estudante",
      'created_at' => Carbon::now(),
    ]);
  }
}
