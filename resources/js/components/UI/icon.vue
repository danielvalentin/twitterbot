<template>
	<FontAwesomeIcon :icon="icons[type]"></FontAwesomeIcon>
</template>

<script>
	import { library, faIcon } from '@fortawesome/fontawesome-svg-core';
	import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
	import {
		faTwitter,
		faFacebook,
	} from '@fortawesome/free-brands-svg-icons';
	import {
		faHeart,
		faSave
	} from '@fortawesome/free-regular-svg-icons';
	import {
		faRetweet,
		faReply,
		faBan,
		faCog,
		faCommentDots
	} from '@fortawesome/free-solid-svg-icons';

	library.add(
		faTwitter,
		faFacebook,
		faHeart,
		faRetweet,
		faReply,
		faBan,
		faCog,
		faSave,
		faCommentDots
	);

	export default {
		components: {
			FontAwesomeIcon,
			faTwitter,
			faFacebook,
			faHeart,
			faRetweet,
			faReply,
			faBan,
			faCog,
			faSave,
			faCommentDots
		},
		props: {
			type: String
		},
		computed: {
			icondata: function(){

			}
		},
		data: function() {
			return {
				icons: {
					twitter: ['fab', 'twitter'],
					facebook: ['fab', 'facebook'],
					heart: ['far', 'heart'],
					retweet: ['fas', 'retweet'],
					reply: ['fas', 'reply'],
					cancel: ['fas', 'ban'],
					cog: ['fas', 'cog'],
					save: ['far', 'save'],
					commentdots: ['fas', 'comment-dots'],
				}
			};
		},
		mounted: function() {
		}
	}
</script>

