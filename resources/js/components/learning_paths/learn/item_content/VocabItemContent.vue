<template>
    <b-tabs class="tabs" v-model="activeTab" align="center">
        <!-- Tab only used for kanjis -->
<!--        <b-tab v-if="item.word_type_id === 2" id="tab-radicals" title="Radicals">-->
<!--            &lt;!&ndash; Radicals in the kanji &ndash;&gt;-->

<!--        </b-tab>-->

        <b-tab id="tab-meaning" title="Meaning">
            <div class="row mt-4">
                <div class="col-md-3 col-12">
                    <h3>Type</h3>
                    <p class="text-capitalize font-weight-bold">{{item.type}}</p>
                    <hr/>
                    <h3>Meanings</h3>
                    <ul>
                        <li :class="{'isMain': meaning.is_main}" v-for="meaning in sortedMeanings" :key="meaning.id" class="text-capitalize">{{meaning.meaning}}</li>
                    </ul>
                    <hr />
                    <h3>Readings</h3>
                    <h4>On</h4>
                    <div v-if="orderedOnReadings.length > 0">
                        <ul>
                            <li :class="{'isMain': reading.is_main}" v-for="reading in orderedOnReadings" :key="reading.id">
                                {{reading.reading}}
                            </li>
                        </ul>
                    </div>


                    <div v-if="orderedKunReadings.length > 0">
                        <h4>Kun</h4>
                        <ul>
                            <li :class="{'isMain': reading.is_main}" v-for="reading in orderedKunReadings" :key="reading.id">
                                {{reading.reading}}
                            </li>
                        </ul>
                    </div>


                </div>
                <div class="col-md-9 col-12 mnemonic">
                    <div class="mnemonic-content">
                        <h3>Tip for remembering</h3>
                        <div v-html="meaningMnemonic">

                        </div>
                    </div>

                    <p>JapaLearn comes with Ulrike's Mnemonics, which were provided by <a href="https://www.joyokanji.com/">Joy o' Kanji</a>, a site where you can find playful, informative, photo-filled essays about each of the 2,136 Joyo kanji.</p>
                </div>
            </div>

        </b-tab>

        <b-tab id="tab-examples" title="Examples">
            <p>Examples</p>
        </b-tab>
    </b-tabs>
</template>

<script>
    import marked from "marked"

    export default {
        name: "VocabItemContent",
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        data: function(){
            return {
                activeTab: 0,
            }
        },
        computed: {
            sortedMeanings(){
                // show main meaning first
                return this.item.meanings.sort(function(a, b){
                    if(a.is_main){
                        return -1;
                    }
                    return 1;
                });
            },
            meaningMnemonic(){
                if(this.item.meaning_mnemonic) {
                    return marked(this.item.meaning_mnemonic);
                }else{
                    return "";
                }
            },
            orderedOnReadings(){
                if(this.item.on_readings){
                    return this.item.on_readings.sort(function(x, y){
                        if(x.is_main){
                            return -1;
                        }else{
                            return 1;
                        }
                    })
                }else{
                    return []
                }

            },
            orderedKunReadings(){
                if(this.item.kun_readings){
                    return this.item.kun_readings.sort(function(x, y){
                        if(x.is_main){
                            return -1;
                        }else{
                            return 1;
                        }
                    })
                }else{
                    return []
                }
            },
            orderedMeanings(){
                return this.item.meanings.sort(function(x, y){
                    if(x.is_main){
                        return -1;
                    }else{
                        return 1;
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .mnemonic{
        display:flex;
        flex-direction: column;
    }
    /deep/ .mnemonic-content p{
        font-size: 1.3em;
        word-break: keep-all;
    }
    .mnemonic-content{
        flex-grow: 1;
    }

    /deep/ .mnemonic-content b{
        color:#4881a5;
    }

    .isMain{
        color: #D93636;
        font-size:1.3em;
    }
</style>
