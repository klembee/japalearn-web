<?php


namespace App\Http\Controllers;


use App\Models\WordType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function vocabularyLesson(Request $request){
        $user = $request->user();
        $vocabs = $user->userInfo->getVocabLessonItems();
        $radicals = $vocabs['radicals'];
        $kanjis = $vocabs['kanjis'];
        $vocabulary = $vocabs['vocabulary'];

        $itemsBeforeReviews = 5;

        $items = $radicals->concat($kanjis);
        $items = $items->concat($vocabulary);

        if(count($items) == 0){
            return redirect()->route('dashboard');
        }

        $items = array_chunk($items->toArray(), $itemsBeforeReviews, false);

        $reviews = [];
        $i = 0;
        foreach($items as $chunk){
            array_push($reviews, []);
            foreach($chunk as $item){
                if($item['word_type_id'] == WordType::radical()->id) {
                    array_push($reviews[$i], [
                        'question' => $item['word'],
                        'answers' => array_map(function($meaning){
                            return strtolower($meaning['meaning']);
                        }, $item['meanings']),
                        'type' => 'meaning'
                    ]);
                }else {
                    array_push($reviews[$i], [
                        'question' => $item['word'],
                        'answers' => array_map(function($meaning){
                            return strtolower($meaning['reading']);
                        }, $item['readings']),
                        'type' => 'reading'
                    ]);
                    array_push($reviews[$i], [
                        'question' => $item['word'],
                        'answers' => array_map(function($meaning){
                            return strtolower($meaning['meaning']);
                        }, $item['meanings']),
                        'type' => 'meaning'
                    ]);
                }
            }

            $i++;
        }

        return view("app.study.vocab_lesson", [
            'items' => json_encode($items),
            'reviews' => json_encode($reviews),
        ]);
    }

    public function vocabularyReview(Request $request){
        $user = $request->user();
        $vocabs = $user->userInfo->getVocabReviewItems();

        $writingReviews = $vocabs['review']['writing'];
        $meaningReviews = $vocabs['review']['meaning'];

//        $items = array_merge($writingReviews, $meaningReviews);

//        error_log(json_encode($items));

        $reviews = [];



        foreach($writingReviews as $review){
            error_log($review['vocab_learning_path_item']['word']);
            array_push($reviews, [
                'question' => $review['vocab_learning_path_item']['word'],
                'answers' => array_map(function($item){
                        return strtolower($item['reading']);
                    }, $review['vocab_learning_path_item']['readings']),
                'type' => 'reading'
            ]);
        }

        foreach($meaningReviews as $review){
            error_log(json_encode($review));
            array_push($reviews, [
                'question' => $review['vocab_learning_path_item']['word'],
                'answers' => array_map(function($item){
                    return strtolower($item['meaning']);
                }, $review['vocab_learning_path_item']['meanings']),
                'type' => 'meaning'
            ]);
        }

        return view('app.study.vocab_review', [
            'reviews' => json_encode($reviews)
        ]);
    }
}
