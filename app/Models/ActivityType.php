<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    protected $table = "activity_types";
    protected $fillable = [
        'name'
    ];

    public static function kanaLearned(){
        return ActivityType::query()->where('name', 'kana_learned')->first();
    }

    public static function kanaReviewed(){
        return ActivityType::query()->where('name', 'kana_reviewed')->first();
    }

    public static function kanjiLearned(){
        return ActivityType::query()->where('name', 'kanji_learned')->first();
    }

    public static function kanjiReviewed(){
        return ActivityType::query()->where('name', 'kanji_reviewed')->first();
    }

    public static function grammarLearned(){
        return ActivityType::query()->where('name', 'grammar_lesson_learned')->first();
    }

    public static function storyRead(){
        return ActivityType::query()->where('name', 'story_read')->first();
    }
}
