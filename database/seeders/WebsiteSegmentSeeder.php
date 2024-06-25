<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSegmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('website_segments')->insert([
      'title' => "Notícia",
      'created_at' => Carbon::now(),
    ]);
    DB::table('website_segments')->insert([
      'title' => "Mídia",
      'created_at' => Carbon::now(),
    ]);
    DB::table('website_segments')->insert([
      'title' => "Outro",
      'created_at' => Carbon::now(),
    ]);
  }
}
