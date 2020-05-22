<template>
    <div>
        <div v-show="isLoading" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div>
            <h2 class="mb-3">Level {{level}} progress</h2>
            <md-card v-for="kanji in kanjis" :key="kanji.id" class="kanji-card mb-2">
                <h2 class="word">{{kanji.word}}</h2>
                <level-indicator :nb-levels="5" :level="kanji.student_level"></level-indicator>
            </md-card>
        </div>
    </div>
</template>

<script>
    import LevelIndicator from "../LevelIndicator";
    export default {
        name: "KanjiCurrentLevelOverview",
        components: {LevelIndicator},
        props: {
            fetchDataEndpoint: {
                type: String,
                required: true
            },
            level: {
                type: Number,
                required: true
            }
        },
        data: function(){
            return {
                isLoading: true,
                kanjis: [],
            }
        },
        methods: {
            fetchData(){

                let self = this;
                axios.get(this.fetchDataEndpoint)
                    .then(function(response){
                        if(response.data.success){
                            self.kanjis = response.data.kanjis;
                        }else{
                            console.error("Failed to fetch kanji level data !");
                        }
                        self.isLoading = false;
                    })
                    .catch(function(error){
                        self.isLoading = false;
                        console.error("Failed to fetch kanji level data !");
                    })
            }
        },
        mounted() {
            this.fetchData();
        }
    }
</script>

<style scoped>
    .kanji-card{
        width:fit-content;
        padding:10px;
        display:inline-block;
    }

    .kanji-card .level{
        display:inline;
    }

    .kanji-card .word{
        display:block;
        text-align: center;
    }

</style>
