$(document).ready(function(){
    $('.user-type').change(function(){
        
        if($('.user-type').val() == 'Non -Jenius User'){
            $('#form-cashtag').addClass( "d-none" );
        }else{
            $('#form-cashtag').removeClass( "d-none" );
        }
    });
    $(':input[type="submit"]').prop('disabled', true);
    
    
    setTimeout(function() {
        $(".alert-get-help").alert('close');
    }, 3000);
});

function recallback() {
    $('#submit_form').removeAttr('disabled');
}; 