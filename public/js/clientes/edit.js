//funcion para comprobar si el  CUI  es valido
function cuiIsValid(cui) {
	var dd= ($("#tipo_documento_id").find("option:selected").text()).toUpperCase();
	if(dd=='DPI' ||dd=='CUI' ||dd=='DPI/CUI' || dd=='DPI-CUI' || dd=='CUI/DPI'){
		var console = window.console;
		if (!cui) {
			//console.log("CUI vacío");
			return true;
		}

		var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;

		if (!cuiRegExp.test(cui)) {
			//console.log("CUI con formato inválido");
			return false;
		}

		cui = cui.replace(/\s/, '');
		var depto = parseInt(cui.substring(9, 11), 10);
		var muni = parseInt(cui.substring(11, 13));
		var numero = cui.substring(0, 8);
		var verificador = parseInt(cui.substring(8, 9));
		
		// Se asume que la codificación de Municipios y 
		// departamentos es la misma que esta publicada en 
		// http://goo.gl/EsxN1a

		// Listado de municipios actualizado segun:
		// http://goo.gl/QLNglm

		// Este listado contiene la cantidad de municipios
		// existentes en cada departamento para poder 
		// determinar el código máximo aceptado por cada 
		// uno de los departamentos.
		var munisPorDepto = [ 
			/* 01 - Guatemala tiene:      */ 17 /* municipios. */, 
			/* 02 - El Progreso tiene:    */  8 /* municipios. */, 
			/* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */, 
			/* 04 - Chimaltenango tiene:  */ 16 /* municipios. */, 
			/* 05 - Escuintla tiene:      */ 13 /* municipios. */, 
			/* 06 - Santa Rosa tiene:     */ 14 /* municipios. */, 
			/* 07 - Sololá tiene:         */ 19 /* municipios. */, 
			/* 08 - Totonicapán tiene:    */  8 /* municipios. */, 
			/* 09 - Quetzaltenango tiene: */ 24 /* municipios. */, 
			/* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */, 
			/* 11 - Retalhuleu tiene:     */  9 /* municipios. */, 
			/* 12 - San Marcos tiene:     */ 30 /* municipios. */, 
			/* 13 - Huehuetenango tiene:  */ 32 /* municipios. */, 
			/* 14 - Quiché tiene:         */ 21 /* municipios. */, 
			/* 15 - Baja Verapaz tiene:   */  8 /* municipios. */, 
			/* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */, 
			/* 17 - Petén tiene:          */ 14 /* municipios. */, 
			/* 18 - Izabal tiene:         */  5 /* municipios. */, 
			/* 19 - Zacapa tiene:         */ 11 /* municipios. */, 
			/* 20 - Chiquimula tiene:     */ 11 /* municipios. */, 
			/* 21 - Jalapa tiene:         */  7 /* municipios. */, 
			/* 22 - Jutiapa tiene:        */ 17 /* municipios. */ 
		];
		
		if (depto === 0 || muni === 0)
		{
			console.log("CUI con código de municipio o departamento inválido.");
			return false;
		}
		
		if (depto > munisPorDepto.length)
		{
			console.log("CUI con código de departamento inválido.");
			return false;
		}
		
		if (muni > munisPorDepto[depto -1])
		{
			console.log("CUI con código de municipio inválido.");
			return false;
		}
		
		// Se verifica el correlativo con base 
		// en el algoritmo del complemento 11.
		var total = 0;
		
		for (var i = 0; i < numero.length; i++)
		{
			total += numero[i] * (i + 2);
		}
		
		var modulo = (total % 11);
		
		console.log("CUI con módulo: " + modulo);
		return modulo === verificador;
	}else{
		return true;
	}
}


$.validator.addMethod("dpi", function(value, element) {
		var valor = value;
		if (cuiIsValid(valor) == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}, "El CUI/DPI ingresado está incorrecto");



// funcion para comprobar si el NIT es valido
function ValidaNIT(txtN) {
	txtN = txtN.toUpperCase();
	var nit = txtN;
	var pos = nit.indexOf("-");
	if(nit=='CF' || nit =='C/F'){
		return true;
	}else{
		if (pos < 0)
		{
			var correlativo = txtN.substr(0, txtN.length - 1);
			correlativo = correlativo + "-";

			var pos2 = correlativo.length - 2;
			var digito = txtN.substr(pos2 + 1);
			nit = correlativo + digito;
			pos = nit.indexOf("-");
			txtN = nit;
		}

		var Correlativo = nit.substr(0, pos);
		var DigitoVerificador = nit.substr(pos + 1);
		var Factor = Correlativo.length + 1;
		var Suma = 0;
		var Valor = 0;
		for (x = 0; x <= (pos - 1); x++) {
			Valor = eval(nit.substr(x, 1));
			var Multiplicacion = eval(Valor * Factor);
			Suma = eval(Suma + Multiplicacion);
			Factor = Factor - 1;
		}
		var xMOd11 = 0;
		xMOd11 = (11 - (Suma % 11)) % 11;
		var s = xMOd11;
		if ((xMOd11 == 10 && DigitoVerificador == "K") || (s == DigitoVerificador)) {
			return true;
		}
		else
		{
			return false; 
		}
	}
}


$.validator.addMethod("nit", function(value, element){
	var valor = value;

	if(ValidaNIT(valor)==true)
	{
		return true;
	}

	else
	{
		return false;
	}
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");




var validator = $("#ClienteUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nit:{
			required: true,
			nit:true,
			nitUnico: true
		},
		no_documento:{
			required: true,
			cuiUnico : true,
			dpi : true
		},
		nombres: {
			required : true
		},

		apellidos: {
			required : true
		},
		tipo_id: {
			required : true
		},
		tipo_documento_id: {
			required : true
		},
		correo:{
			required: true,
			email: true
		},
		celular:{
			required: true,
			minlength: 8,
			maxlength: 8
		},
		nacimiento:{
			required: true
		},
		direccion:{
			required: true
		},
		telefono:{
			minlength: 8,
			maxlength: 8
		},

	},
	messages: {
		nit: {
			required: "Por favor, ingrese el NIT del cliente"
		},
		no_documento: {
			required: "Por favor, ingrese número de documento de identificación del cliente"
		},
		nombres: {
			required: "Por favor, ingrese los nombres del cliente"
		},

		apellidos: {
			required: "Por favor, ingrese los apellidos del cliente"
		},
		tipo_id: {
			required: "Por favor, seleccione el tipo de cliente"
		},
		tipo_documento_id: {
			required: "Por favor, seleccione El tipo de documento de identificación"
		},
		correo:{
			required: "Por favor, ingrese el correo electrónico",
			email: "El correo electrónico ingresado no es valido"
		},
		celular:{
			required:'Por favor, ingrese un numero celular',
			maxlength: 'El número de celular debe contener 8 dígitos.',
			minlength: 'El número de celular debe contener 8 dígitos.'
		},
		nacimiento:{
			required: "Por favor, seleccione la fecha de nacimiento del cliente"
		},
		direccion:{
			required: "Por favor, ingrese la Dirección del cliente"
		},
		telefono:{
			maxlength: 'El número de Teléfono debe contener 8 dígitos.',
			minlength: 'El número de Teléfono debe contener 8 dígitos.'
		},

	}
});