<template>
    <td :style="levelStyle" class="clickable" @click="playSound">
        <span v-if="kana">{{kana.kana}}</span>
        <md-tooltip v-if="kana" md-direction="bottom">Level {{kana.level}}</md-tooltip>
    </td>
</template>

<script>
    export default {
        name: "KanaCell",
        props: {
            kana: {
                required: true
            }
        },
        computed: {
            levelStyle(){
                var color = "#ffffff";

                if(this.kana) {
                    if (this.kana.level === 1) {
                        color = "#ff47003d";
                    } else if (this.kana.level === 2) {
                        color = "#ffa5003d";
                    } else if (this.kana.level === 3) {
                        color = "#fff7003d";
                    } else if (this.kana.level === 4) {
                        color = "#91ff003d";
                    } else if (this.kana.level === 5) {
                        color = "#10ff003d";
                    }
                }

                return {
                    "background-color": color
                }
            }
        },
        methods: {
            playSound(){
                if(this.kana) {
                    var audio = new Audio(this.kana.sound_file);
                    audio.play();
                }
            }
        }
    }
</script>

<style scoped>

</style>
