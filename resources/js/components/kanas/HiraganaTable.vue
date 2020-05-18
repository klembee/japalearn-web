<template>
    <div class="hiragana-content">
        <table class="table">
            <thead>
                <tr>
                    <td>n</td>
                    <td>w-</td>
                    <td>r-</td>
                    <td>y-</td>
                    <td>m-</td>
                    <td>h-</td>
                    <td>n-</td>
                    <td>t-</td>
                    <td>s-</td>
                    <td>k-</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <!-- A -->
                <tr>
                    <kana-cell :kana="getKana('ん')"></kana-cell>
                    <kana-cell :kana="getKana('わ')"></kana-cell>
                    <kana-cell :kana="getKana('ら')"></kana-cell>
                    <kana-cell :kana="getKana('や')"></kana-cell>
                    <kana-cell :kana="getKana('ま')"></kana-cell>
                    <kana-cell :kana="getKana('は')"></kana-cell>
                    <kana-cell :kana="getKana('な')"></kana-cell>
                    <kana-cell :kana="getKana('た')"></kana-cell>
                    <kana-cell :kana="getKana('さ')"></kana-cell>
                    <kana-cell :kana="getKana('か')"></kana-cell>
                    <kana-cell :kana="getKana('あ')"></kana-cell>
                    <td>A</td>
                </tr>
                <!-- I -->
                <tr>
                    <td></td>
                    <td></td>
                    <kana-cell :kana="getKana('り')"></kana-cell>
                    <td></td>
                    <kana-cell :kana="getKana('み')"></kana-cell>
                    <kana-cell :kana="getKana('ひ')"></kana-cell>
                    <kana-cell :kana="getKana('に')"></kana-cell>
                    <kana-cell :kana="getKana('ち')"></kana-cell>
                    <kana-cell :kana="getKana('し')"></kana-cell>
                    <kana-cell :kana="getKana('き')"></kana-cell>
                    <kana-cell :kana="getKana('い')"></kana-cell>
                    <td>I</td>
                </tr>

                <!-- u -->
                <tr>
                    <td></td>
                    <td></td>
                    <kana-cell :kana="getKana('る')"></kana-cell>
                    <kana-cell :kana="getKana('ゆ')"></kana-cell>
                    <kana-cell :kana="getKana('む')"></kana-cell>
                    <kana-cell :kana="getKana('ふ')"></kana-cell>
                    <kana-cell :kana="getKana('ぬ')"></kana-cell>
                    <kana-cell :kana="getKana('つ')"></kana-cell>
                    <kana-cell :kana="getKana('す')"></kana-cell>
                    <kana-cell :kana="getKana('く')"></kana-cell>
                    <kana-cell :kana="getKana('う')"></kana-cell>
                    <td>U</td>
                </tr>

                <!-- e -->
                <tr>
                    <td></td>
                    <td></td>
                    <kana-cell :kana="getKana('れ')"></kana-cell>
                    <td></td>
                    <kana-cell :kana="getKana('め')"></kana-cell>
                    <kana-cell :kana="getKana('へ')"></kana-cell>
                    <kana-cell :kana="getKana('ね')"></kana-cell>
                    <kana-cell :kana="getKana('て')"></kana-cell>
                    <kana-cell :kana="getKana('せ')"></kana-cell>
                    <kana-cell :kana="getKana('け')"></kana-cell>
                    <kana-cell :kana="getKana('え')"></kana-cell>
                    <td>E</td>
                </tr>

                <!-- o -->
                <tr>
                    <td></td>
                    <kana-cell :kana="getKana('を')"></kana-cell>
                    <kana-cell :kana="getKana('ろ')"></kana-cell>
                    <kana-cell :kana="getKana('よ')"></kana-cell>
                    <kana-cell :kana="getKana('も')"></kana-cell>
                    <kana-cell :kana="getKana('ほ')"></kana-cell>
                    <kana-cell :kana="getKana('の')"></kana-cell>
                    <kana-cell :kana="getKana('と')"></kana-cell>
                    <kana-cell :kana="getKana('そ')"></kana-cell>
                    <kana-cell :kana="getKana('こ')"></kana-cell>
                    <kana-cell :kana="getKana('お')"></kana-cell>
                    <td>O</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import KanaCell from "./KanaCell";
    export default {
        name: "HiraganaTable",
        components: {KanaCell},
        props: {
            kanas: {
                type: Array,
                required: true
            },
            isKatakana: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            getKana(kana){
                if(this.isKatakana){
                    // Add x to unicode
                    let a = 96;

                    kana = String.fromCharCode(kana.charCodeAt(0) + a);
                }

                return this.kanas.filter(k => k.kana === kana)[0];
            }
        }
    }
</script>

<style scoped>
    .hiragana-content{
        width:100%;
        overflow-x: auto;
    }

    td{
        -webkit-user-select: none; /* Safari */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* IE10+/Edge */
        user-select: none;
    }
    td:hover{
        background-color: #e1e1e1;
    }
</style>
