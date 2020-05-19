<template>

    <div class="row w-100 mt-4">
        <div class="col-lg-8">
            <div>
                <div class="grammar-items">
                    <md-card class="grammar-card" v-for="item in items.data" :key="item.id">
                        <md-card-header>
                            <h2>{{item.title}}</h2>
                        </md-card-header>
                        <md-card-content>

                        </md-card-content>
                        <md-card-actions>
                            <md-button :href="viewUrl.replace(':id', item.slug)" class="md-raised md-accent">Learn</md-button>
                        </md-card-actions>
                    </md-card>

                    <slot></slot>

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h3>Category</h3>
            <ul class="category-list">
                <li @click="openCategory(category)" class="category-button" :class="{active: isActive(category)}" v-for="category in categories" :key="category.id">
                    {{category.category}}
                </li>
            </ul>
        </div>
    </div>

</template>

<script>
    export default {
        name: "GrammarItemList",
        props: {
            items: {
                type: Object,
                required: true
            },
            categories: {
                type: Array,
                required: true
            },
            currentCategoryId: {
                type: Number,
                required: true
            },
            gotoCategoryUrl:{
                type: String,
                required:true,
            },
            links: {
                type: String,
                required: false
            },
            viewUrl: {
                type: String,
                required: true
            }
        },
        methods:{
            isActive(category){
                return category.id === this.currentCategoryId;
            },
            openCategory(category){
                window.location.href = this.gotoCategoryUrl.replace(':id', category.id);
            }
        }
    }
</script>

<style scoped>
    .grammar-items{
        width:50%;
        margin:auto;
    }

    .grammar-card{
        margin-bottom:20px;
    }

    .category-list{
        width:fit-content;
        padding-left:0;
    }

    .category-button{
        list-style: none;
        width: 200px;
        border:3px solid #325259;
        background: #f5f5f5;
        padding: 15px;
        color: #325259;
        font-size: 1.4em;
        margin-bottom:10px;
        cursor: pointer;
    }

    .category-button.active{
        background-color: #325259;
        color: #f5f5f5;
    }
</style>
