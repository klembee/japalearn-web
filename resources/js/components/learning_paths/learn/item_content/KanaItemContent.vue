<template>
    <div>
        <div class="row">
            <div class="col-md-3 col-12">
                <div>
                    <p class="h4 mt-0">Romaji: {{item.romaji}}</p>

                    <div>
                        <p class="d-inline">Listen: </p>
                        <md-button @click="playSound" class="md-icon-button md-raised d-inline">
                            <md-icon>volume_up</md-icon>
                        </md-button>
                    </div>

                </div>
            </div>
            <div class="col-md-9 col-12">
                <h3><b>How to remember this kana: </b></h3>
                <div v-if="item.mnemonic">
                    <div v-html="parsedMnemonic"></div>
                </div>
                <div v-else>
                    <p>This item does not have a mnemonic yet.</p>
                </div>
            </div>
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
