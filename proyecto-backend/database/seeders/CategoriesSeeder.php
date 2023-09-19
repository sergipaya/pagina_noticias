<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->name = 'Actualidad';
        $category->description = 'Actualidad sobre el mundo de la ciencia y la tecnología';
        $category->save();

        $category = new Category();
        $category->name = 'Móviles';
        $category->description = 'Noticias sobre el mundo de los teléfonos móviles';
        $category->save();

        $category = new Category();
        $category->name = 'Ciencia';
        $category->description = 'Actualidad sobre el mundo de la ciencia';
        $category->save();

        $category = new Category();
        $category->name = 'Guías de compra';
        $category->description = 'Las mejores guías de compra de móviles, informática, audio y tecnología';
        $category->save();

        $category = new Category();
        $category->name = 'Movilidad';
        $category->description = 'Actualidad sobre el mundo del motor';
        $category->save();
    }
}
