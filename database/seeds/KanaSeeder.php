<?php


class KanaSeeder extends \Illuminate\Database\Seeder
{
    public function run(){
        $kanas = [
            "あ" => [
                'kana' => 'a',
                'sound_file' => 'a.wav'
            ],
            "い" => [
                'kana' => 'i',
                'sound_file' => 'i.wav'
            ], "う" => [
                'kana' => 'u',
                'sound_file' => 'u.wav'
            ],
            "え" => [
                'kana' => 'e',
                'sound_file' => 'e.wav'
            ],
            'お' => [
                'kana' => 'o',
                'sound_file' => 'o.wav'
            ],
            "か" => [
                'kana' => 'ka',
                'sound_file' => 'ka.wav'
            ],
            "き" => [
                'kana' => 'ki',
                'sound_file' => 'ki.wav'
            ],
            "く" => [
                'kana' => 'ku',
                'sound_file' => 'ku.wav'
            ],
            "け" => [
                'kana' => 'ke',
                'sound_file' => 'ke.wav'
            ],
            "こ" => [
                'kana' => 'ko',
                'sound_file' => 'ko.wav'
            ],
            "さ" => [
                'kana' => 'sa',
                'sound_file' => 'sa.wav'
            ],
            "し" => [
                'kana' => 'shi',
                'sound_file' => 'shi.wav'
            ],
            "つ" => [
                'kana' => 'tsu',
                'sound_file' => 'tsu.wav'
            ],
            "せ" => [
                'kana' => 'se',
                'sound_file' => 'se.wav'
            ],
            "そ" => [
                'kana' => 'so',
                'sound_file' => 'so.wav'
            ],
            'が' => [
                'kana' => 'ga',
                'sound_file' => 'ka-dakuten.wav'
            ],
            'ぎ' => [
                'kana' => 'gi',
                'sound_file' => 'ki-dakuten.wav'
            ],
            'ぐ' => [
                'kana' => 'gu',
                'sound_file' => 'ku-dakuten.wav'
            ],
            'げ' => [
                'kana' => 'ge',
                'sound_file' => 'ke-dakuten.wav'
            ],
            'ご' => [
                'kana' => 'go',
                'sound_file' => 'ko-dakuten.wav'
            ],
            "た" => [
                'kana' => 'ta',
                'sound_file' => 'ta.wav'
            ],
            "ち" => [
                'kana' => 'chi',
                'sound_file' => 'chi.wav'
            ],
            "す" => [
                'kana' => 'su',
                'sound_file' => 'su.wav'
            ],
            "て" => [
                'kana' => 'te',
                'sound_file' => 'te.wav'
            ],
            "と" => [
                'kana' => 'to',
                'sound_file' => 'to.wav'
            ],
            'ざ' => [
                'kana' => 'za',
                'sound_file' => 'sa-dakuten.wav'
            ],
            'じ' => [
                'kana' => 'ji',
                'sound_file' => 'shi-dakuten.wav'
            ],
            'ず' => [
                'kana' => 'zu',
                'sound_file' => 'su-dakuten.wav'
            ],
            'ぜ' => [
                'kana' => 'ze',
                'sound_file' => 'se-dakuten.wav'
            ],
            'ぞ' => [
                'kana' => 'zo',
                'sound_file' => 'so-dakuten.wav'
            ],
            "な" => [
                'kana' => 'na',
                'sound_file' => 'na.wav'
            ],
            "に" => [
                'kana' => 'ni',
                'sound_file' => 'ni.wav'
            ],
            "ぬ" => [
                'kana' => 'nu',
                'sound_file' => 'nu.wav'
            ],
            "ね" => [
                'kana' => 'ne',
                'sound_file' => 'ne.wav'
            ],
            "の" => [
                'kana' => 'no',
                'sound_file' => 'no.wav'
            ],
            'だ' => [
                'kana' => 'da',
                'sound_file' => 'ta-dakuten.wav'
            ],
            'ぢ' => [
                'kana' => 'ji',
                'sound_file' => 'chi-dakuten.wav'
            ],
            'づ' => [
                'kana' => 'zu',
                'sound_file' => 'tsu-dakuten.wav'
            ],
            'で' => [
                'kana' => 'de',
                'sound_file' => 'te-dakuten.wav'
            ],
            'ど' => [
                'kana' => 'do',
                'sound_file' => 'to-dakuten.wav'
            ],
            "は" => [
                'kana' => 'ha',
                'sound_file' => 'ha.wav'
            ],
            "ひ" => [
                'kana' => 'hi',
                'sound_file' => 'hi.wav'
            ],
            "ふ" => [
                'kana' => 'hu',
                'sound_file' => 'hu.wav'
            ],
            "へ" => [
                'kana' => 'he',
                'sound_file' => 'he.wav'
            ],
            "ほ" => [
                'kana' => 'ho',
                'sound_file' => 'ho.wav'
            ],
            "ま" => [
                'kana' => 'ma',
                'sound_file' => 'ma.wav'
            ],
            "み" => [
                'kana' => 'mi',
                'sound_file' => 'mi.wav'
            ],
            "む" => [
                'kana' => 'mu',
                'sound_file' => 'mu.wav'
            ],
            "め" => [
                'kana' => 'me',
                'sound_file' => 'me.wav'
            ],
            "も" => [
                'kana' => 'mo',
                'sound_file' => 'mo.wav'
            ],
            'ば' => [
                'kana' => 'ba',
                'sound_file' => 'ha-dakuten.wav'
            ],
            'び' => [
                'kana' => 'bi',
                'sound_file' => 'hi-dakuten.wav'
            ],
            'ぶ' => [
                'kana' => 'bu',
                'sound_file' => 'hu-dakuten.wav'
            ],
            'べ' => [
                'kana' => 'be',
                'sound_file' => 'he-dakuten.wav'
            ],
            'ぼ' => [
                'kana' => 'bo',
                'sound_file' => 'ho-dakuten.wav'
            ],
            'ぱ' => [
                'kana' => 'pa',
                'sound_file' => 'ha-handakuten.wav'
            ],
            'ぴ' => [
                'kana' => 'pi',
                'sound_file' => 'hi-handakuten.wav'
            ],
            'ぷ' => [
                'kana' => 'pu',
                'sound_file' => 'hu-handakuten.wav'
            ],
            'ぺ' => [
                'kana' => 'pe',
                'sound_file' => 'he-handakuten.wav'
            ],
            'ぽ' => [
                'kana' => 'po',
                'sound_file' => 'ho-handakuten.wav'
            ],
            "や" => [
                'kana' => 'ya',
                'sound_file' => 'ya.wav'
            ],
            "ゆ" => [
                'kana' => 'yu',
                'sound_file' => 'yu.wav'
            ],
            "よ" => [
                'kana' => 'yo',
                'sound_file' => 'yo.wav'
            ],
            "ら" => [
                'kana' => 'ra',
                'sound_file' => 'ra.wav'
            ],
            "り" => [
                'kana' => 'ri',
                'sound_file' => 'ri.wav'
            ],
            "る" => [
                'kana' => 'ru',
                'sound_file' => 'ru.wav'
            ],
            "れ" => [
                'kana' => 're',
                'sound_file' => 're.wav'
            ],
            "ろ" => [
                'kana' => 'ro',
                'sound_file' => 'ro.wav'
            ],
            "わ" => [
                'kana' => 'wa',
                'sound_file' => 'wa.wav'
            ],
            "ん" => [
                'kana' => 'n',
                'sound_file' => 'n.wav'
            ],
            "を" => [
                'kana' => 'wo',
                'sound_file' => 'wo.wav'
            ],

            // KATAKANAS
            "ア" => [
                'kana' => 'a',
                'sound_file' => 'a.wav'
            ],
            "イ" => [
                'kana' => 'i',
                'sound_file' => 'i.wav'
            ],
            "ウ" => [
                'kana' => 'u',
                'sound_file' => 'u.wav'
            ],
            "エ" => [
                'kana' => 'e',
                'sound_file' => 'e.wav'
            ],
            'オ' => [
                'kana' => 'o',
                'sound_file' => 'o.wav'
            ],
            "カ" => [
                'kana' => 'ka',
                'sound_file' => 'ka.wav'
            ],
            "キ" => [
                'kana' => 'ki',
                'sound_file' => 'ki.wav'
            ],
            "ク" => [
                'kana' => 'ku',
                'sound_file' => 'ku.wav'
            ],
            "ケ" => [
                'kana' => 'ke',
                'sound_file' => 'ke.wav'
            ],
            "コ" => [
                'kana' => 'ko',
                'sound_file' => 'ko.wav'
            ],
            "サ" => [
                'kana' => 'sa',
                'sound_file' => 'sa.wav'
            ],
            "シ" => [
                'kana' => 'shi',
                'sound_file' => 'shi.wav'
            ],
            "ツ" => [
                'kana' => 'tsu',
                'sound_file' => 'tsu.wav'
            ],
            "セ" => [
                'kana' => 'se',
                'sound_file' => 'se.wav'
            ],
            "ソ" => [
                'kana' => 'so',
                'sound_file' => 'so.wav'
            ],
            'ガ' => [
                'kana' => 'ga',
                'sound_file' => 'ka-dakuten.wav'
            ],
            'ギ' => [
                'kana' => 'gi',
                'sound_file' => 'ki-dakuten.wav'
            ],
            'グ' => [
                'kana' => 'gu',
                'sound_file' => 'ku-dakuten.wav'
            ],
            'ゲ' => [
                'kana' => 'ge',
                'sound_file' => 'ke-dakuten.wav'
            ],
            'ゴ' => [
                'kana' => 'go',
                'sound_file' => 'ko-dakuten.wav'
            ],
            "タ" => [
                'kana' => 'ta',
                'sound_file' => 'ta.wav'
            ],
            "チ" => [
                'kana' => 'chi',
                'sound_file' => 'chi.wav'
            ],
            "ス" => [
                'kana' => 'su',
                'sound_file' => 'su.wav'
            ],
            "テ" => [
                'kana' => 'te',
                'sound_file' => 'te.wav'
            ],
            "ト" => [
                'kana' => 'to',
                'sound_file' => 'to.wav'
            ],
            'ザ' => [
                'kana' => 'za',
                'sound_file' => 'sa-dakuten.wav'
            ],
            'ジ' => [
                'kana' => 'ji',
                'sound_file' => 'shi-dakuten.wav'
            ],
            'ズ' => [
                'kana' => 'zu',
                'sound_file' => 'su-dakuten.wav'
            ],
            'ゼ' => [
                'kana' => 'ze',
                'sound_file' => 'se-dakuten.wav'
            ],
            'ゾ' => [
                'kana' => 'zo',
                'sound_file' => 'so-dakuten.wav'
            ],
            "ナ" => [
                'kana' => 'na',
                'sound_file' => 'na.wav'
            ],
            "ニ" => [
                'kana' => 'ni',
                'sound_file' => 'ni.wav'
            ],
            "ヌ" => [
                'kana' => 'nu',
                'sound_file' => 'nu.wav'
            ],
            "ネ" => [
                'kana' => 'ne',
                'sound_file' => 'ne.wav'
            ],
            "ノ" => [
                'kana' => 'no',
                'sound_file' => 'no.wav'
            ],
            'ダ' => [
                'kana' => 'da',
                'sound_file' => 'ta-dakuten.wav'
            ],
            'ヂ' => [
                'kana' => 'ji',
                'sound_file' => 'chi-dakuten.wav'
            ],
            'ヅ' => [
                'kana' => 'zu',
                'sound_file' => 'tsu-dakuten.wav'
            ],
            'デ' => [
                'kana' => 'de',
                'sound_file' => 'te-dakuten.wav'
            ],
            'ド' => [
                'kana' => 'do',
                'sound_file' => 'to-dakuten.wav'
            ],
            "ハ" => [
                'kana' => 'ha',
                'sound_file' => 'ha.wav'
            ],
            "ヒ" => [
                'kana' => 'hi',
                'sound_file' => 'hi.wav'
            ],
            "フ" => [
                'kana' => 'hu',
                'sound_file' => 'hu.wav'
            ],
            "ヘ" => [
                'kana' => 'he',
                'sound_file' => 'he.wav'
            ],
            "ホ" => [
                'kana' => 'ho',
                'sound_file' => 'ho.wav'
            ],
            "マ" => [
                'kana' => 'ma',
                'sound_file' => 'ma.wav'
            ],
            "ミ" => [
                'kana' => 'mi',
                'sound_file' => 'mi.wav'
            ],
            "ム" => [
                'kana' => 'mu',
                'sound_file' => 'mu.wav'
            ],
            "メ" => [
                'kana' => 'me',
                'sound_file' => 'me.wav'
            ],
            "モ" => [
                'kana' => 'mo',
                'sound_file' => 'mo.wav'
            ],
            'バ' => [
                'kana' => 'ba',
                'sound_file' => 'ha-dakuten.wav'
            ],
            'ビ' => [
                'kana' => 'bi',
                'sound_file' => 'hi-dakuten.wav'
            ],
            'ブ' => [
                'kana' => 'bu',
                'sound_file' => 'hu-dakuten.wav'
            ],
            'ベ' => [
                'kana' => 'be',
                'sound_file' => 'he-dakuten.wav'
            ],
            'ボ' => [
                'kana' => 'bo',
                'sound_file' => 'ho-dakuten.wav'
            ],
            'パ' => [
                'kana' => 'pa',
                'sound_file' => 'ha-handakuten.wav'
            ],
            'ピ' => [
                'kana' => 'pi',
                'sound_file' => 'hi-handakuten.wav'
            ],
            'プ' => [
                'kana' => 'pu',
                'sound_file' => 'hu-handakuten.wav'
            ],
            'ペ' => [
                'kana' => 'pe',
                'sound_file' => 'he-handakuten.wav'
            ],
            'ポ' => [
                'kana' => 'po',
                'sound_file' => 'ho-handakuten.wav'
            ],
            "ヤ" => [
                'kana' => 'ya',
                'sound_file' => 'ya.wav'
            ],
            "ユ" => [
                'kana' => 'yu',
                'sound_file' => 'yu.wav'
            ],
            "ヨ" => [
                'kana' => 'yo',
                'sound_file' => 'yo.wav'
            ],
            "ラ" => [
                'kana' => 'ra',
                'sound_file' => 'ra.wav'
            ],
            "リ" => [
                'kana' => 'ri',
                'sound_file' => 'ri.wav'
            ],
            "ル" => [
                'kana' => 'ru',
                'sound_file' => 'ru.wav'
            ],
            "レ" => [
                'kana' => 're',
                'sound_file' => 're.wav'
            ],
            "ロ" => [
                'kana' => 'ro',
                'sound_file' => 'ro.wav'
            ],
            "ワ" => [
                'kana' => 'wa',
                'sound_file' => 'wa.wav'
            ],
            "ン" => [
                'kana' => 'n',
                'sound_file' => 'n.wav'
            ],

//            'きゃ' => 'kya',	'キャ' => 'kya',	'きゅ' => 'kyu',	'キュ' => 'kyu',	'きょ' => 'kyo',	'キョ' => 'kyo',
//            'ぎゃ' => 'gya',	'ギャ' => 'gya',	'ぎゅ' => 'gyu',	'ギュ' => 'gyu',	'ぎょ' => 'gyo',	'ギョ' => 'gyo',
//            'しゃ' => 'sha',	'シャ' => 'sha',	'しゅ' => 'shu',	'シュ' => 'shu',	'しょ' => 'sho',	'ショ' => 'sho',
//            'じゃ' => 'ja',	    'ジャ' => 'ja',	    'じゅ' => 'ju',	    'ジュ' => 'ju',	    'じょ' => 'jo',	    'ジョ' => 'jo',
//            'ちゃ' => 'cha',	'チャ' => 'cha',	'ちゅ' => 'chu',	'チュ' => 'chu',	'ちょ' => 'cho',	'チョ' => 'cho',
//            'にゃ' => 'nya',	'ニャ' => 'nya',	'にゅ' => 'nyu',	'ニュ' => 'nyu',	'にょ' => 'nyo',	'ニョ' => 'nyo',
//            'ひゃ' => 'hya',	'ヒャ' => 'hya',	'ひゅ' => 'hyu',	'ヒュ' => 'hyu',	'ひょ' => 'hyo',	'ヒョ' => 'hyo',
//            'びゃ' => 'bya',	'ビャ' => 'bya',	'びゅ' => 'byu',	'ビュ' => 'byu',	'びょ' => 'byo',	'ビョ' => 'byo',
//            'ぴゃ' => 'pya',	'ピャ' => 'pya',	'ぴゅ' => 'pyu',	'ピュ' => 'pyu',	'ぴょ' => 'pyo',	'ピョ' => 'pyo',
//            'みゃ' => 'mya',	'ミャ' => 'mya',	'みゅ' => 'myu',	'ミュ' => 'myu',	'みょ' => 'myo',	'ミョ' => 'myo',
//            'りゃ' => 'rya',	'リャ' => 'rya',	'りゅ' => 'ryu',	'リュ' => 'ryu',	'りょ' => 'ryo',	'リョ' => 'ryo',
        ];

        $i = 0;
        foreach($kanas as $kana => $romaji){
            $kana = new \App\Models\Kana([
                'kana' => $kana,
                'romaji' => $romaji['kana'],
                'learn_order' => $i,
                'sound_file' => '/sound/kanas/' . $romaji['sound_file']
            ]);
            $kana->save();

            $i += 1;
        }
    }
}
