<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VocabLearningPathExample extends Model
{
    protected $table = "vocab_learning_path_examples";

    protected $fillable = ['example', 'translation', 'type'];
}
