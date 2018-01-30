
jQuery(document).ready(function() {

    paintTable();

    jQuery('#form-select-button').click(function(e) {

     // SUBMISSION ARRAY
     var formdata = [jQuery('#post').val(),
                     jQuery('#page').val(),
                     jQuery('#quote').val(),
                     jQuery('#client').val()];

      // INSERT FORM SUBMISSION INTO DB
      jQuery.ajax({
         type: 'POST',
         url: ajaxurl,
         data: {"action": "purlform_insert", "data": formdata},
            success: function(data,status)
            {
              createTableByForLoop(data);
              createTableByJqueryEach(data);
                jQuery('.query_result').html(data);
            },
            async:   true,
            dataType: 'json'
       });
    });



  function paintTable(formdata) {
      jQuery.ajax({
         type: 'POST',
         url: ajaxurl,
         data: {"action": "purlform_insert", "data": formdata},
            success: function(data,status)
            {
              createTableByForLoop(data);
              jQuery('.query_result').html(data);
            },
            async:   true,
            dataType: 'json'
       });
    }

  function createTableByForLoop(data)
  {
    var eTable="<table id=\"data_table\" width=\"80%\" border=\"1\"><thead><tr><th>Post</th><th>Page</th><th>Quote</th><th>Client</th><th>Link</th></tr></thead><tbody>"
    for(var i=0; i<data.length;i++)
    {
      eTable += "<tr>";
      //eTable += "<td>"+data[i][0]+"</td>";
      eTable += "<td>"+data[i][1]+"</td>";
      eTable += "<td>"+data[i][2]+"</td>";
      eTable += "<td>"+data[i][3]+"</td>";
      eTable += "<td>"+data[i][4]+"</td>";
      eTable += "<td>"+data[i][5]+"</td>";
      eTable += "</tr>";
    }
    eTable +="</tbody></table>";
    jQuery('#forTable').html(eTable);
  }

});
