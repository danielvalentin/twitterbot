<template>
	<div class="card tweet">
		<div class="card-header">
			<div class="row">
				<div class="col">
					<a v-bind:href="status.url" target="_blank">{{ status.created }}</a>
					
					<span v-if="status.reply">
						in reply to <a target="_blank" v-bind:href="status.reply.url">{{ status.reply.to }}</a>
					</span>
				</div>
				<div class="col text-right">
					<button v-if="status.user.following" title="Unfollow this user" class="btn btn-danger" v-on:click="unfollow($event, status.user)">Unfollow</button>
					<button v-if="!status.user.following" title="Follow this user" class="btn btn-primary" v-on:click="follow($event, status.user)">Follow</button>
					<button v-if="deletable" v-bind:class="{'btn btn-secondary':!deleting,'btn btn-danger':deleting}" title="Delete this tweet" v-on:click="deleteTweet($event)">X</button>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-2">
					<div class="profile">
						<div class="avatar">
							<img v-bind:src="status.user.profile_image_url_https" />
						</div>
						<div>
							<div class="username">{{ status.user.name }}</div>
							<div class="handle"><a v-bind:href="status.profileurl" target="_blank">@{{ status.user.screen_name }}</a></div>
							<div class="description" v-html="status.user_description"></div>
							<div class="meta">
								<div class="location">{{ status.user.location }}</div>
								<div class="created">created {{ status.user_since }}</div>
								<div class="followers">{{ status.user.followers_count + " follower" + (status.user.followers_count==1?'':'s') }}</div>
								<div class="updates">{{ status.user.statuses_count + " update" + (status.user.statuses_count==1?'':'s') }}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<p v-html="status.text" v-if="!status.retweet"></p>
					<div class="retweet" v-if="status.retweet">
						<div class="retweet-info">
							{{ status.user.name }} retweetede
							<a v-bind:href="status.retweet.url" target="_blank">{{ status.retweet.user.name }}</a>
						</div>
						<div class="retweet-text" v-html="status.retweet.full_text"></div>
					</div>
					<hr />
					<p>
						<a href="#" v-on:click="replying = !replying" class="btn btn-sm btn-light">
							<icon type="reply" v-if="!replying"></icon>
							<icon type="cancel" v-if="replying"></icon>
							<span v-if="!replying">reply</span>
							<span v-if="replying">cancel</span>
						</a>
					</p>
					<div v-if="replying">
						<div class="form-group">
							<label>Reply:</label>
							<textarea v-model="tweeply" class="form-control" placeholder="Your reply here.."></textarea>
						</div>
						<button class="btn btn-info" v-on:click="reply">Post reply</button>
						<span v-bind:class="{'text-danger':(tweeply.length > 280)}">
							{{ tweeply.length }}
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<span v-if="!status.favorited">
				<a href="#" v-on:click="favorite($event)">
					<icon type="heart"></icon>
				</a> {{ status.favorites }}
			</span>
			<span v-if="status.favorited">
				<a href="#" v-on:click="unfavorite($event)" class="text-danger">
					<icon type="heart"></icon>
				</a> {{ status.favorites }}
			</span>
			<a v-if="!status.retweeted" href="#" v-on:click="retweet($event)">
				<icon type="retweet"></icon>
			</a>
			<span class="text-success" v-if="status.retweeted">
				<icon type="retweet"></icon>
			</span>
			{{ status.retweets }}
		</div>
	</div>
</template>

