$('.search-custom input').focus(function(){
	$(this).parents('form').addClass('focused');
});

$('.search-custom input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).removeClass('filled');
    $(this).parents('form').removeClass('focused');  
  } else {
    $(this).addClass('filled');
  }
});

$('.modal').on('shown.bs.modal', function () {
    $('#search-input').focus()
  })