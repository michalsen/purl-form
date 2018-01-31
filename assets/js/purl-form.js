
jQuery(document).ready(function() {

    paintTable();

    jQuery('#form-select-button').click(function(e) {
     // SUBMISSION ARRAY
     var formdata = [jQuery('#post').val(),
                     jQuery('#page').val(),
                     jQuery('#quote').val(),
                     jQuery('#client').val()];
      ajaxSubmit('purlform_insert', formdata);
    });

  // Submit Ajax
  function ajaxSubmit(direction, submitteddata) {
    if( typeof submitteddata === 'string' ) {
      var submitteddata = submitteddata.split();
    }

      jQuery.ajax({
         type: 'POST',
         url: ajaxurl,
         data: {"action": direction, "data": submitteddata},
            success: function(data,status)
            {
              createTableByForLoop(data);
              jQuery('.query_result').html(data);
            },
            error: function(data,status)
            {
              console.log(status);
            },
            async:   true,
            dataType: 'json'
       });
  }

  // Present Table
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


  // Build Table
  function createTableByForLoop(data) {
    var eTable="<form><table id=\"data_table\" width=\"80%\" border=\"1\"><thead><tr><th>Remove</th><th>Post</th><th>Page</th><th>Quote</th><th>Client</th><th>Link</th></tr></thead><tbody>"
    for(var i=0; i<data.length;i++)
    {
      eTable += "<tr>";
      eTable += "<td><input type=\"button\" class=\"remove_purl\" id="+data[i][0]+" value=\"X\"></td>";
      eTable += "<td>"+data[i][2]+"</td>";
      eTable += "<td>"+data[i][1]+"</td>";
      eTable += "<td>"+data[i][3]+"</td>";
      eTable += "<td>"+data[i][4]+"</td>";
      eTable += "<td>"+data[i][5]+"</td>";
      eTable += "</tr>";
    }
    eTable +="</tbody></table></form>";

     jQuery('#forTable').html(eTable);

     jQuery('.remove_purl').click(function(event){
         var id = jQuery(this).attr('id');
         ajaxSubmit('purlform_remove', id);
     });

  }



});
