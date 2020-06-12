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

Vue.component('example-component', () => import('./components/ExampleComponent.vue'));
Vue.component('dashboard', () => import('./components/Dashboard.vue'));
Vue.component('student-invitation-dialog', () => import('./components/teachers/StudentInvitationDialog.vue'));
// Vue.component('flash', require('./components/FlashSnackBar').default);
Vue.component('dictionary', () => import('./components/dictionary/Dictionary.vue'));
Vue.component('chat', () => import('./components/messages/Chat.vue'));
Vue.component('study-page', () => import('./components/study/StudyPage.vue'));
Vue.component('new-learningpath-item-modal', () => import('./components/learning_paths/NewLearningPathItemModal.vue'));
Vue.component('vocab-lesson-window', () => import('./components/learning_paths/VocabLessonWindow.vue'));
Vue.component('vocab-review-window', () => import('./components/learning_paths/VocabReviewWindow.vue'));
Vue.component('vocab-size-per-day-graph', () => import('./components/dashboard/VocabSizePerDayGraph.vue'));
Vue.component('learning-path-item-card', () => import('./components/learning_paths/LearningPathItemCard.vue'));
Vue.component('image-selector', () => import('./components/ImageSelector.vue'));
Vue.component('availability_selector', () => import('./components/video_lesson/teacher/availability_selector.vue'));
Vue.component("schedule_form", () => import('./components/video_lesson/ScheduleForm.vue'));
Vue.component("new-payment-method-form", () => import('./components/stripe/NewPaymentMethodForm.vue'));
Vue.component('delete-payment-method-button', () => import('./components/stripe/DeletePaymentMethodButton.vue'));
Vue.component('HiraganaTable', () => import('./components/kanas/HiraganaTable.vue'));
Vue.component('LearningJourney', () => import('./components/dashboard/LearningJourney.vue'));
Vue.component('AddGrammarItemModal', () => import('./components/grammar/AddGrammarItemModal.vue'));
Vue.component('EditGrammarItem', () => import('./components/grammar/EditGrammarItem.vue'));
Vue.component('ConferenceRoom', () => import('./components/conference/ConferenceRoom.vue'));
Vue.component('EditKanaModal', () => import('./components/kanas/admin/EditKanaModal.vue'));
Vue.component('CreateStoryForm', () => import('./components/stories/CreateStoryForm.vue'));
Vue.component('StoryReader', () => import('./components/stories/StoryReader.vue'));
Vue.component('StoryListItemCard', () => import('./components/stories/StoryListItemCard.vue'));
Vue.component('CreateAuthorForm', () => import('./components/authors/CreateAuthorForm.vue'));
Vue.component('SubscriptionPage', () => import('./components/settings/subscriptions/SubscriptionPage.vue'));
Vue.component('Flash', () => import('./components/Flash.vue'));
Vue.component('UnsubscriptionForm', () => import('./components/stripe/UnsubscriptionForm.vue'));
Vue.component('ReviewForecast', () => import('./components/kanji_vocabulary/ReviewForecast.vue'));
Vue.component('GrammarReviews', () => import('./components/grammar/GrammarReviews.vue'));
Vue.component('LatestActivityWidget', () => import('./components/dashboard/LatestActivityWidget.vue'));
Vue.component('CreateArticleForm', () => import('./components/blog/CreateArticleForm.vue'));
Vue.component('ViewArticle', () => import('./components/blog/ViewArticle.vue'));
Vue.component('BlogList', () => import('./components/blog/BlogList.vue'));
Vue.component('GrammarItemList', () => import('./components/grammar/GrammarItemList.vue'));
Vue.component('ViewGrammarItem', () => import('./components/grammar/ViewGrammarItem.vue'));
Vue.component('FrontPageToolbar', () => import('./components/FrontPageToolbar.vue'));
Vue.component('LatestArticles', () => import('./components/frontpage/LatestArticles.vue'));
Vue.component('RandomGrammar', () => import('./components/frontpage/RandomGrammar.vue'));
Vue.component('KanjiCurrentLevelOverview', () => import('./components/kanji_vocabulary/KanjiCurrentLevelOverview.vue'));
Vue.component('LessonsToConfirmTable', () => import('./components/video_lesson/teacher/LessonsToConfirmTable.vue'));
Vue.component('StarRating', () => import('./components/StarRating.vue'));
Vue.component('TeacherCard', () => import('./components/teachers/TeacherCard'));


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
