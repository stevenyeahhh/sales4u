$.validator.messages="<font color=red>Este campo es obligatorio</font>";
//$.validator.messages.required="Este campo es obligatorio";
$(document).ready(function(){
	$("form").validate({
		rules:{
			nombre:{
				required:true,
				regexp:"^[a-zA-Z\d]"
			},
			apellido:{
				required:true,
				regexp:"^[a-zA-Z\d]"
			},
			id:{
				required:true
			},
			contrasena:{
				required:true
			},
			telefono:{
				required:true,
				number:true
			}
		},
		messages:{
			nombre:{required:"<br/><font color=red>Este campo es obligatorio</font>",regexp:"<br/><font color=red>Este campo debe ser s&oacute;lo letras</font>"},
			apellido:{required:"<br/><font color=red>Este campo es obligatorio</font>",regexp:"<br/><font color=red>Este campo debe ser s&oacute;lo letras</font>"},
			id:"<br/><font color=red>Este campo es obligatorio</font>",
			contrasena:"<br/><font color=red>Este campo es obligatorio</font>",
			telefono:{
				required:"<br/><font color=red>Este campo es obligatorio</font>",
				number:"<br/><font color=red>Este campo debe ser s&oacute;lo n&uacute;meros</font>"
			}
		}
	});

});
