jQuery(document).ready(function ($){
		console.log('this workerd fuck ass');
		// changes the values in order value input fields
		let json_data = $('#json_data').text();
		json_data = JSON.parse(json_data);
		
		let get_inputs = document.getElementById('mpbp_add_new').children;
		let data = [];
		for(let i = 0; i<get_inputs.length; i++){
			if(get_inputs[i].tagName == 'INPUT'){
				data.push(get_inputs[i]);
				console.log(get_inputs[i].getAttribute('name'));
			}
		}
		//$('#mpbp_admin_date').val('hello');
		//alert(Object.keys(json_data).length);
		//let ll = data[1].getAttribute('name');
		//alert(json_data[ll]);
		let mpbp_parent = $('#mpbp_add_new').children('input');
		for(let i=0;i<Object.keys(json_data).length; i++){
			let cookie_data = data[i].getAttribute('name');
			$('#mpbp_admin_'+ cookie_data).val(json_data[cookie_data]);
			/*if(get_inputs[i].tagName == 'INPUT'){
			mpbp_parent[i].value = json_data.data[i];
			}*/
		}
		//alert(JSON.stringify(mpbp_parent));
	});