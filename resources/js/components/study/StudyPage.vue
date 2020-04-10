<template>
    <md-app style="min-height: 100vh;">
        <md-app-toolbar class="md-primary">
            <md-button class="md-icon-button d-sm-none" @click="showNavigation = true">
                <md-icon>menu</md-icon>
            </md-button>
            <span class="md-title">
                <slot name="title"></slot>
            </span>
            <div class="md-toolbar-section-end">
                <slot name="toolbar_right"></slot>
            </div>
        </md-app-toolbar>
        <md-app-content>
            <md-card class="p-3">
                <slot name="content"></slot>
            </md-card>
        </md-app-content>
    </md-app>
</template>

<script>
    export default {
        name: "StudyPage"
    }
</script>

<style scoped>

</style>
