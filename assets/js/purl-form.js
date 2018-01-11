jQuery(document).ready(function() {
  console.log(this);
  jQuery('#form-select-button').click(function(e) {
      var pressed = jQuery('#url').val();
      console.log(pressed);
      purlform(pressed);
  });



  var purlform = function(e) {
     var purlForm = (e);
     console.log(purlForm);
     var pluginUrl = '<?php echo plugins_url(); ?>' ;
     var sendData = jQuery.ajax({
               type: 'POST',
               url: pluginUrl+'/punchgroove/assets/ajax/ajax.php',
               data: {purlForm},
                 success: function(resultData) {
                     jQuery('.pm').html(resultData);
                 }
             }); // end ajax call
  }

});
