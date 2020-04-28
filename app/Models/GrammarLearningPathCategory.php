<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GrammarLearningPathCategory extends Model
{
    protected $table = "grammar_learning_path_categories";
    protected $appends = ['number_items', 'number_items_done'];

    public function getNumberItemsAttribute(){
        return $this->items()->count();
    }

    public function getNumberItemsDoneAttribute(){
        $user = Auth::user();
        if(!$user->isStudent()){
            return 0;
        }

        return $user->info->information->grammarItemsDone()->whereHas('category', function($query){
            $query->where('id', $this->id);
        })->count();
    }

    public function items(){
        return $this->hasMany(GrammarLearningPathItem::class, 'category_id');
    }

    /**
     * Retrieve the "basic" category
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function basic(){
        return GrammarLearningPathCategory::query()->where('category', 'Basic')->first();
    }

    /**
     * Retrieve the "essential" category
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function essential(){
        return GrammarLearningPathCategory::query()->where('category', 'Essential')->first();
    }

    /**
     * Retrieve the advanced category
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function Advanced(){
        return GrammarLearningPathCategory::query()->where('category', 'Advanced')->first();
    }

    /**
     * Retrieve the special category
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function Special(){
        return GrammarLearningPathCategory::query()->where('category', 'Special')->first();
    }
}
