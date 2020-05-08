<template>
    <div>
        <div class="d-flex">
            <h2>Romaji: {{item.romaji}}</h2>
            <md-button @click="playSound" class="md-icon-button md-raised">
                <md-icon>volume_up</md-icon>
            </md-button>
        </div>
        <hr/>
        <div v-if="item.mnemonic">
            <h3><b>How to remember this kana: </b></h3>
            <div v-html="parsedMnemonic"></div>
        </div>

    </div>
</template>

<script>
    import marked from "marked";

    export default {
        name: "KanaItemContent",
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        computed: {
            parsedMnemonic: function(){
                return marked(this.item.mnemonic);
            }
        },
        methods: {
            playSound: _.debounce(function(){
                var audio = new Audio(this.item.sound_file);
                audio.play();
            }, 300)
        }
    }
</script>

<style scoped>

</style>
