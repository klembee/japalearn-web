<template>
    <md-app style="min-height: 100vh;">
        <md-app-toolbar class="md-primary">
            <md-button class="md-icon-button d-lg-none" @click="showNavigation = !showNavigation">
                <md-icon>menu</md-icon>
            </md-button>
            <img alt="The JapaLearn logo" src="/images/logo/logo_web_small.png" class="logo"/>

            <div class="md-toolbar-section-end d-none d-lg-flex">
                <slot name="desktop_menu"></slot>
            </div>

        </md-app-toolbar>
        <md-app-drawer :md-active.sync="showNavigation">
            <md-list>
                <slot name="mobile_menu"></slot>
            </md-list>
        </md-app-drawer>
        <md-app-content class="p-0">
            <slot name="content"></slot>
        </md-app-content>
    </md-app>
</template>

<script>
    export default {
        name: "FrontPageToolbar",
        data: function(){
            return {
                showNavigation: false
            }
        }
    }
</script>

<style scoped>
    .nav-separator{
        width:1px;
        display:inline !important;
    }
</style>
