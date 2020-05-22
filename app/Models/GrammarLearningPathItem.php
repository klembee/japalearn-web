<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GrammarLearningPathItem extends Model
{
    protected $table = "grammar_learning_path";
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'meta_description',
        'slug'
    ];

    protected $appends = ['abstract'];

    /**
     * The category of this learning path item
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(GrammarLearningPathCategory::class);
    }

    public function students(){
        return $this->belongsToMany(StudentInfo::class, "grammar_lesson_student", "student_info_id", "grammar_item_id");
    }

    public function questions(){
        return $this->hasMany(GrammarLearningPathQuestion::class, 'grammar_item_id');
    }

    public function scopeNotDone(Builder $query){
        $user = Auth::user();
        $itemsDone = $user->info->information->grammarItemsDone->pluck('id');
        return $query->whereNotIn('id', $itemsDone);
    }

    public function getAbstractAttribute(){
        $markdownParser = new \Parsedown();
        $parsedContent = strip_tags(str_replace('</', '. </', $markdownParser->text($this->content)));

        return mb_substr($parsedContent, 0, 100) . "...";
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
