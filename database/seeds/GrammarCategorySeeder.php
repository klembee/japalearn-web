<?php


class GrammarCategorySeeder extends \Illuminate\Database\Seeder
{
    public function run(){
        $categories = [
            'Basic' => 0,
            'Essential' => 1,
            'Advanced' => 2,
            'Special' => 3
        ];

        foreach($categories as $category => $order){
            \Illuminate\Support\Facades\DB::table('grammar_learning_path_categories')->insert([
                'category' => $category,
                'order' => $order,
            ]);
        }
    }
}
