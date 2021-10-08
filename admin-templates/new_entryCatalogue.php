<?php
wp_enqueue_media();
if(isset($_REQUEST['entryid']) && $_REQUEST['entryid']!='') {
  global $wpdb;
  $data = $wpdb->get_row( "SELECT * FROM `wp_reseller` WHERE id = '".$_REQUEST['entryid']."'" );
?>
  <div class="wrap wqmain_body">
    <h3 class="wqpage_heading">Modification</h3>
    <div class="wqsubmit_message"></div>
    <div>&nbsp;</div>
    <div class="wqform_body">
      <form name="update_form" id="update_form">
      <input type="hidden" name="wqentryid" id="wqentryid" value="<?=$_REQUEST['entryid']?>" />
      <div class="wqlabel">Raison Social</div>
      <div class="wqfield">
        <input type="text" class="wqtextfield" name="resellerRS"  placeholder="Raison Social" value="<?=$data->resellerRS?>" required/>
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Prénom responsable</div>
      <div class="wqfield">
        <input type="text" class="wqtextfield" name="name"  placeholder="Prénom responsable" value="<?=$data->name?>"  />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Nom responsable</div>
      <div class="wqfield">
        <input type="text" class="wqtextfield" name="surname"  placeholder="Nom responsable" value="<?=$data->surname?>" />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">E-mail</div>
      <div class="wqfield">
        <input type="email" class="wqtextfield" name="mail"  placeholder="E-mail" value="<?=$data->mail?>" required />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Téléphone</div>
      <div class="wqfield">
        <input type="tel" class="wqtextfield" name="tel"  placeholder="Téléphone" value="<?=$data->tel?>" />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Mot de Passe</div>
      <div class="wqfield">
        <input type="password" class="wqtextfield" name="passCatalogue"  placeholder="Mot de Passe" value="" />
      </div>

      <div>&nbsp;</div>
    
        <div><input type="submit" class="wqsubmit_button" id="wqedit" value="Modifier" /></div>
        <div>&nbsp;</div>
        

      </form>
    </div>
  </div>
<?php
} else {
?>
<div class="wrap wqmain_body">
  <h3 class="wqpage_heading">Nouveau Catalogue</h3>
  <div class="wqsubmit_message"></div>
  <div>&nbsp;</div>
  <div class="wqform_body">
    <form name="entry_form" id="entry_form">
    <label for="image_url">Image</label>
    <input type="text" name="image_url" id="image_url" class="regular-text">
    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
      <div class="wqlabel">Raison Social</div>
      <div class="wqfield">
        <input type="text" class="wqtextfield" name="resellerRS"  placeholder="Raison Social" value="" required/>
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Prénom responsable</div>
      <div class="wqfield">
        <input type="text" class="wqtextfield" name="name"  placeholder="Prénom responsable" value=""  />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Nom responsable</div>
      <div class="wqfield">
        <input type="text" class="wqtextfield" name="surname"  placeholder="Nom responsable" value="" />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">E-mail</div>
      <div class="wqfield">
        <input type="email" class="wqtextfield" name="mail"  placeholder="E-mail" value="" required />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Téléphone</div>
      <div class="wqfield">
        <input type="tel" class="wqtextfield" name="tel"  placeholder="Téléphone" value="" />
      </div>
      <div>&nbsp;</div>
      <div class="wqlabel">Mot de Passe</div>
      <div class="wqfield">
        <input type="password" class="wqtextfield" name="passCatalogue"  placeholder="Mot de Passe" value="" required/>
      </div>

      <div>&nbsp;</div>
      
     

      <div><input type="submit" class="wqsubmit_button" id="" value="Ajouter" /></div>
      <div>&nbsp;</div>
      
    </form>
  </div>
</div>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#image_url').val(image_url);
        });
    });
});
</script>