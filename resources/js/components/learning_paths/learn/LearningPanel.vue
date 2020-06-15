<template>
    <div>
        <div class="row">
            <md-content class="col-md-10 col-12">
                <div class="item-word">
                    <p>{{this.currentItem[itemTextProperty]}}</p>
                </div>
                <div class="item-content">
                    <div :class="{invisible: !canGoLeft}" class="prev-button">
                        <md-button @click="prevItem()" class="md-icon-button">
                            <md-icon class="md-size-4x">keyboard_arrow_left</md-icon>
                        </md-button>
                    </div>

                    <!-- ICI -->
                    <component :item="currentItem" :is="itemContentComponent" style="width:100%;">

                    </component>

                    <div class="next-button">
                        <md-button @click="nextItem()" class="md-icon-button">
                            <md-icon class="md-size-4x">keyboard_arrow_right</md-icon>
                        </md-button>
                    </div>
                </div>
            </md-content>

            <!-- Map -->
            <md-content class="col-md-2 d-none d-lg-block">
                <md-card  v-for="item in itemsBeforeReview" :key="item.id">
                    <md-card-content class="map-item" :class="{active: item.id === currentItem.id}">
                        <p class="map-item-word">{{item[itemTextProperty]}}</p>
                    </md-card-content>
                </md-card>
                <md-card>
                    <md-card-content>
                        <p class="map-item-word" style="font-size: 1.5vw;">Review</p>
                    </md-card-content>
                </md-card>
                <md-card  v-for="item in itemsAfterReview" :key="item.id">
                    <md-card-content class="map-item">
                        <p class="map-item-word">{{item[itemTextProperty]}}</p>
                    </md-card-content>
                </md-card>
            </md-content>
        </div>

        <back-drop
            v-show="readyForReview"
            title="Move to review ?">

            <p>Are you ready to review the items you just learned ?</p>
            <template v-slot:actions>
                <md-button @click="readyForReview = false" class="md-raised">wait</md-button>
                <md-button @click="startReview()" class="md-raised">Go to review</md-button>
            </template>
        </back-drop>
    </div>
</template>

<script>

    import BackDrop from "../../BackDrop";
    import VocabItemContent from "./item_content/VocabItemContent";
    import KanaItemContent from "./item_content/KanaItemContent";

    export default {
        name: "LearningPanel",
        components: {VocabItemContent, KanaItemContent, BackDrop},
        props:{
            items: {
                type: Array,
                required: true
            },
            type: {
                type: String,
                default: "vocab"
            },
            currentChunk: {
                type: Number,
                default: 0
            },
        },
        data: function(){
            return {
                currentItemIndex: 0,

                numberItemsDone: 0,
                numberItemsBeforeReview: 5,
                readyForReview: false
            }
        },
        computed: {
            itemTextProperty(){
                if(this.type === 'vocab'){
                    return 'word';
                }else if(this.type === 'kana'){
                    return 'kana';
                }
            },
            itemContentComponent(){
                if(this.type === 'vocab'){
                    return 'VocabItemContent';
                }else if(this.type === 'kana'){
                    return 'KanaItemContent';
                }
            },
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

                let numberToSplit = 0;
                if(this.currentItemIndex == 0){
                    numberToSplit = 1;
                }

                return _.clone(this.items[this.currentChunk + 1]).splice(0, this.currentItemIndex + numberToSplit);
            },
            canGoLeft: function(){
                return this.currentItemIndex > 0
            }
        },
        methods: {
            nextItem: function(){
                if(this.numberItemsDone + 1 >=  Math.min(this.numberItemsBeforeReview, this.items[this.currentChunk].length)){
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

    .prev-button{
        margin-right:20px;
    }
    .next-button{
        margin-left:20px;
    }

    @media screen and (max-width: 600px){
        .prev-button{
            margin-right:0;
        }
        .next-button{
            margin-left:0;
        }
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
        background-color:#99D0F2;
    }
</style>
