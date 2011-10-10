<?php echo $this->partial('maps/admin-header.php', array('subtitle' => 'Create Map')); ?>
<?php
  $postSize = return_bytes(ini_get('post_max_size'));
  $fileSize = return_bytes(ini_get('upload_max_filesize'));

  function return_bytes($val) 
  {
    $val = trim($val);
    $last = strtolower($val[strlen($val) - 1]);
    switch($last) {
    case 'g':
      $val *= 1024;
    case 'm':
      $val *= 1024;
    case 'k':
      $val *= 1024;
    }
    return $val;
  }

  function return_mb($val) {
    return round(($val / 1048576), 2) . "MB";
  }
?>
<div id="primary" class="neatline-maps-getfiles">

    <?php echo flash(); ?>

    <h2>Upload more files to map "<?php echo $map->name; ?>":</h2>

    <form enctype="multipart/form-data" action="uploadfiles" method="post">
    <div class="field" id="map-inputs">
    <label>Upload map files (<span class="smaller"><?php echo return_mb(min($postSize, $fileSize)); ?>):</label>
        <div class="maps inputs">
            <input name="map[0]" id="file-1" type="file" class="fileinput" />
        </div>
    </div>

    <script>

    /**
     * Allow adding an arbitrary number of file input elements to the items form so that
     * more than one file can be uploaded at once.
     */
    Omeka.enableAddMaps = function () {
        var filesDiv = jQuery('#map-inputs .maps').first();
        var filesDivWrap = jQuery('#map-inputs');

        var link = jQuery('<a href="#" id="add-map" class="add-map tab">Add Another File</a>');
        link.click(function (event) {
            event.preventDefault();
            var inputs = filesDiv.find('input');
            var inputCount = inputs.length;
            var fileHtml = '<div id="mapinput' + inputCount + '" class="mapinput"><input name="map[' + inputCount + ']" id="map[' + inputCount + ']" type="file" class="mapinput" /></div>';
            jQuery(fileHtml).insertAfter(inputs.last()).hide().slideDown(200, function () {
                // Extra show fixes IE bug.
                jQuery(this).show();
            });
        });

        jQuery('#add-more-maps').html('');
        filesDivWrap.append(link);
    };

    jQuery(window).load(function () {
        Omeka.enableAddMaps();
    });

    </script>

      <dl class="zend_form">

        <dd id="create_map-element">
          <input type="submit" name="add_files" id="create_map" value="Add Files">
        </dd>

      </dl>

    </form>

</div>

<?php foot(); ?>

