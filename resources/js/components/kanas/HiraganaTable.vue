<template>
    <div>
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
                    <td class="clickable">ん</td>
                    <td class="clickable">わ</td>
                    <td class="clickable">ら</td>
                    <td class="clickable">や</td>
                    <td class="clickable">ま</td>
                    <td class="clickable">は</td>
                    <td class="clickable">な</td>
                    <td class="clickable">た</td>
                    <td class="clickable">さ</td>
                    <td class="clickable">か</td>
                    <td class="clickable" @click="playSound('a')">あ</td>
                    <td>A</td>
                </tr>
                <!-- I -->
                <tr>
                    <td></td>
                    <td></td>
                    <td class="clickable">り</td>
                    <td></td>
                    <td class="clickable">み</td>
                    <td class="clickable">ひ</td>
                    <td class="clickable">に</td>
                    <td class="clickable">ち</td>
                    <td class="clickable">し</td>
                    <td class="clickable">き</td>
                    <td class="clickable" @click="playSound('i')">い</td>
                    <td>I</td>
                </tr>

                <!-- u -->
                <tr>
                    <td></td>
                    <td></td>
                    <td class="clickable">る</td>
                    <td class="clickable">ゆ</td>
                    <td class="clickable">む</td>
                    <td class="clickable">ふ</td>
                    <td class="clickable">ぬ</td>
                    <td class="clickable">つ</td>
                    <td class="clickable">す</td>
                    <td class="clickable">く</td>
                    <td class="clickable" @click="playSound('u')">う</td>
                    <td>U</td>
                </tr>

                <!-- e -->
                <tr>
                    <td></td>
                    <td></td>
                    <td class="clickable">れ</td>
                    <td></td>
                    <td class="clickable">め</td>
                    <td class="clickable">へ</td>
                    <td class="clickable">ね</td>
                    <td class="clickable">て</td>
                    <td class="clickable">せ</td>
                    <td class="clickable">け</td>
                    <td class="clickable" @click="playSound('e')">え</td>
                    <td>E</td>
                </tr>

                <!-- o -->
                <tr>
                    <td></td>
                    <td class="clickable">を</td>
                    <td class="clickable">ろ</td>
                    <td class="clickable">よ</td>
                    <td class="clickable">も</td>
                    <td class="clickable">ほ</td>
                    <td class="clickable">の</td>
                    <td class="clickable">と</td>
                    <td class="clickable">そ</td>
                    <td class="clickable">こ</td>
                    <td class="clickable" @click="playSound('o')">お</td>
                    <td>O</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "HiraganaTable",
        methods: {
            playSound(romaji){
                var audio = new Audio('/sound/kanas/' + romaji + ".wav");
                audio.play();
            }
        }
    }
</script>

<style scoped>
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
