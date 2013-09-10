
/*
* Constantes que indican el valor de retorno de validar el rut
*/
const DV_CORRECTO = 0;
const DV_NO_VALIDO = 1;
const DV_INCORRECTO = 2;


function calculaDigitoVerificador(rut, guionCaracter) {

	if(isNaN(rut) || rut.length == 0 || rut.length > 8 || tiene_letras(rut)) {
    return DV_NO_VALIDO;
  } 
  else {
  	if(getDV(rut) == guionCaracter.toLowerCase())
      return DV_CORRECTO;
  	else{
  		return DV_INCORRECTO;
  	}
  }
}
 
function getDV(rut) {

	var ag=rut.split('').reverse();
  for(total=0,n=2,i=0;i<ag.length;((n==7) ? n=2 : n++),i++)
  {
    total+=ag[i]*n;
  }
  var resto=11-(total%11);
  return (resto<10)?resto:((resto>10)?0:'k');
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