<script>
	import axios from "axios";
	import messages from "root/messages";
	import icon from "components/UI/icon";

	export default {
		props: {
			status: Object,
			followtoggle: Function,
			deleteCb: Function,
			deletable: Boolean,
			search: String
		},
		data: function() {
			return {
				working: new Set(),
				deleting: false,
				replying: false,
				tweeply: ''
			};
		},
		methods: {
			follow: function(e, user) {
				e.preventDefault();
				let self = this;
				if(!self.working.has('follow'))
				{
					self.working.add('follow');
					axios.get('/ajax/twitter/follow/'+user.id)
						.then(function(response){
							self.followtoggle(user, true);
						}).catch(function(error){
							messages.error(error);
						}).finally(function(){
							self.working.delete('follow');
						});
				}
			},
			deleteTweet: function(e) {
				e.preventDefault();
				if(!this.deleting)
				{
					this.deleting = true;
					let self = this;
					setTimeout(function(){
						self.deleting = false;
					}, 3000);
				}
				else
				{
					this.doDelete();
				}
			},
			doDelete: function() {
				let self = this;
				if(!self.working.has('deleteTweet'))
				{
					self.working.add('deleteTweet');
					axios.get('/ajax/twitter/tweet/delete/'+self.search+'/'+self.status.id)
						.then(function(response){
							self.deleteCb(self.status);
						}).catch(function(error){
							messages.error(error);
						}).finally(function(){
							self.working.delete('deleteTweet');
						});
				}
			},
			unfollow: function(e, user) {
				e.preventDefault();
				let self = this;
				if(!self.working.has('unfollow'))
				{
					self.working.add('unfollow');
					axios.get('/ajax/twitter/unfollow/'+user.id)
						.then(function(response){
							self.followtoggle(user, false);
						}).catch(function(error){
							messages.error(error);
						}).finally(function(){
							self.working.delete('unfollow');
						});
				}
			},
			favorite: function(e) {
				e.preventDefault();
				let self = this;
				if(!self.working.has('favorite'))
				{
					self.working.add('favorite');
					axios.get('/ajax/twitter/tweet/favorite/'+self.status.id)
						.then(function(response){
							let status = response.data[0][0];
							self.status.favorited = status.favorited;
							self.status.favorites = status.favorites;
						}).catch(function(error){
							messages.error(error);
						}).finally(function(){
							self.working.delete('favorite');
						});
				}
			},
			unfavorite: function(e) {
				e.preventDefault();
				let self = this;
				if(!self.working.has('unfavorite'))
				{
					self.working.add('unfavorite');
					axios.get('/ajax/twitter/tweet/unfavorite/'+self.status.id)
						.then(function(response){
							let status = response.data[0][0];
							self.status.favorited = status.favorited;
							self.status.favorites = status.favorites;
						}).catch(function(error){
							messages.error(error);
						}).finally(function(){
							self.working.delete('unfavorite');
						});
				}
			},
			retweet: function(e) {
				e.preventDefault();
				let self = this;
				if(!self.working.has('retweet'))
				{
					self.working.add('retweet');
					messages.confirm('Really retweet this?').then(function(){
						axios.get('/ajax/twitter/tweet/retweet/'+self.status.id)
							.then(function(response){
								let status = response.data[0][0];
								console.log(status);
								self.status.retweeted = status.retweeted;
								self.status.retweets = status.retweets;
							}).catch(function(error){
								messages.error(error);
							}).finally(function(){
								self.working.delete('retweet');
							});
					}).finally(function(){
						self.working.delete('retweet');
					});
				}
			},
			reply: function(e) {
				e.preventDefault();
				let self = this;
				if(self.tweeply.length > 280)
				{
					messages.error('The tweet limit is 280 chars. Yours is '+self.tweeply.length);
					return;
				}
				if(self.tweeply.length > 0)
		  		{
					if(!self.working.has('reply'))
					{
						self.working.add('reply');
						axios.post('/ajax/twitter/tweet/reply/'+self.status.id, {
							'status': self.tweeply
						}).then(function(response){
							messages.success('Reply sent');
							self.tweeply = '';
							self.replying = false;
						}).catch(function(error){
							messages.error(error);
						}).finally(function(){
							self.working.delete('reply');
						});
					}
				}
			}
		}
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
		.retweet
		{
			.retweet-info
			{
				margin-bottom:10px;
				font-size:0.8em;
			}
			.retweet-text
			{
				padding:10px;
				border:1px solid #CCC;
				border-radius:10px;
				background:#EEE;
			}
		}
	}
</style>

