

function calculaDigitoVerificador() {
	var inputRut = document.getElementById("inputRut");
	var rut = inputRut.value;
	var inputGuionRut = document.getElementById("inputGuionRut");
	var guionCaracter = inputGuionRut.value;

	if(isNaN(rut) || rut.length == 0 || rut.length > 8 || tiene_letras(rut)) {
        alert("Rut no valido");
    } 
    else {
    	if(getDV(rut) == guionCaracter.toLowerCase()) alert("Rut correcto");
    	else{
    		alert("Rut incorrecto");
    	}    	
    }
    
                
}
 
function getDV(rut) {

	var ag=rut.split('').reverse()
    for(total=0,n=2,i=0;i<ag.length;((n==7) ? n=2 : n++),i++)
    {
        total+=ag[i]*n
    }
    var resto=11-(total%11)
    return (resto<10)?resto:((resto>10)?0:'k')

}



function tiene_letras(texto){
	var letras="abcdefghyjklmnñopqrstuvwxyz";
    texto = texto.toLowerCase();
    for(i=0; i<texto.length; i++){
       if (letras.indexOf(texto.charAt(i),0)!=-1){
          return true;
       }
   }
   return false;
}


