
function bool(str) {
    if (str === "true") return true;
    else return false;
}
 
var num_states = 0;
var current_state = 0;

var text_elements   = 'input[type="text"],input[type="email"], input[type="password"], textarea';
var state_elements  = 'input[type="radio"], input[type="checkbox"]';
var select_elements = 'input[type="number"],input[type="color"],input[type="date"], select ' ;

 
$(document).ready(function() {
   
    // Se guardan los valores iniciales
    $(text_elements, '.undoable form').each(function() {
        var val = $(this).val();
        $(this).attr('data-previous', val);
    });
    $(select_elements, '.undoable form').each(function() {
        var val = $(this).val();
        $(this).attr('data-previous', val);
    });
    $(state_elements, '.undoable form').each(function() {
        var val = $(this).prop('checked');
        $(this).attr('data-previous', val);
    });
   
    // On change se agrega un estado a cada elemento
    $(state_elements+","+select_elements, '.undoable form').on('change', function() {
        num_states = current_state;
        num_states++;
        $('.undo').removeAttr( "disabled");
        current_state = num_states;
       
        $(select_elements, '.undoable form').each(function() {
            var current_val = $(this).val();
            var prev = $(this).attr('data-previous').split(',').slice(0,num_states);
            prev.push(current_val);
            $(this).attr('data-previous', prev.join(','));
        });
        $(state_elements, '.undoable form').each(function() {
            var current_val = $(this).prop('checked');
            var prev = $(this).attr('data-previous').split(',').slice(0,num_states);
            prev.push(current_val);
            $(this).attr('data-previous', prev.join(','));
        });
    });
    $(text_elements, '.undoable form').keyup(function() {
        num_states = current_state;
        num_states++;
        $('.undo').removeAttr( "disabled");
        current_state = num_states;
       
        $(text_elements, '.undoable form').each(function() {
            var current_val = $(this).val();
            var prev = $(this).attr('data-previous').split(',').slice(0,num_states);
            prev.push(current_val);
            $(this).attr('data-previous', prev.join(','));
        });
    });
   
    $('.undo, .redo', '.undoable .undoredo').on('click', function() {
        if ($(this).hasClass('undo')) {
            // undo
            if (current_state == 0)  return false;
            
            current_state--;
            $('.redo').removeAttr( "disabled");
            if(current_state==0){
                $('.undo').attr( "disabled", "disabled" );
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
       
        $(text_elements, '.undoable form').each(function() {
            var prev = $(this).attr('data-previous').split(',');
            $(this).val(prev[current_state]);
        });
        $(select_elements, '.undoable form').each(function() {
            var prev = $(this).attr('data-previous').split(',');
            $(this).val(prev[current_state]);
        });
        $(state_elements, '.undoable form').each(function() {
            var prev = $(this).attr('data-previous').split(',');
            $(this).prop('checked', bool(prev[current_state]));
        });
       
        return true;
    });
 
   
});