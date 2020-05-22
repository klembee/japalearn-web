<template>
    <div>
        <div class="story-image">
            <img :src="'/storage/' + story.front_image_url"/>
        </div>
        <div class="story">
            <h1 class="text-center mb-4">{{story.title}}</h1>
            <div v-if="story.description" class="description">
                {{story.description}}
            </div>
            <div class="story-text">
                <span v-for="i in phrases.length">
                    <span v-html="phrases[i - 1]" :id="'phrase-'+(i-1)" class="phrase"></span>
                    <div v-if="i <= translatedPhrases.length" :id="'translation-'+(i-1)" style="display: none;"  class="translation">
                        <md-icon>arrow_upward</md-icon>
                        <span v-html="translatedPhrases[i - 1]"></span>
                    </div>

                </span>

            </div>
        </div>
    </div>
</template>

<script>
    import marked from 'marked'
    export default {
        name: "StoryReader",
        props: {
            story: {
                type: Object,
                required: true
            }
        },
        data: function(){
            return {
                formatedContent: "",
                phrases: [],
                translatedPhrases: [],
            }
        },
        methods:{
            translate: function(japanese){
                return this.story.translations.filter(translation => translation.japanese === japanese)[0].translation;
            }
        },
        mounted() {
            this.formatedContent = marked(this.story.content);
            this.phrases = this.formatedContent.split('\n');

            if(this.story.translated_content) {
                let formatedTranslation = marked(this.story.translated_content);
                this.translatedPhrases = formatedTranslation.split('\n');
                this.translatedPhrases = this.translatedPhrases.filter(phrase => phrase !== '')
            }

            // Setup the click to get translation feature
            let self = this;

            $("body").delegate(".phrase p", 'click', function() {
                let phrase_id = $(this).closest('span').attr('id');
                let index = parseInt(phrase_id.split('-')[1]);

                $("#translation-" + index).toggle()
            });
            //     $("#translation").remove();
            //     // $('p[is-showing-translation="true"]').removeAttr("is-showing-translation");
            //
            //     // if($(this).attr('is-showing-translation') && $(this).attr('is-showing-translation') === "true"){
            //     //     $(this).attr('is-showing-translation', "false");
            //     // }else{
            //         let translation = self.translate($(this).text());
            //         if(translation !== "") {
            //
            //             $(this).attr('is-showing-translation', "true");
            //
            //             let offset = $(this).offset();
            //
            //             // Show the translation on top of the phrase
            //             $(this).append("<p id='translation'>" + translation + "</p>");
            //
            //             offset.left -= $(this).width();
            //             // For some reason I have to remove the height of the image
            //             offset.top -= $(".story-image").height();
            //
            //             let fontSize = parseFloat(getComputedStyle(this).fontSize);
            //             offset.top -= fontSize;
            //
            //             offset.top -= $("#translation").height();
            //             $("#translation").css(offset);
            //         }
            //     // }
            // });
        }
    }
</script>

<style scoped>
    .story-image > img{
        width:100%;
        transform: translateY(-20%);
        filter: brightness(0.5);
    }
    .story-text{
        font-size:1.6em;
        font-family: notosans, "Nunito", sans-serif;
        letter-spacing: 2px;
    }

    .description{
        border-bottom: 1px solid #325259;
        padding: 0px 20px 20px 20px;
        font-size: 1.3em;
        margin-bottom: 20px;
    }

    /deep/ .story-text img{
        width:100%;
    }

    /deep/ .phrase{
        cursor: pointer;
    }

    /deep/ .translation{
        width: 100%;
        height: fit-content;
        background-color: #f2f2f2;
        color: #325259;
        display: block;
        padding: 10px;
        margin-bottom: 15px;
    }

    /deep/ .translation p{
        margin:0;
        display:inline-block;
    }
</style>
