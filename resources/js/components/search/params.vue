<template>
	<div>
		<div v-if="params.length > 0">
			<form method="get" v-bind:action="this.route">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr v-for="param in params">
							<td>
								<input type="hidden" name="key[]" v-model="param.key" />
								{{ param.key }}
							</td>
							<td>
								<input type="hidden" name="value[]" v-model="param.value" />
								{{ param.value }}
							</td>
						</tr>
					</tbody>
				</table>
				<p class="text-right">
					<button class="btn btn-primary">Search</button>
				</p>
			</form>
		</div>
		<div class="form-group">
			<label for="search-param-key">Key</label>
			<input type="text" v-model="param_key" class="form-control" id="search-param-key" placeholder="Query key" />
		</div>
		<div class="form-group">
			<label for="search-param-value">Value</label>
			<input type="text" v-model="param_value" class="form-control" id="search-param-value" placeholder="Query value" />
		</div>
		<p>
			<button v-on:click="addParam" class="btn btn-primary">Add param</button>
		</p>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log('Component mounted');
		},
		props: {
			media: {
				type: String,
				required: true
			},
			route: {
				type: String,
				required: true
			}
		},
		methods: {
			addParam(e) {
				e.preventDefault();
				let self = this;
				if(self.param_key != '' && self.param_value != '')
				{
					self.$data.params.push({
						key: self.param_key,
						value: self.param_value
					});
					self.param_key = '';
					self.param_value = '';
				}
			},
		},
		data: function() {
			return {
				param_key: '',
				param_value: '',
				params: []
			};
		}
	}
</script>

