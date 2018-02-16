<template>
	<div>
		<div class="panel">
			<div class="panel-heading flex align-items-m">
				<div class="flex-item">
					FAQs
				</div>
				<div class="flex-item push-right">	
					<button type="button" class="btn btn-alt btn-sm" @click="showModal('createFaqModal')"><i class="fa fa-plus-circle fa-lg"></i> Add FAQ</button>
				</div>
			</div>
			<div class="panel-body">
				<ul class="draggable-list" v-sortable="options">
					<li v-for="faq in faqs" :key="faq.id" class="flex align-items-m">
						<span 
							class="fa draghandle flex-item mr-sm" 
							title="Drag to reorder"
						></span>
						<div class="flex-item">
							<a href="#" @click.prevent="editFaq(faq)">{{ faq.title }}</a>
						</div>
						<div class="push-right flex-item">
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="editFaq(faq)">Edit</button>
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="removeFaq(faq)">Delete</button>
						</div>
					</li>
				</ul>
				<div v-show="!faqs.length">No faqs found</div>
			</div>
		</div>		

		<div class="gc-modal gc-modal-mask" id="createFaqModal" @click="hideModal('createFaqModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Create FAQ
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Category</label>
							<select v-model="faq.category_id" class="form-control">
								<option value="0" 	disabled>Select a category</option>
								<option v-for="faqCategory in faqCategories" :value="faqCategory.id">{{ faqCategory.title }}</option>
							</select>	
						</div>
						<div class="form-group">
							<label>Question</label>
							<input type="text" class="form-control" v-model="faq.title">
						</div>
						<div class="form-group">
							<label>Answer</label>
							<textarea class="form-control" v-model="faq.body" rows="5"></textarea>
						</div>
						<div class="form-group">
							<label>
								<input type="checkbox" v-model="faq.visible" value="1"> Visible
							</label>
						</div>
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('createFaqModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="storeFaq(faq)" :disabled="!faq.title.length">Create FAQ</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="editFaqModal" @click="hideModal('editFawModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Edit FAQ
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Category</label>
							<select v-model="faq.category_id" class="form-control">
								<option value="0" disabled>Select a category</option>
								<option v-for="faqCategory in faqCategories" :value="faqCategory.id">{{ faqCategory.title }}</option>
							</select>	
						</div>
						<div class="form-group">
							<label>Question</label>
							<input type="text" class="form-control" v-model="faq.title">
						</div>
						<div class="form-group">
							<label>Answer</label>
							<textarea class="form-control" v-model="faq.body" rows="5"></textarea>
						</div>
						<div class="form-group">
							<label>Keywords</label>
							<input type="text" class="form-control" v-model="faq.keywords" placeholder="Seperate each with a space">
						</div>
						<div class="form-group">
							<label>URL</label>
							<input type="text" class="form-control" v-model="faq.url" :placeholder="'/faqs/'+faq.slug">
						</div>
						<div class="form-group">
							<label>
								<input type="checkbox" v-model="faq.visible" value="1"> Visible
							</label>
						</div>
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('editFaqModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="updateFaq(faq)" :disabled="!faq.title.length">Update FAQ</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="removeFaqModal" @click="hideModal('removeFaqModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Remove FAQ
					</div>
					
					<div class="gc-modal-body">
						Remove <strong>{{ faq.title }}</strong>?
					</div>	
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('removeFaqModal')">Cancel</button>
		                <button type="button" class="btn btn-danger" @click="destroyFaq(faq)" :disabled="!faq.title.length">Remove FAQ</button>
					</div>
				</div>
			</div>
		</div>
	</div>	
</template>

<script>
	export default {
		created: function() {
			this.fetchFaqs();
			this.fetchFaqCategores();
		},

		data: function() {
			return {
				faqs: [],
				faqCategories: [],
				faq: {
					category_id: 0,
					title: '',
					body: '',
					keywords: '',
					visible: false
				},
				options: { 
                    onUpdate: this.updateFaqSortOrder, 
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
			fetchFaqs: function() {
				axios.get('/api/faqs').then(function(response) {
					this.faqs = response.data;
				}.bind(this))
				.catch(function(error) {

				});
			},

			fetchFaqCategores: function() {
				axios.get('/api/faq-categories').then(function(response) {
					this.faqCategories = response.data;
				}.bind(this))
				.catch(function(error) {

				});
			},

			storeFaq: function(faq) {
				eventHub.$emit('showProgressBar');
				axios.post('/api/faqs', faq).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('createFaqModal');
					this.fetchFaqs();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			editFaq: function(faq) {
				this.faq = faq;
				this.showModal('editFaqModal');
			},

			updateFaq: function(faq) {
				eventHub.$emit('showProgressBar');
				axios.put('/api/faqs/'+faq.id, faq).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('editFaqModal');
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			updateFaqSortOrder: function(event)
			{
				eventHub.$emit('showProgressBar');
				this.faqs.splice(event.newIndex, 0, this.faqs.splice(event.oldIndex, 1)[0]);

				for(let i = 0; i < this.faqs.length; i++) {
					let faq = this.faqs[i];
					faq.sort_order = i;
					this.updateFaq(faq);
				}
			},

			removeFaq: function(faq) {
				this.faq = faq;
				this.showModal('removeFaqModal');
			},

			destroyFaq: function(faq) {
				eventHub.$emit('showProgressBar');
				axios.delete('/api/faqs/'+faq.id).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('removeFaqModal');
					this.fetchFaqs();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},
		}
	}
</script>