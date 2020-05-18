<template>
    <div>
        <div class="story-image">
            <img :src="'/storage/' + story.front_image_url"/>
        </div>
        <div class="story">
            <h1 class="text-center mb-4">{{story.title}}</h1>
            <div class="story-text" v-html="formatedContent">

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
                formatedContent: ""
            }
        },
        methods:{
            translate: function(japanese){
                return this.story.translations.filter(translation => translation.japanese === japanese)[0].translation;
            }
        },
        mounted() {
            this.formatedContent = marked(this.story.content);

            // Setup the click to get translation feature
            let self = this;

            $("body").delegate(".story-text p", 'click', function(){
                $("#translation").remove();
                // $('p[is-showing-translation="true"]').removeAttr("is-showing-translation");

                // if($(this).attr('is-showing-translation') && $(this).attr('is-showing-translation') === "true"){
                //     $(this).attr('is-showing-translation', "false");
                // }else{
                    let translation = self.translate($(this).text());
                    if(translation !== "") {

                        $(this).attr('is-showing-translation', "true");

                        let offset = $(this).offset();

                        // Show the translation on top of the phrase
                        $(this).append("<p id='translation'>" + translation + "</p>");

                        offset.left -= $(this).width();
                        // For some reason I have to remove the height of the image
                        offset.top -= $(".story-image").height();

                        let fontSize = parseFloat(getComputedStyle(this).fontSize);
                        offset.top -= fontSize;

                        offset.top -= $("#translation").height();
                        $("#translation").css(offset);
                    }
                // }
            });
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

    /deep/ #translation{
        position: absolute;
        width:75%;
        background-color: whitesmoke;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #dedede;
    }
</style>
