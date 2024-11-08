<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Str;

class CreateDefaultCategory extends Command
{
    // The name and signature of the console command
    protected $signature = 'category:create-default {name} {--description=}';

    // The console command description
    protected $description = 'Create a default top-level category with no parent';

    // Execute the console command
    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->option('description');

        // Create the category
        $category = Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $description,
            'parent_id' => null,  // Set parent_id to null for top-level category
        ]);

        $this->info("Category '{$category->name}' created successfully with ID {$category->id}.");
    }
}
