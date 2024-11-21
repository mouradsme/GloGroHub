<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AddCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:add {name} {description} {parent_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new category with name, description, and parent_id';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $parent_id = $this->argument('parent_id');


        // Validate email, role, and other fields
        $validator = Validator::make(
            [
                'parent_id' => $parent_id,
                'description' => $description,
                'name' => $name
            ],
            [
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:categories,id'
            ]
        );

        if ($validator->fails()) {
            $this->error('Validation error: ' . implode(', ', $validator->errors()->all()));
            return 1;
        }

        // Create the user
        $Category = Category::create([
            'description' => $description,
            'name' => $name,
            'parent_id' => $parent_id,
            'slug' => Str::slug($name),
        ]);

        $this->info("Category '{$Category->name}' has been created successfully.");
        return 0;
    }
}
