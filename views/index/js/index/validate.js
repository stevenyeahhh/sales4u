$(document).ready(function(){
	$("form").validate({
		rules:{
			usuario:{
				required:true
			},
			contrasena:{
				required:true,
				regexp:"^[0-9A-Za-z]+$"
			}
		},
		messages:{
			usuario:"",
			contrasena:""
		}
	});

});
