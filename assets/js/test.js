$(document).ready(function(){
  $("#myBtn").click(function(){
    //disable the submit button
    $(this).attr('disabled','true');$(this).css('cursor','progress');$(this).html('processing');
    $.ajax({
      url: 'createTable.php',
      success: function(data,status)
      {
        createTableByForLoop(data);
        createTableByJqueryEach(data);
        //enable the submit button
        $('#myBtn').css('cursor','pointer');$('#myBtn').html('Submit');$('#myBtn').removeAttr('disabled');
      },
      async:   true,
      dataType: 'json'
    });
  });
});
