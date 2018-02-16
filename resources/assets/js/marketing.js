window.Vue = require('vue');
import InstantSearch from 'vue-instantsearch';

Vue.use(InstantSearch);


Vue.component('DocumentationSearch', require('./components/DocumentationSearch.vue'));


const app = new Vue({
    el: '#instantSearch'
});