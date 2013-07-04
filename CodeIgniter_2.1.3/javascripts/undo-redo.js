
function bool(str) {
    if (str === "true") return true;
    else return false;
}
 
var num_states = 0;
var current_state = 0;

var text_elements   = 'input[type="text"],input[type="email"], input[type="password"], textarea';
var state_elements  = 'input[type="radio"], input[type="checkbox"]';
var select_elements = 'input[type="number"],input[type="color"],input[type="date"], select, input[type="hidden"]' ;

function saveState(){
    num_states = current_state;
    num_states++;
    $('.undo').removeAttr( "disabled");
    $('.redo').attr( "disabled", "disabled" );
    current_state = num_states;
   
    $(select_elements+","+text_elements).each(function() {
        var current_val = $(this).val();
        var prev = $(this).attr('data-previous').split(',').slice(0,num_states);
        prev.push(current_val);
        $(this).attr('data-previous', prev.join(','));
    });
    $(state_elements).each(function() {
        var current_val = $(this).prop('checked');
        var prev = $(this).attr('data-previous').split(',').slice(0,num_states);
        prev.push(current_val);
        $(this).attr('data-previous', prev.join(','));
    });
}
 
$(document).ready(function() {
   
    // Se guardan los valores iniciales
    $(text_elements+","+select_elements).each(function() {
        var val = $(this).val();
        $(this).attr('data-previous', val);
    });
    $(state_elements).each(function() {
        var val = $(this).prop('checked');
        $(this).attr('data-previous', val);
    });
   
    // On change se agrega un estado a cada elemento
   $(state_elements+","+select_elements).on('change', function() {
        if($(this).val() != $(this).attr('data-previous').split(",")[current_state]){
            saveState();
        }
    });
    $(text_elements+","+select_elements).keyup(function() {
        if($(this).val() != $(this).attr('data-previous').split(",")[current_state]){
            saveState();
        }            
    });
   
    $('.undo, .redo').on('click', function() {
        editado = false;
        if ($(this).hasClass('undo')) {
            // undo
            if (current_state == 0)  return false;
            
            if(editado){
                saveState();
                current_state--;
                $('.redo').removeAttr( "disabled");
                if(current_state==0){
                    $('.undo').attr( "disabled", "disabled" );
                }
            }else{
                current_state--;
                $('.redo').removeAttr( "disabled");
                if(current_state==0){
                    $('.undo').attr( "disabled", "disabled" );
                }
            }
            
        } else {
            // redo
            if (current_state == num_states) return false;
            current_state++;
            $('.undo').removeAttr( "disabled");
            if(current_state==num_states){
                $('.redo').attr( "disabled", "disabled" );
            }
        }
       
        $(select_elements+","+text_elements).each(function() {
            
            var prev   = $(this).attr('data-previous').split(',');
            var actual = $(this).val();
            $(this).val(prev[current_state]);
            if(actual != $(this).val()){
                $(this).trigger('onchange');
            }
        });
        $(state_elements).each(function() {
            var prev = $(this).attr('data-previous').split(',');
            var actual = $(this).prop('checked');
            $(this).prop('checked', bool(prev[current_state]));
            if( actual != $(this).prop('checked') ){
                //this.onchange();
                $(this).trigger('onchange');
            }
        });
       
        return true;
    });
 
   
});