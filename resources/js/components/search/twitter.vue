<template>
	<div>
		<div class="form-group">
			<label for="query">Term (max 10 ad gangen)</label>
			<input id="query" v-on:keydown.enter="doSearch" type="text" name="query" v-model="searchterm" class="form-control" placeholder="Searchterm..." />
		</div>
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label>
						<input type="checkbox" v-model="da" name="da" /> Restrict to danish tweets (lang: da)
					</label>
				</div>
				<div class="form-group">
					<label>
						<input type="checkbox" v-model="geocode" name="geocode" /> Georestrict to DK (also excludes tweets with no geolocation info)
					</label>
				</div>
				<div class="form-group">
					<label>
						<input type="checkbox" v-model="replies" name="replies" /> Don't include replies
					</label>
				</div>
				<div class="form-group">
					<label>
						<input type="checkbox" v-model="retweets" name="retweets" /> Don't include retweets
					</label>
				</div>
			</div>
			<div class="col text-right" v-if="searchterm.length > 0">
				<a href="#" v-on:click="saving = !saving" class="btn btn-light btn-sm">
					<icon type="save"></icon>
					Save query to DB
				</a>
				<div v-if="saving" class="text-left">
					<hr />
					<div class="form-group">
						<label>Save search as:</label>
						<input type="text" class="form-control" name="title" placeholder="Name your search.." />
					</div>
					<div class="text-right">
						<button class="btn btn-primary" type="submit">Save search</button>
					</div>
				</div>
			</div>
		</div>
		<div>
			<button v-on:click="doSearch" class="btn btn-primary">Search</button>
		</div>
		<hr />
		<div v-if="statuses.length == 0">
			Ingen søgeresultater&hellip;
		</div>
		<div v-for="status in statuses">
			<Tweet v-bind:status="status" v-bind:followtoggle="togglefollow" />
		</div>
	</div>
</template>

<script>
	import axios from "axios";
	import Tweet from "../twitter/tweet";

	export default {
		data: function() {
			return {
				data: null,
				searchterm: '',
				statuses: {},
				working: false,
				geocode: false,
				replies: false,
				da: true,
				retweets: true,
				saving: false
			}
		},
		components: {
			Tweet
		},
		methods: {
			doSearch: function(e) {
				e.preventDefault();
				if(this.searchterm != '')
				{
					let self = this;
					axios.post('/ajax/twitter/search', {
						'term': self.searchterm,
						'geocode': self.geocode,
						'replies': self.replies,
						'da': self.da,
						'retweets': self.retweets
					}).then(function(response){
						let data = response.data;
						console.log(data);
						self.statuses = data.statuses;
					});
				}
			},
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
		},
	}
</script>
<style lang="scss" scoped>
	.tweet
	{
		margin-bottom:10px;
		.profile
		{
			float:left;
			margin-right:20px;
			.avatar
			{
			}
			.username
			{
				font-weight:bold;
			}
			.handle
			{
			}
			.meta
			{
				background:#EEE;
				padding:5px;
				margin:5px 0;
				border-radius:5px;
				font-size:0.8em;
			}
			.description
			{
				font-size:0.8em;
				padding:5px;
				font-style:italic;
			}
		}
	}
</style>
