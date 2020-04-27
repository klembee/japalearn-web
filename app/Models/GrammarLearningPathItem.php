<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GrammarLearningPathItem extends Model
{
    protected $table = "grammar_learning_path";
    protected $fillable = [
        'title',
        'content',
        'category_id'
    ];

    /**
     * The category of this learning path item
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(GrammarLearningPathCategory::class);
    }
}
