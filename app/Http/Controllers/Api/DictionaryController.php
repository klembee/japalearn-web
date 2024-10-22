<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * Api controller that controls dictionary related stuff
 *
 * Class DictionaryController
 * @package App\Http\Controllers\Api
 */
class DictionaryController extends Controller
{
    /**
     * Allow the user to query the dictionary
     * if accepts a "query" parameter that correspond to the word to search and
     * the 'convertToHiragana' parameter. The last one, if set to true will transform
     * the query to hiragana before querying the database.
     * Example: akai -> あかい (Please refer to the method toHiragana() bellow)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function query(Request $request){
        $this->validate($request, [
            'query' => 'present',
            'convertToHiragana' => 'boolean'
        ]);

        $searchQuery = $request->input('query');
        $hiraganaSearchQuery = DictionaryController::toHiragana($searchQuery);

        if($request->input('convertToHiragana')){
            $searchQuery = $hiraganaSearchQuery;
        }

        $response = Vocabulary::search($searchQuery)->paginate(10)->load(['readings', 'meanings']);

        return response()->json([
            'query' => $searchQuery,
            'response' => $response
        ]);
    }

    /**
     * Allows a user to save a word he/she finds
     * in the dictionary. The number of time the word is saved is
     * used by Algolia to sort the dictionary results so we have to update Algolia
     * with the new number
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addToVocabulary(Request $request){
        $this->authorize('add', Vocabulary::class);
        $this->validate($request, [
            'vocabulary_id' => 'required'
        ]);

        $vocab = Vocabulary::query()->where('id', $request->input('vocabulary_id'))->firstOrFail();
        $student = $request->user();

        try{
            $student->vocabulary()->attach([$vocab->id]);

            # Update on Algolia
            $vocab->save();
        }catch (QueryException $e){
            if($e->errorInfo[1] == 1062){
                return response()->json([
                    'error' => __("This word is already in your vocabulary")
                ]);
            }else{
                return response()->json([
                    'error' => __("Error while adding to vocabulary")
                ]);
            }
        }

        return $vocab;
    }

    /**
     * Converts romaji to hiragana
     * Thanks to https://stackoverflow.com/a/60707357/3971619 for the code
     * @param $hold string the text containing romaji
     * @return string|string[]
     */
    public static function toHiragana(string $hold){
        $hold = str_replace("tsu", "つ", $hold);
        $hold = str_replace("kya", "きゃ", $hold);
        $hold = str_replace("kyu", "きゅ", $hold);
        $hold = str_replace("kyo", "きょ", $hold);
        $hold = str_replace("sha", "しゃ", $hold);
        $hold = str_replace("shi", "し", $hold);
        $hold = str_replace("shu", "しゅ", $hold);

        $hold = str_replace("sho", "しょ", $hold);
        $hold = str_replace("chi", "ち", $hold);
        $hold = str_replace("cha", "ちゃ", $hold);
        $hold = str_replace("chu", "ちゅ", $hold);
        $hold = str_replace("cho", "ちょ", $hold);
        $hold = str_replace("hya", "ひゃ", $hold);
        $hold = str_replace("hyu", "ひゅ", $hold);
        $hold = str_replace("hyo", "ひょ", $hold);
        $hold = str_replace("rya", "りゃ", $hold);
        $hold = str_replace("ryu", "りゅ", $hold);


        $hold = str_replace("ryo", "りょ", $hold);
        $hold = str_replace("gya", "ぎゃ", $hold);
        $hold = str_replace("gyu", "ぎゅ", $hold);
        $hold = str_replace("gyo", "ぎょ", $hold);
        $hold = str_replace("bya", "びゃ", $hold);
        $hold = str_replace("byu", "びゅ", $hold);
        $hold = str_replace("byo", "びょ", $hold);
        $hold = str_replace("pya", "ぴゃ", $hold);

        $hold = str_replace("pyu", "ぴゅ", $hold);
        $hold = str_replace("pyo", "ぴょ", $hold);
        $hold = str_replace("ja", "じゃ", $hold);
        $hold = str_replace("ju", "じゅ", $hold);
        $hold = str_replace("jo", "じょ", $hold);
        $hold = str_replace("ba", "ば", $hold);
        $hold = str_replace("da", "だ", $hold);
        $hold = str_replace("ga", "が", $hold);
        $hold = str_replace("ha", "は", $hold);
        $hold = str_replace("ka", "か", $hold);
        $hold = str_replace("ma", "ま", $hold);
        $hold = str_replace("pa", "ぱ", $hold);

        $hold = str_replace("ra", "ら", $hold);
        $hold = str_replace("sa", "さ", $hold);
        $hold = str_replace("ta", "た", $hold);
        $hold = str_replace("wa", "わ", $hold);
        $hold = str_replace("ya", "や", $hold);
        $hold = str_replace("za", "ざ", $hold);
        $hold = str_replace("na", "な", $hold);
        $hold = str_replace("a", "あ", $hold);


        $hold = str_replace("be", "べ", $hold);
        $hold = str_replace("de", "で", $hold);
        $hold = str_replace("ge", "げ", $hold);
        $hold = str_replace("he", "へ", $hold);
        $hold = str_replace("ke", "け", $hold);
        $hold = str_replace("me", "め", $hold);
        $hold = str_replace("pe", "ぺ", $hold);
        $hold = str_replace("re", "れ", $hold);
        $hold = str_replace("se", "せ", $hold);
        $hold = str_replace("te", "て", $hold);
        $hold = str_replace("ze", "ぜ", $hold);
        $hold = str_replace("ne", "ね", $hold);


        $hold = str_replace("e", "え", $hold);
        $hold = str_replace("bi", "び", $hold);
        $hold = str_replace("gi", "ぎ", $hold);
        $hold = str_replace("hi", "ひ", $hold);
        $hold = str_replace("ki", "き", $hold);
        $hold = str_replace("mi", "み", $hold);
        $hold = str_replace("pi", "ぴ", $hold);
        $hold = str_replace("ri", "り", $hold);
        $hold = str_replace("ji", "じ", $hold);
        $hold = str_replace("ni", "に", $hold);


        $hold = str_replace("i", "い", $hold);
        $hold = str_replace("bo", "ぼ", $hold);
        $hold = str_replace("do", "ど", $hold);
        $hold = str_replace("go", "ご", $hold);
        $hold = str_replace("ho", "ほ", $hold);
        $hold = str_replace("ko", "こ", $hold);



        $hold = str_replace("mo", "も", $hold);
        $hold = str_replace("po", "ぽ", $hold);
        $hold = str_replace("ro", "ろ", $hold);
        $hold = str_replace("so", "そ", $hold);
        $hold = str_replace("to", "と", $hold);
        $hold = str_replace("wo", "を", $hold);
        $hold = str_replace("yo", "よ", $hold);
        $hold = str_replace("zo", "ぞ", $hold);

        $hold = str_replace("no", "の", $hold);
        $hold = str_replace("o", "お", $hold);
        $hold = str_replace("bu", "ぶ", $hold);
        $hold = str_replace("gu", "ぐ", $hold);
        $hold = str_replace("fu", "ふ", $hold);
        $hold = str_replace("ku", "く", $hold);
        $hold = str_replace("mu", "む", $hold);
        $hold = str_replace("pu", "ぷ", $hold);
        $hold = str_replace("ru", "る", $hold);
        $hold = str_replace("su", "す", $hold);


        $hold = str_replace("yu", "ゆ", $hold);
        $hold = str_replace("zu", "ず", $hold);
        $hold = str_replace("nu", "ぬ", $hold);
        $hold = str_replace("u", "う", $hold);
        $hold = str_replace("n", "ん", $hold);

        return $hold;
    }
}
