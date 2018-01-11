    <div class="panel panel-info">
      <div class="panel-heading">
          <img src="<?php print plugins_url(); ?>/purl-form/assets/images/purl-form.png" width="200px">
       </div>
       <div class="panel-body">



    <div id="Webforms">
      Select Post or Page that has the webfrom you would like shared<br>
      <select name="posts">
        <?php print $postOptions; ?>
      </select>
      Or
      <select name="pages">
        <?php print $pageOptions; ?>
      </select>
      <button id="form-select-button" value="form-select">Select</button>
    </div>


    <div id="right">
      <h3>Purl List</h3>
      <div class="query_result">

      </div>
    </div>


    <div class="clear"></div>

    </div>
  </div>
