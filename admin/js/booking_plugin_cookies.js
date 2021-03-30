jQuery(document).ready(function ($){
		console.log('this workerd fuck ass');
		// changes the values in order value input fields
		let json_data = $('#json_data').text();
		json_data = JSON.parse(json_data);
		
		let get_inputs = document.getElementById('mpbp_add_new').children;
		//stores the cookie object names
		let data = [];
		//gets the index number of the inputs fields
		for(let i = 0; i<get_inputs.length; i++){
			if(get_inputs[i].tagName == 'INPUT'){
				data.push(get_inputs[i]);
			}
		}
		//displays the cookie data on each field respectively
		let mpbp_parent = $('#mpbp_add_new').children('input');
		for(let i=0;i<Object.keys(json_data).length; i++){
			let cookie_data = data[i].getAttribute('name');
			$('#mpbp_admin_'+ cookie_data).val(json_data[cookie_data]);
		}
	});