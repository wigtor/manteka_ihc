

function calculaDigitoVerificador() {
	var inputRut = document.getElementById("inputRut");
	var rut = inputRut.value;
	var inputGuionRut = document.getElementById("inputGuionRut");
	var guionCaracter = inputGuionRut.value;

	if(isNaN(rut) || rut.length == 0 || rut.length > 8 ) {
        alert("Rut malo");
    } 
    else {
    	if(getDV(rut) == guionCaracter.toLowerCase()) alert("Rut bueno");
    }
    //alert("Rut malo");
                
}
 
function getDV(rut) {

	var ag=rut.split('').reverse()
    for(total=0,n=2,i=0;i<ag.length;((n==7) ? n=2 : n++),i++)
    {
        total+=ag[i]*n
    }
    var resto=11-(total%11)
    return (resto<10)?resto:((resto>10)?0:'k')

	/*
    nuevo_numero = numero.toString().split("").reverse().join("");
    for(i=0,j=2,suma=0; i < nuevo_numero.length; i++, ((j==7) ? j=2 : j++)) {
        suma += (parseInt(nuevo_numero.charAt(i)) * j); 
    }
    n_dv = 11 - (suma % 11);
    return ((n_dv == 11) ? 0 : ((n_dv == 10) ? "K" : n_dv));*/
}

