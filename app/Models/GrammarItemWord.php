<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GrammarItemWord extends Model
{
    protected $table = "grammar_word_list";
    protected $fillable = [
        'word',
        'reading',
        'meaning'
    ];

    public function grammarItem(){
        return $this->belongsTo(GrammarLearningPathItem::class, 'grammar_item_id');
    }
}
