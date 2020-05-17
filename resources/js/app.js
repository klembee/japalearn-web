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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('student-invitation-dialog', require('./components/teachers/StudentInvitationDialog').default);
// Vue.component('flash', require('./components/FlashSnackBar').default);
Vue.component('dictionary', require('./components/dictionary/Dictionary.vue').default);
Vue.component('chat', require('./components/messages/Chat.vue').default);
Vue.component('study-page', require('./components/study/StudyPage.vue').default);
Vue.component('new-learningpath-item-modal', require('./components/learning_paths/NewLearningPathItemModal.vue').default);
Vue.component('vocab-lesson-window', require('./components/learning_paths/VocabLessonWindow.vue').default);
Vue.component('vocab-review-window', require('./components/learning_paths/VocabReviewWindow.vue').default);
Vue.component('vocab-size-per-day-graph', require('./components/dashboard/VocabSizePerDayGraph.vue').default);
Vue.component('learning-path-item-card', require('./components/learning_paths/LearningPathItemCard.vue').default);
Vue.component('image-selector', require('./components/ImageSelector.vue').default);
Vue.component('availability_selector', require('./components/video_lesson/availability_selector.vue').default);
Vue.component("schedule_form", require('./components/video_lesson/ScheduleForm.vue').default);
Vue.component("new-payment-method-form", require('./components/stripe/NewPaymentMethodForm.vue').default);
Vue.component('delete-payment-method-button', require('./components/stripe/DeletePaymentMethodButton.vue').default);
Vue.component('HiraganaTable', require('./components/kanas/HiraganaTable.vue').default);
Vue.component('LearningJourney', require('./components/dashboard/LearningJourney.vue').default);
Vue.component('AddGrammarItemModal', require('./components/grammar/AddGrammarItemModal.vue').default);
Vue.component('EditGrammarItem', require('./components/grammar/EditGrammarItem.vue').default);
Vue.component('ConferenceRoom', require('./components/conference/ConferenceRoom.vue').default);
Vue.component('EditKanaModal', require('./components/kanas/admin/EditKanaModal.vue').default);
Vue.component('CreateStoryForm', require('./components/stories/CreateStoryForm.vue').default);
Vue.component('StoryReader', require('./components/stories/StoryReader.vue').default);
Vue.component('StoryListItemCard', require('./components/stories/StoryListItemCard.vue').default);
Vue.component('CreateAuthorForm', require('./components/authors/CreateAuthorForm.vue').default);
Vue.component('SubscriptionPage', require('./components/settings/subscriptions/SubscriptionPage.vue').default);
Vue.component('Flash', require('./components/Flash.vue').default);
Vue.component('UnsubscriptionForm', require('./components/stripe/UnsubscriptionForm.vue').default);
Vue.component('ReviewForecast', require('./components/kanji_vocabulary/ReviewForecast.vue').default);
Vue.component('GrammarReviews', require('./components/grammar/GrammarReviews.vue').default);
Vue.component('LatestActivityWidget', require('./components/dashboard/LatestActivityWidget.vue').default);

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


import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
