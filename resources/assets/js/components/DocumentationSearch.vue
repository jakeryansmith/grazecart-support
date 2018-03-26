<template>
  <div class="documentationSearch">
    <form action="/docs/search" method="GET" id="searchForm">
    <ais-index
      :query="query" 
      :search-store="articleStore" 
      :index-name="documentationIndex" 
      :auto-search="true" 
    >
    </ais-index>
    <ais-index
      :query="query" 
      :search-store="guideStore" 
      :index-name="guidesIndex" 
      :auto-search="true" 
    >
    </ais-index>
    <ais-index
      :query="query" 
      :search-store="faqStore" 
      :index-name="faqIndex" 
      :auto-search="true" 
    >
    </ais-index>
    <div 
      class="searchInput_container" 
      :class="{'searchInput_container--active': searchResults.length > 0 && searchResults.length && showResults}"
    >
      <span class="fas fa-search"></span>
      <input 
        type="text" 
        name="q" 
        class="form-control documentationSearch_input" 
        v-model="query" 
        placeholder="" 
        autocapitalize="off" 
        autocomplete="off" 
        autocorrect="off" 
        @blur="showResults = false" 
        @focus="showResults = true"  
        @keydown.up.prevent="scanUp" 
        @keydown.down="scanDown" 
        @keydown.enter.prevent="select" 
        @keydown.esc="clearResults()"
      >
      <span class="fas fa-times-circle" v-show="query.length" @click="clearResults()"></span>
      <div class="searchInput_placeholder" v-show="!query.length"><span class="text-primary">Search</span> docs, faqs, guides</div>
    </div>
    </form>
      <div v-show="query.length > 0 && searchResults.length && showResults" class="documentationSearch__resultsList shadow">
        <ul class="text-left">
          <li 
            v-for="result in searchResults" 
            :key="result.objectID+result.type" 
            :class="{'active': activeKey == result.objectID+'_'+result.type}"
          >
            <a 
              :href="result.url" 
              @mousedown.prevent="openResult(result)" 
              class="text-gray-3" 
            >
              <span v-html="result._highlightResult.title.value" :class="'type_'+result.type"></span>
              <div class="fs-sm text-gray-6 documentationSearch__resultsListDescription" v-if="result._highlightResult.description">
                <span v-html="result._highlightResult.description['value']"></span>
              </div>
            </a>
          </li>
        </ul>
        <a href="https://algolia.com" @mousedown.prevent="openResult({'url':'https://algolia.com'})" ><img src="https://www.algolia.com/static_assets/images/pricing/pricing_new/algolia-powered-by-14773f38.svg" class="algolia-powered-by"></a>
      </div>
  </div>
</template>

<script>
  import vSelect from 'vue-select';
  import { createFromAlgoliaCredentials } from 'vue-instantsearch';
  const articleStore = createFromAlgoliaCredentials('3UWK676UCM', '2a56fabe747a9a33a625f59868a06bb9');
  const guideStore = createFromAlgoliaCredentials('3UWK676UCM', '2a56fabe747a9a33a625f59868a06bb9');
  const faqStore = createFromAlgoliaCredentials('3UWK676UCM', '2a56fabe747a9a33a625f59868a06bb9');
  export default {

    components: {vSelect},

    props: {
      default_query: {
        type: String,
        required: false,
        default: ''
      }
    },

    data: function() {
      return { 
        query: '',
        articleStore,
        guideStore,
        faqStore,
        activeKey: null,
        scanIndex: -1,
        showResults: false
      }
    },

    computed: {
      searchResults: function()
      {
        return articleStore.results.concat(guideStore.results).concat(faqStore.results);
      },

      documentationIndex: function()
      {
        return window.GrazeCart.env+'_GC_DOCUMENTATION';
      },

      guidesIndex: function()
      {
        return window.GrazeCart.env+'_GC_GUIDES';
      },

      faqIndex: function()
      {
        return window.GrazeCart.env+'_GC_FAQ';
      }
    },

    watch: {
      searchResults: function() {
        this.scanIndex = -1;
      }
    },

    methods: {

      openResult: function(result) {
        window.location.href = result.url;
      },

      clearResults: function()
      {
        this.query = '';
        // this.articleStore.query = '';
        // this.guideStore.query = '';
      },

      select: function() {
        let result = this.searchResults[this.scanIndex];
        if(result) {
          this.openResult(result)
        }
        else
        {
          document.getElementById('searchForm').submit();
        }
      },

      scanDown: function() {
        if(this.scanIndex == this.searchResults.length - 1) {
          this.scanIndex = 0;
        }
        else
        {
          this.scanIndex++;
        }

        this.activeKey = this.searchResults[this.scanIndex].objectID+'_'+this.searchResults[this.scanIndex].type;
      },

      scanUp: function() {
        if(this.scanIndex == 0) {
          this.scanIndex = this.searchResults.length - 1;
        }
        else
        {
          this.scanIndex--;
        }

        this.activeKey = this.searchResults[this.scanIndex].objectID+'_'+this.searchResults[this.scanIndex].type;
      }
    }
  }
</script>