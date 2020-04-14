<template>
    <div>
        <div class="row">
            <md-content class="col-md-10">
                <div class="item-word">
                    <p>{{currentItem.word}}</p>
                </div>
                <div class="item-content">
                    <div :class="{invisible: !canGoLeft}" class="prev-button">
                        <md-button @click="prevItem()" class="md-icon-button">
                            <md-icon class="md-size-4x">keyboard_arrow_left</md-icon>
                        </md-button>
                    </div>
                    <b-tabs class="tabs" v-model="activeTab" align="center">
                        <!-- Tab only used for kanjis -->
                        <b-tab v-if="currentItem.word_type_id == 2" id="tab-radicals" title="Radicals">
                            <!-- Radicals in the kanji -->

                        </b-tab>

                        <b-tab id="tab-meaning" title="Meaning">
                            <p v-for="meaning in currentItem.meanings" :key="meaning.id">
                                {{meaning.meaning}}
                            </p>

                        </b-tab>

                        <!-- Not used for radicals -->
                        <b-tab v-if="currentItem.word_type_id != 1" id="tab-readings" title="Readings">
                            <p v-for="reading in currentItem.readings" :key="reading.id">
                                {{reading.reading}}
                            </p>
                        </b-tab>

                        <b-tab id="tab-examples" title="Examples">
                            <p>Examples</p>
                        </b-tab>
                    </b-tabs>
                    <div class="next-button">
                        <md-button @click="nextItem()" class="md-icon-button">
                            <md-icon class="md-size-4x">keyboard_arrow_right</md-icon>
                        </md-button>
                    </div>
                </div>
            </md-content>
            <!-- Map -->
            <md-content class="col-md-2">
                <md-card  v-for="item in itemsBeforeReview" :key="item.id">
                    <md-card-content class="map-item" :class="{active: item.id === currentItem.id}">
                        <p class="map-item-word">{{item.word}}</p>
                    </md-card-content>
                </md-card>
                <md-card>
                    <md-card-content>
                        <p class="map-item-word">Review</p>
                    </md-card-content>
                </md-card>
                <md-card  v-for="item in itemsAfterReview" :key="item.id">
                    <md-card-content class="map-item">
                        <p class="map-item-word">{{item.word}}</p>
                    </md-card-content>
                </md-card>
            </md-content>
        </div>

        <back-drop
            v-show="readyForReview"
            title="Move to review ?"
        >
            <p>asdfasdf</p>
            <template v-slot:actions>
                <md-button @click="readyForReview = false" class="md-raised">wait</md-button>
                <md-button @click="startReview()" class="md-raised">Go to review</md-button>
            </template>
        </back-drop>
    </div>
</template>

<script>

    import BackDrop from "../BackDrop";
    export default {
        name: "LearningPanel",
        components: {BackDrop},
        props:{
            items: {
                type: Array,
                required: true
            }
        },
        data: function(){
            return {
                activeTab: 0,
                currentItemIndex: 0,
                currentChunk: 0,
                numberItemsDone: 0,
                numberItemsBeforeReview: 5,
                readyForReview: false
            }
        },
        computed: {
            currentItem(){
                return this.items[this.currentChunk][this.currentItemIndex];
            },
            itemsBeforeReview(){
                let from = this.currentItemIndex - 1;
                if(from < 0){
                    from = 0;
                }
                return _.clone(this.items[this.currentChunk]).splice(from)
            },
            itemsAfterReview(){
                if(this.currentChunk + 1 >= this.items.length){
                    return [];
                }
                return _.clone(this.items[this.currentChunk + 1]).splice(0, this.currentItemIndex + 1);
            },
            canGoLeft: function(){
                return this.currentItemIndex > 0
            }
        },
        methods: {
            nextItem: function(){
                if(this.numberItemsDone + 1 >= this.numberItemsBeforeReview){
                    this.readyForReview = true
                }else{
                    this.currentItemIndex++;
                    this.numberItemsDone++;

                    this.openFirstTab()
                }
            },
            prevItem: function(){
                if(this.canGoLeft) {
                    this.currentItemIndex--;
                    this.numberItemsDone--;

                    this.openFirstTab();
                }
            },
            openFirstTab: function(){
                if(this.currentItem.word_type_id === 1){
                    this.activeTab = 0;
                }else{
                    this.activeTab = 1;
                }
            },
            startReview: function(){
                this.numberItemsDone = 0;
                this.$emit('do-review', this.currentChunk)
            }
        }
    }
</script>

<style scoped>
    .item-content{
        width: 65%;
        margin: auto;
        display:flex;
        align-items: center;
    }

    .prev-button{
        margin-right:20px;
    }
    .next-button{
        margin-left:20px;
    }

    .tabs{
        flex-grow: 1;
    }

    .map-item-word{
        text-align: center;
        font-size: 4em;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    .map-item.active{
        background-color:#007BFF;
    }
</style>
