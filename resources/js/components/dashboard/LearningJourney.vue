<template>
    <div>
        <h2>Your learning journey</h2>
        <div class="d-flex align-items-center">
            <!-- Kanas -->
            <div @click="redirectToKana" class="learning-journey-item">
                <div v-if="doneBasicKanas">
                    <p>Kanas</p>
                    <md-icon>check_circle</md-icon>
                </div>
                <div v-else-if="currentlyLearningKanas" class="currently_learning">
                    <p>Learn the kanas</p>
                    <md-icon>check_circle_outline</md-icon>
                </div>
            </div>

            <div class="learning-journey-item-divisor d-none d-md-block">

            </div>

            <!-- Grammar -->
            <div class="learning-journey-item">
                <div v-if="doneBasicGrammar">
                    <p>Basic grammar</p>
                    <md-icon>check_circle</md-icon>
                </div>
                <div v-else-if="currentlyLearningGrammar" class="currently_learning">
                    <p>Learn basic grammar</p>
                    <md-icon>check_circle_outline</md-icon>
                </div>
                <div v-else>
                    <p>Basic grammar</p>
                    <md-icon>check_circle_outline</md-icon>
                </div>
            </div>

            <div class="learning-journey-item-divisor d-none d-sm-block">

            </div>

            <!-- Kanji and Voc lvl 3 -->
            <div class="learning-journey-item">
                <div v-if="doneBasicKanjis">
                    <p>Kanjis (level 3)</p>
                    <md-icon>check_circle</md-icon>
                </div>
                <div v-else-if="currentlyLearningKanjis" class="currently_learning">
                    <p>Learn kanjis to level 3</p>
                    <md-icon>check_circle_outline</md-icon>
                </div>
                <div v-else>
                    <p>Kanjis (level 3)</p>
                    <md-icon>check_circle_outline</md-icon>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LearningJourney",
        props: {
            doneBasicKanas: {
                type: Boolean,
                default: false
            },
            doneBasicGrammar: {
                type: Boolean,
                default: false
            },
            doneBasicKanjis: {
                type: Boolean,
                default: false
            },
            kanaUrl: {
                type: String,
                required: true
            }
        },
        computed: {
            currentlyLearningKanas() {
                return !this.doneBasicKanas;
            },
            currentlyLearningGrammar(){
                return this.doneBasicKanas && !this.doneBasicGrammar;
            },
            currentlyLearningKanjis(){
                return this.doneBasicKanas && this.doneBasicGrammar && !this.doneBasicKanjis;
            }
        },
        methods:{
            redirectToKana: function(){
                window.location.href = this.kanaUrl;
            }
        }
    }
</script>

<style scoped>
    .learning-journey-item{
        text-align:center;
        cursor: pointer;
    }
    .learning-journey-item > div{
        padding:1rem;
    }
    .learning-journey-item p{
        margin-bottom:0;
    }
    .learning-journey-item-divisor{
        flex-grow: 1;
        height: 2px;
        border: 1px solid #151515;
    }
    .currently_learning{
        border:1px solid #151515;
        border-radius: 5px;
        color: #F2F2F2;
        background-color:#325259;
    }
    .currently_learning .md-icon{
        color: inherit !important;
    }

    .currently_learning > p{
        display:inline;
    }
</style>
