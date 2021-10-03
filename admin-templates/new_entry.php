<?php
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
  <h3 class="wqpage_heading">Nouveau</h3>
  <div class="wqsubmit_message"></div>
  <div>&nbsp;</div>
  <div class="wqform_body">
    <form name="entry_form" id="entry_form">

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
