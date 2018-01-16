jQuery( document ).ready(function( $ ) {
  var credCardField = '#billing_amex'; //this selector may be different
  $('#credit_card_number').blur(function(){
    var ccnum = $(this).val();
    if (ccnum.startsWith('3')) {
      $(credCardField).attr('checked','checked');
      $('body').trigger('update_checkout');
    }
  });
  $('#billing_amex').change(function(){
      $('body').trigger('update_checkout');
  });
});