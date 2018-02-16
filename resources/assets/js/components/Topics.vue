<template>
	<div>
		<div class="panel">
			<div class="panel-heading flex align-items-m">
				<div class="flex-item">
					Topics
				</div>
				<div class="flex-item push-right">	
					<button type="button" class="btn btn-alt btn-sm" @click="showModal('createTopicModal')"><i class="fa fa-plus-circle fa-lg"></i> Add Topic</button>
				</div>
			</div>
			<div class="panel-body">
				<ul class="draggable-list" v-sortable="options">
					<li v-for="topic in topics" :key="topic.id" class="flex align-items-m">
						<span 
							class="fa draghandle flex-item mr-sm" 
							title="Drag to reorder"
						></span>
						<div class="flex-item">
							<a :href="'/admin/topics/'+topic.slug+'/edit'">{{ topic.title }}</a>
						</div>
						<div class="push-right flex-item">
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="editTopic(topic)">Edit</button>
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="removeTopic(topic)">Delete</button>
						</div>
					</li>
				</ul>
				<div v-show="!topics.length">No topics found</div>
			</div>
		</div>		

		<div class="gc-modal gc-modal-mask" id="createTopicModal" @click="hideModal('createTopicModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Create Topic
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" v-model="topic.title">
						</div>	
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('createTopicModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="storeTopic(topic)" :disabled="!topic.title.length">Create Topic</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="editTopicModal" @click="hideModal('editTopicModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Edit Topic
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" v-model="topic.title">
						</div>	
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('editTopicModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="updateTopic(topic)" :disabled="!topic.title.length">Update Topic</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="removeTopicModal" @click="hideModal('removeTopicModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Remove Topic
					</div>
					
					<div class="gc-modal-body">
						Remove <strong>{{ topic.title }}</strong>?
					</div>	
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('removeTopicModal')">Cancel</button>
		                <button type="button" class="btn btn-danger" @click="destroyTopic(topic)" :disabled="!topic.title.length">Remove Topic</button>
					</div>
				</div>
			</div>
		</div>
	</div>	
</template>

<script>
	export default {
		created: function() {
			this.fetchTopics();
		},

		data: function() {
			return {
				topics: [],
				topic: {
					title: ''
				},
				options: { 
                    onUpdate: this.updateTopicSortOrder, 
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
			fetchTopics: function() {
				axios.get('/api/topics').then(function(response) {
					this.topics = response.data;
				}.bind(this))
				.catch(function(error) {

				});
			},

			storeTopic: function(topic) {
				eventHub.$emit('showProgressBar');
				axios.post('/api/topics', topic).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('createTopicModal');
					this.fetchTopics();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			editTopic: function(topic) {
				this.topic = topic;
				this.showModal('editTopicModal');
			},

			updateTopic: function(topic) {
				eventHub.$emit('showProgressBar');
				axios.put('/api/topics/'+topic.id, topic).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('editTopicModal');
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			updateTopicSortOrder: function(event)
			{
				eventHub.$emit('showProgressBar');
				this.topics.splice(event.newIndex, 0, this.topics.splice(event.oldIndex, 1)[0]);

				for(let i = 0; i < this.topics.length; i++) {
					let topic = this.topics[i];
					topic.sort_order = i;
					this.updateTopic(topic);
				}
			},

			removeTopic: function(topic) {
				this.topic = topic;
				this.showModal('removeTopicModal');
			},

			destroyTopic: function(topic) {
				eventHub.$emit('showProgressBar');
				axios.delete('/api/topics/'+topic.id).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('removeTopicModal');
					this.fetchTopics();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},
		}
	}
</script>