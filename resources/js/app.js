/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window._ = require('lodash');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', (resolve) => {require(['./components/ExampleComponent.vue'], resolve)});
Vue.component('dashboard', (resolve) => {require(['./components/Dashboard.vue'], resolve)});
Vue.component('student-invitation-dialog', (resolve) => {require(['./components/teachers/StudentInvitationDialog.vue'], resolve)});
// Vue.component('flash', require('./components/FlashSnackBar').default);
Vue.component('dictionary', (resolve) => {require(['./components/dictionary/Dictionary.vue'], resolve)});
Vue.component('chat', (resolve) => {require(['./components/messages/Chat.vue'], resolve)});
Vue.component('study-page', (resolve) => {require(['./components/study/StudyPage.vue'], resolve)});
Vue.component('new-learningpath-item-modal', (resolve) => {require(['./components/learning_paths/NewLearningPathItemModal.vue'], resolve)});
Vue.component('vocab-lesson-window', (resolve) => {require(['./components/learning_paths/VocabLessonWindow.vue'], resolve)});
Vue.component('vocab-review-window', (resolve) => {require(['./components/learning_paths/VocabReviewWindow.vue'], resolve)});
Vue.component('vocab-size-per-day-graph', (resolve) => {require(['./components/dashboard/VocabSizePerDayGraph.vue'], resolve)});
Vue.component('learning-path-item-card', (resolve) => {require(['./components/learning_paths/LearningPathItemCard.vue'], resolve)});
Vue.component('image-selector', (resolve) => {require(['./components/ImageSelector.vue'], resolve)});
Vue.component('availability_selector', (resolve) => {require(['./components/video_lesson/teacher/availability_selector.vue'], resolve)});
Vue.component("schedule_form", (resolve) => {require(['./components/video_lesson/ScheduleForm.vue'], resolve)});
Vue.component("new-payment-method-form", (resolve) => {require(['./components/stripe/NewPaymentMethodForm.vue'], resolve)});
Vue.component('delete-payment-method-button', (resolve) => {require(['./components/stripe/DeletePaymentMethodButton.vue'], resolve)});
Vue.component('HiraganaTable', (resolve) => {require(['./components/kanas/HiraganaTable.vue'], resolve)});
Vue.component('LearningJourney', (resolve) => {require(['./components/dashboard/LearningJourney.vue'], resolve)});
Vue.component('AddGrammarItemModal', (resolve) => {require(['./components/grammar/AddGrammarItemModal.vue'], resolve)});
Vue.component('EditGrammarItem', (resolve) => {require(['./components/grammar/EditGrammarItem.vue'], resolve)});
Vue.component('ConferenceRoom', (resolve) => {require(['./components/conference/ConferenceRoom.vue'], resolve)});
Vue.component('EditKanaModal', (resolve) => {require(['./components/kanas/admin/EditKanaModal.vue'], resolve)});
Vue.component('CreateStoryForm', (resolve) => {require(['./components/stories/CreateStoryForm.vue'], resolve)});
Vue.component('StoryReader', (resolve) => {require(['./components/stories/StoryReader.vue'], resolve)});
Vue.component('StoryListItemCard', (resolve) => {require(['./components/stories/StoryListItemCard.vue'], resolve)});
Vue.component('CreateAuthorForm', (resolve) => {require(['./components/authors/CreateAuthorForm.vue'], resolve)});
Vue.component('SubscriptionPage', (resolve) => {require(['./components/settings/subscriptions/SubscriptionPage.vue'], resolve)});
Vue.component('Flash', (resolve) => {require(['./components/Flash.vue'], resolve)});
Vue.component('UnsubscriptionForm', (resolve) => {require(['./components/stripe/UnsubscriptionForm.vue'], resolve)});
Vue.component('ReviewForecast', (resolve) => {require(['./components/kanji_vocabulary/ReviewForecast.vue'], resolve)});
Vue.component('GrammarReviews', (resolve) => {require(['./components/grammar/GrammarReviews.vue'], resolve)});
Vue.component('LatestActivityWidget', (resolve) => {require(['./components/dashboard/LatestActivityWidget.vue'], resolve)});
Vue.component('CreateArticleForm', (resolve) => {require(['./components/blog/CreateArticleForm.vue'], resolve)});
Vue.component('ViewArticle', (resolve) => {require(['./components/blog/ViewArticle.vue'], resolve)});
Vue.component('BlogList', (resolve) => {require(['./components/blog/BlogList.vue'], resolve)});
Vue.component('GrammarItemList', (resolve) => {require(['./components/grammar/GrammarItemList.vue'], resolve)});
Vue.component('ViewGrammarItem', (resolve) => {require(['./components/grammar/ViewGrammarItem.vue'], resolve)});
Vue.component('FrontPageToolbar', (resolve) => {require(['./components/FrontPageToolbar.vue'], resolve)});
Vue.component('LatestArticles', (resolve) => {require(['./components/frontpage/LatestArticles.vue'], resolve)});
Vue.component('RandomGrammar', (resolve) => {require(['./components/frontpage/RandomGrammar.vue'], resolve)});
Vue.component('KanjiCurrentLevelOverview', (resolve) => {require(['./components/kanji_vocabulary/KanjiCurrentLevelOverview.vue'], resolve)});
Vue.component('LessonsToConfirmTable', (resolve) => {require(['./components/video_lesson/teacher/LessonsToConfirmTable.vue'], resolve)});
Vue.component('StarRating', (resolve) => {require(['./components/StarRating.vue'], resolve)});
Vue.component('TeacherCard', (resolve) => {require(['./components/teachers/TeacherCard'], resolve)});

/**
 * Material Design Components
 */
import {MdApp,
    MdToolbar,
    MdDrawer,
    MdButton,
    MdContent,
    MdTabs,
    MdIcon,
    MdList,
    MdCard,
    MdAvatar,
    MdDivider,
    MdTable,
    MdField,
    MdDialog,
    MdProgress,
    MdSnackbar,
    MdAutocomplete,
    MdSpeedDial,
    MdMenu,
    MdSwitch,
    MdRipple,
    MdSubheader,
    MdTooltip,
    MdEmptyState,
    MdCheckbox,
    } from 'vue-material/dist/components'

Vue.use(MdApp);
Vue.use(MdToolbar);
Vue.use(MdDrawer);
Vue.use(MdButton);
Vue.use(MdContent);
Vue.use(MdTabs);
Vue.use(MdIcon);
Vue.use(MdList);
Vue.use(MdCard);
Vue.use(MdAvatar);
Vue.use(MdDivider);
Vue.use(MdTable);
Vue.use(MdField);
Vue.use(MdDialog);
Vue.use(MdProgress);
Vue.use(MdSnackbar);
Vue.use(MdAutocomplete);
Vue.use(MdSpeedDial);
Vue.use(MdMenu);
Vue.use(MdSwitch);
Vue.use(MdRipple);
Vue.use(MdSubheader);
Vue.use(MdTooltip);
Vue.use(MdEmptyState);
Vue.use(MdCheckbox);


import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mounted() {
        setTimeout(function(){
            window.prerenderReady = true;
        }, 5000)
    }
});
