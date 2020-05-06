<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Kana;
use App\Models\KanaLearningStats;
use Illuminate\Http\Request;

class KanaLearningPathController extends Controller
{
    /**
     * Allow an admin to edit the information
     * about a kana
     * @param Request $request
     * @param Kana $kana
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Kana $kana){
        try {
            $this->validate($request, [
                'mnemonic' => 'present'
            ]);

            $kana->mnemonic = $request->input('mnemonic');
            $kana->save();
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    /**
     * Increases of decreases the level of the kana items that the user
     * reviewed
     * @param Request $request
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateLevel(Request $request){
        $user = $request->user();
        //todo: Verify that the user waited ennough time to update this level

        $this->validate($request, [
            'good' => "present|array",
            'wrong' => 'present|array'
        ]);

        $studentInformation = $user->info->information;

        foreach($request->input('good') as $good){
            $alreadyLearnedId = $studentInformation->kanaLearningPathStats->pluck('kana_id');

            if ($alreadyLearnedId->contains($good['id'])) {
                // Increase the level
                $stat = KanaLearningStats::query()
                    ->where('student_info_id', $studentInformation->id)
                    ->where('kana_id', $good['id'])->firstOrFail();

                $stat->number_right += 1;
                $stat->last_review = now();
                $stat->save();

            } else {
                // Set the level to 1
                $stat = new KanaLearningStats([
                    'student_info_id' => $studentInformation->id,
                    'kana_id' => $good['id'],
                    'number_right' => 1,
                    'last_review' => now()
                ]);
                $stat->save();
            }
        }

        foreach($request->input('wrong') as $wrong){
            $alreadyLearnedId = $studentInformation->kanaLearningPathStats->pluck('kana_id');

            if ($alreadyLearnedId->contains($wrong['id'])) {
                // Increase the level
                $stat = KanaLearningStats::query()
                    ->where('student_info_id', $studentInformation->id)
                    ->where('kana_id', $good['id'])->firstOrFail();

                $stat->number_right -= 1;
                if($stat->numberRight < 1){
                    $stat->number_right = 1;
                }
                $stat->last_review = now();
                $stat->save();
            }
        }

        return "";
    }
}
