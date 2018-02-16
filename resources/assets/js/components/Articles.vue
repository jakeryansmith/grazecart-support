<template>
	<div>
		<div class="panel">
			<div class="panel-heading flex align-items-m">
				<div class="flex-item">
					Articles
				</div>
				<div class="flex-item push-right">	
					<button type="button" class="btn btn-alt btn-sm" @click="createArticle()"><i class="fa fa-plus-circle fa-lg"></i> Add Article</button>
				</div>
			</div>
			<div class="panel-body">
				<ul class="draggable-list" v-sortable="options">
					<li v-for="article in articles" :key="article.id" class="flex align-items-m">
						<span 
							class="fa draghandle flex-item mr-sm" 
							title="Drag to reorder"
						></span>
						<div class="flex-item">
							<a :href="'/admin/topics/'+topic.slug+'/articles/'+article.slug+'/edit'">{{ article.title }}</a>
						</div>
						<div class="push-right flex-item">
							<a :href="'/admin/articles/'+article.slug+'/edit'" class="btn btn-alt btn-link btn-sm pt-0 pb-0">Edit</a>
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="removeArticle(article)">Delete</button>
						</div>
					</li>
				</ul>
				<div v-show="!articles.length">No articles found</div>
			</div>
		</div>		

		<div class="gc-modal gc-modal-mask" id="createArticleModal" @click="hideModal('createArticleModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Create Article
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" v-model="article.title">
						</div>	
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('createArticleModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="storeArticle(article)" :disabled="!article.title.length">Create Article</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="editArticleModal" @click="hideModal('editArticleModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Edit Article
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" v-model="article.title">
						</div>	
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('editArticleModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="updateArticle(article)" :disabled="!article.title.length">Update Article</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="removeArticleModal" @click="hideModal('removeArticleModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Remove Article
					</div>
					
					<div class="gc-modal-body">
						Remove <strong>{{ article.title }}</strong>?
					</div>	
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('removeArticleModal')">Cancel</button>
		                <button type="button" class="btn btn-danger" @click="destroyArticle(article)" :disabled="!article.title.length">Remove Article</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	export default {
		props: ['topic'],

		created: function() {
			this.fetchArticles();
		},

		data: function() {
			return {
				articles: [],
				article: {
					topic_id: this.topic.id,
					title: ''
				},
				options: { 
                    onUpdate: this.updateArticleSortOrder, 
                    handle: '.draghandle', 
                    animation: 150,
                    group: {
                        name:'segments',
                        pull: false,
                        put: true
                    } 
                }
			}
		},

		methods: {
			fetchArticles: function() {
				axios.get('/api/topics/'+this.topic.id+'/articles').then(function(response) {
					this.articles = response.data;
				}.bind(this))
				.catch(function(error) {

				});
			},

			createArticle: function() {
				this.article = {
					topic_id: 0,
					title: ''
				};
				this.showModal('createArticleModal');
			},

			storeArticle: function(article) {
				eventHub.$emit('showProgressBar');
				axios.post('/api/topics/'+this.topic.id+'/articles', article).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('createArticleModal');
					this.fetchArticles();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			editArticle: function(article) {
				this.article = article;
				this.showModal('editArticleModal');
			},

			updateArticle: function(article) {
				eventHub.$emit('showProgressBar');
				axios.put('/api/topics/'+this.topic.id+'/articles/'+article.id, article).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('editArticleModal');
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			updateArticleSortOrder: function(event)
			{
				eventHub.$emit('showProgressBar');
				this.articles.splice(event.newIndex, 0, this.articles.splice(event.oldIndex, 1)[0]);

				for(let i = 0; i < this.articles.length; i++) {
					let article = this.articles[i];
					article.sort_order = i;
					this.updateArticle(article);
				}
			},

			removeArticle: function(article) {
				this.article = article;
				this.showModal('removeArticleModal');
			},

			destroyArticle: function(article) {
				eventHub.$emit('showProgressBar');
				axios.delete('/api/topics/'+this.topic.id+'/articles/'+article.id).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('removeArticleModal');
					this.fetchArticles();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},
		}
	}
</script>