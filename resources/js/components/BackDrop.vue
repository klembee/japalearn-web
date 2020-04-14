<template>
    <div class="back-drop">
        <div class="back-drop-content">
            <div>
                <h1>{{title}}</h1>
            </div>
            <div>
                <slot></slot>
            </div>
            <div>
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BackDrop",
        props: {
            title: {
                type: String,
                required: true
            }
        }
    }
</script>

<style scoped>
    .back-drop{
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:#000000ab;
        z-index:99
    }

    .back-drop-content{
        position: absolute;
        top: 50%;
        left: 50%;
        color: white;
        transform: translateX(-50%);
        text-align: center;
    }
</style>
