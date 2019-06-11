<template>
	<div>
		<div class="tweets">
			<div v-for="status in statuses" v-if="!error">
				<Tweet v-bind:search="search" v-bind:key="status.id" v-bind:deleteCb="deleteTweet" v-bind:status="status" v-bind:followtoggle="togglefollow" v-bind:deletable="deletable" />
			</div>
			<div v-if="error">
				<h3 class="text-danger">Whoops: An error occurred:</h3>
				<p>
					Code: {{ error.code }}<br />
					<em>{{ error.message }}</em>
				</p>
			</div>
			<p v-if="statuses.length < 1">
				<em>No tweets to show!</em>
			</p>
		</div>
	</div>
</template>

<script>
	import axios from "axios";
	import Tweet from './tweet';
	import messages from 'root/messages';

	export default {
		props: {
			url: String,
			deletable: Boolean,
			search: String
		},
		data: function() {
			return {
				statuses: [],
				error: false
			}
		},
		components: {
			Tweet
		},
		methods: {
			togglefollow: function(user, following) {
				let len = this.statuses.length;
				for(let i=0;i<len;i++)
				{
					if(this.statuses[i].user.id == user.id)
					{
						this.statuses[i].user.following = following;
					}
				}
			},
			getTweets: function() {
				let self = this;
				axios.get(self.url)
					.then(function(response){
						let data = response.data;
						if(data.error)
						{
							self.error = data;
							return;
						}
						self.statuses = data[0];
					})
					.catch(function(error){
						messages.error(error);
						let err = error.response.data;
						self.error = {
							code: error.response.status,
							message: err.message
						}
					});
			},
			deleteTweet: function(tweet) {
				let what = this.statuses.filter(status => status.id == tweet.id);
				this.statuses.splice(this.statuses.indexOf(what[0]), 1);
			}
		},
		mounted() {
			 this.getTweets();
		}
	}
</script>

