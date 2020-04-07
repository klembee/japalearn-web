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
        <md-app-drawer :md-active.sync="showNavigation" md-swipeable md-permanent="full">
            <md-toolbar class="md-transparent" md-elevation="0">
                <span class="md-title">JapaLearn</span>
            </md-toolbar>

            <md-list>
                <slot name="navigation-items"></slot>
            </md-list>
        </md-app-drawer>
        <md-app-content>
            <md-card class="p-3">
                <slot name="content"></slot>
            </md-card>
        </md-app-content>
    </md-app>
</template>

<script>
    export default {
        name: "ToolbarAndDrawer",
        data: function(){
            return {
                showNavigation: false
            }
        }
    }
</script>

<style scoped>

</style>
