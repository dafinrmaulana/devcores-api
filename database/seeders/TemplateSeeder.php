<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $str = Str::random(40);
        Template::create([
            "name" => "Canvas",
            "slug" => "canvas",
            "description" => "Canvas template",
            "thumbnail" => "images/templates/{$str}.png"
        ]);
        Template::create([
            "name" => "Space",
            "slug" => "space",
            "description" => "Space template",
            "thumbnail" => "images/templates/{$str}.png"
        ]);
        Template::create([
            "name" => "Nature",
            "slug" => "nature",
            "description" => "Nature template",
            "thumbnail" => "images/templates/{$str}.png"
        ]);
        Template::create([
            "name" => "Abstract",
            "slug" => "abstract",
            "description" => "Abstract template",
            "thumbnail" => "images/templates/{$str}.png"
        ]);
    }
}
