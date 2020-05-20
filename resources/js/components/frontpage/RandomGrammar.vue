<template>
    <div>
        <ul class="list-unstyled">
            <li @click="readItem(item)" v-for="item in items" :key="item.id" class="article-item">
                <h4>{{item.title}}</h4>
                <p>{{getAbstract(item)}}</p>
            </li>
        </ul>
        <md-button :href="readMoreUrl" class="md-raised md-primary">Read more</md-button>
    </div>
</template>

<script>
    import Marked from "marked";

    export default {
        name: "LatestArticles",
        props: {
            apiEndpoint: {
                type: String,
                required: true
            },
            readUrl: {
                type: String,
                required: true
            },
            readMoreUrl: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                items: []
            }
        },
        methods: {
            fetch(){
                let self = this;
                axios.get(this.apiEndpoint)
                    .then(function(response){
                        if(response.data.success){
                            self.items = response.data.items;
                        }else{
                            console.error("Failed to retrieve latest grammar posts.")
                        }
                    })
                    .catch(function(error){
                        console.error("Failed to retrieve latest grammar posts.")
                    })
            },
            getAbstract(item){
                let formatedContent = Marked(item.content);
                let soup = new JSSoup(formatedContent);
                return soup.getText(". ").substr(0, 100) + "...";
            },
            readItem(item){
                window.location.href = this.readUrl.replace(":slug", item.slug);
            }
        },
        mounted() {
            this.fetch();
        }
    }
</script>

<style scoped>
    .article-item{
        padding: 15px 30px 15px 30px;
        border-bottom: 2px solid #f5f5f5;
    }
</style>
