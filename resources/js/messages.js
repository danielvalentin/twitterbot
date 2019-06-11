import Noty from 'noty';

export default {

	// https://github.com/axios/axios#handling-errors
	error: function(error) {
		if(error.response)
		{
			// Server responded with an errorcode not 2xx
			console.log(error.response.data);
			console.log(error.response.status);
			console.log(error.response.headers);
			new Noty({
				type: 'error',
				text:'<h3>Error</h3>'+error.response.data.message+'<br />Code: 1',
			}).show();
		}
		else if(error.request)
		{
			// Request made, but no response recieved
			console.log(error.request);
			new Noty({
				type: 'error',
				text:'<h3>Error</h3>No response from server'+'<br />Code: 2',
			}).show();
		}
		else if(error.message)
		{
			// Something happened in setting up the request that triggered an Error
			console.log('error', error.message);
			new Noty({
				type: 'error',
				text:'<h3>Error</h3>'+error.message+'<br />Code: 3',
			}).show();
		}
		else
		{
			console.log('wtf', error);
			new Noty({
				type: 'error',
				text:'<h3>Error</h3>'+error+'<br />Code: 4',
			}).show();
		}
	},
	success: function(message) {
		new Noty({
			type: 'success',
			text:'<h3>Succes</h3>'+message,
		}).show();
	},
	confirm: function(message) {
		return new Promise(function(resolve, reject) {
			let n = new Noty({
				type: 'warning',
				text: message,
				buttons: [
					Noty.button('Yes', 'btn btn-success', function(){
						resolve();
						n.close();
						return true;
					}),
					Noty.button('No', 'btn btn-danger', function(){
						reject();
						n.close();
						return false;
					})
				]
			}).show();
		});
	}

}
