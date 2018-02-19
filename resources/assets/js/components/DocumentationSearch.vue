<template>
  <div class="documentationSearch">
    <form action="/docs/search" method="GET" id="searchForm">
    <ais-index
      :search-store="searchStore" 
      index-name="GC_DOCUMENTATION" 
      :auto-search="true" 
    >
    </ais-index>
    <div class="searchInput_container">
      <span class="fas fa-search"></span>
      <input 
        type="text" 
        name="q" 
        class="form-control documentationSearch_input" 
        v-model="searchStore.query" 
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
      <span class="fas fa-times-circle" v-show="searchStore.query.length" @click="clearResults()"></span>
      <div class="searchInput_placeholder" v-show="!searchStore.query.length"><span class="text-primary">Search</span> docs, faqs, guides</div>
    </div>
    </form>
    <div v-show="searchStore.query.length > 0 && searchStore.results.length && showResults" class="documentationSearch__resultsList shadow">
      <ul class="text-left">
        <li 
          v-for="result in searchStore.results" 
          :key="result.objectID" 
          :class="{'active': activeKey == result.objectID}"
        >
          <a 
            :href="result.url" 
            @mousedown.prevent="openResult(result)" 
            class="text-gray-3" 
          >
            <div v-html="result._highlightResult.title.value"></div>
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
  const searchStore = createFromAlgoliaCredentials('3UWK676UCM', '2a56fabe747a9a33a625f59868a06bb9');
  export default {

    components: {vSelect},

    data: function() {
      return { 
        searchStore,
        activeKey: null,
        scanIndex: -1,
        showResults: false
      }
    },

    watch: {
      'searchStore.results': function() {
        this.scanIndex = -1;
      }
    },

    methods: {


      openResult: function(result) {
        window.location.href = result.url;
      },

      clearResults: function()
      {
        this.searchStore.query = '';
      },

      select: function() {
        let result = this.searchStore.results[this.scanIndex];
        if(result) {
          this.openResult(result)
        }
        else
        {
          document.getElementById('searchForm').submit();
        }
      },

      scanDown: function() {
        if(this.scanIndex == this.searchStore.results.length - 1) {
          this.scanIndex = 0;
        }
        else
        {
          this.scanIndex++;
        }

        this.activeKey = this.searchStore.results[this.scanIndex].objectID;
      },

      scanUp: function() {
        if(this.scanIndex == 0) {
          this.scanIndex = this.searchStore.results.length - 1;
        }
        else
        {
          this.scanIndex--;
        }

        this.activeKey = this.searchStore.results[this.scanIndex].objectID;
      }
    }
  }
</script>