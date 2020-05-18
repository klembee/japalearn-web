<template>
    <md-app style="min-height: 100vh;">
        <md-app-toolbar class="md-primary">
            <md-button class="md-icon-button" v-if="!isLargeScreen" @click="showNavigation = !showNavigation">
                <md-icon>menu</md-icon>
            </md-button>
            <span class="md-title">
                <slot name="title"></slot>
            </span>
            <div class="md-toolbar-section-end">
                <slot name="toolbar_right"></slot>
            </div>
        </md-app-toolbar>
        <md-app-drawer :md-active.sync="showNavigation" v-if="!isLargeScreen">
            <md-toolbar class="md-transparent" md-elevation="0">
                <div class="logo-container">
                    <img src="/images/logo/logo_web_small.png" alt="Logo of JapaLearn with Pochi in the center"/>
                </div>
            </md-toolbar>

            <md-list>
                <slot name="navigation-items"></slot>
            </md-list>
        </md-app-drawer>
        <!-- If large screen -->
        <md-app-drawer v-else :md-active.sync="showNavigation" md-permanent="full">
            <md-toolbar class="md-transparent" md-elevation="0">
                <div class="logo-container">
                    <img src="/images/logo/logo_web_small.png" alt="Logo of JapaLearn with Pochi in the center"/>
                </div>
            </md-toolbar>

            <md-list>
                <slot name="navigation-items"></slot>
            </md-list>
        </md-app-drawer>
        <md-app-content>

            <slot name="alert"></slot>

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
                showNavigation: false,
                isLargeScreen: false
            }
        },
        mounted() {
            let screenWidth = screen.width;
            if(screenWidth > 1366){
                this.isLargeScreen = true
            }
        }
    }
</script>

<style scoped>
    .logo-container{
        min-height:113.34px;
    }
</style>
