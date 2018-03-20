
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Sortable from 'sortablejs';
Vue.directive('sortable', {
  inserted: function (el, binding) {
    new Sortable(el, binding.value || {})
  }
});

Vue.mixin({
  methods: {
    showModal: function(modalId) {
        eventHub.$emit(modalId+':opened');
        $(document.body).addClass('modal-open');
        let modal = $('#'+modalId);
        modal.addClass('gc-modal-show').outerWidth();
        modal.addClass('gc-modal-enter');
    },

    hideModal: function(modalId) {
        eventHub.$emit(modalId+':closed');
        $(document.body).removeClass('modal-open');
        let modal = $('#'+modalId);
        modal.removeClass('gc-modal-enter');
        setTimeout(function () {
          modal.removeClass('gc-modal-show');
        }, 300);
    }
  }
});

window.eventHub = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('Faqs', require('./components/FAQs.vue'));
Vue.component('Guides', require('./components/Guides.vue'));
Vue.component('Topics', require('./components/Topics.vue'));
Vue.component('Articles', require('./components/Articles.vue'));
Vue.component('EditArticle', require('./components/EditArticle.vue'));
Vue.component('TextEditor', require('./components/TextEditor.vue'));
Vue.component('MediaBrowser', require('./components/MediaBrowser/MediaBrowser.vue'));

const app = new Vue({
    el: '#app',

    created: function() {
        window.eventHub.$on('showProgressBar', function() {
            $('#progressBar').addClass('show-progress-bar');
        }.bind(this));

        window.eventHub.$on('hideProgressBar', function() {
            $('#progressBar').removeClass('show-progress-bar');
        }.bind(this));

        window.eventHub.$on('showModal', this.showModal);
    },
});
