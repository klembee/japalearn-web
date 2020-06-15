<?php


namespace App\Http\Controllers;


use App\Models\KanjiLearningPath;
use App\Models\KanjiLearningPathMeanings;
use App\Models\WordType;
use Illuminate\Http\Request;

/**
 * This class controls all the routes for the learning paths tasks
 * A learning path contains sequential study material that the student
 * should do.
 *
 * Only admins have access to this section.
 *
 * Class KanjiAdminController
 * @package App\Http\Controllers
 */
class KanjiAdminController extends Controller
{

    /**
     * Checks that the user accessing this section is an admin
     * KanjiAdminController constructor.
     */
    public function __construct()
    {
        //Check user is admin
        $this->middleware('isRole:admin');
    }

    /**
     * Shows the list of learning paths that exist and group them by level.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $itemsByLevel = KanjiLearningPath::query()->with('vocab')->get()->groupBy('level');

        return view('app.admin.kanji_learning_path.index', compact('itemsByLevel'));
    }

    /**
     * @param Request $request
     */
    public function export(Request $request){
        return KanjiLearningPath::query()->with('readings', 'meanings', 'examples')->get()->toJson();
    }

    public function import(Request $request){
        $this->validate($request, [
            'json_content' => 'required|file'
        ]);

        $json_file = $request->file('json_content');
        $items = json_decode($json_file->get(), true);

        foreach($items as $item){
            $meanings = $item->meanings;
            $readings = $item->readings;
            $examples = $item->examples;

            // Try to find existing data
            $itemModel = KanjiLearningPath::query()
                ->where('word', $item->word)
                ->where('level', $item->level)
                ->where('word_type_id', $item->word_type_id)->first();

            if(!$itemModel){
                $itemModel = new KanjiLearningPath();
                $itemModel->word = $item->word;
                $itemModel->level = $item->level;
                $itemModel->word_type_id = $item->word_type_id;
            }

            $itemModel->mnemonic = $item->mnemonic;
            $itemModel->save();

            foreach($meanings as $meaning){
                $meaningModel = KanjiLearningPathMeanings::query()
                    ->where("kanji_id", $itemModel->id)
                    ->where('meaning');
            }

            foreach ($readings as $reading){

            }

            foreach ($examples as $example){

            }

        }
    }


    /**
     * View a specific learning path of a certain level.
     * It gives to the view the learning path item grouped by the word type
     * (radical, kanji, vocabulary)
     *
     * @param Request $request
     * @param int $level
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewLevel(Request $request, int $level){

        $kanjis = KanjiLearningPath::query()
            ->where('level', $level)
            ->with('meanings', 'onReadings', 'kunReadings', 'vocab')->get()->toArray();

        return view('app.admin.kanji_learning_path.edit_level', compact('kanjis'));
    }
}
