<?php 
if ( (!isset($show_newsletter) || (!is_bool($show_newsletter))) ) {
  $show_newsletter = FALSE;
}

// setup some form stuff
if ( ($show_newsletter) && (!isset($newsletter_form)) ) {
  $form = new NewsletterForm();
  $form->build();
  $form->populate();
  //$newsletter_form = $form->getFields();
}
else if ( ($show_newsletter) && (isset($newsletter_form)) ) {
  $form_values = $newsletter_form->getFields();
}

//print_r($newsletter_form); exit; 
//print_r($_SERVER); exit;

if ($show_newsletter) { ?>
<div class="panel-block">
<div class="panel-title">
<h2>Subscribe Newsletter</h2>
</div>
<div class="panel-content">
<div class="subscribe-form">

<?php if ( (!is_null($newsletter_form)) && ($newsletter_form->isValid()) ) { ?>
<div class="info-message success">
<span class="icon-text">&#10003;</span>
<b>All Done!</b>
<p>Thank you for subscribing to our newsletter!</p>
<div class="clear-float"></div>
</div>
<?php } ?>

<?php if ( (!is_null($newsletter_form)) && ($newsletter_form->isSubmitted()) && (!$newsletter_form->isValid()) ) { ?>
<div class="info-message error">
<span class="icon-text">?</span>
<b>An Error Occurred</b>
<p><?php echo $form_values['nl_email']->error; ?></p>
<div class="clear-float"></div>
</div>
<?php } ?>

<form action="<?php echo Request::url(); ?>" method="POST">
<p class="sub-nickname">
<input type="text" name="nl_email" class="sub_email" value="" placeholder="E-mail" address""="">
</p>
<p class="sub-button">
<button class="styled-button" type="submit" name="nl_submit" value="1">Subscribe Newsletter</button>
</p>
<input type="hidden" name="nl_timestamp" value="<?php echo strtotime("now"); ?>">
</form>
</div>
<div class="subscribe-footer">

<p>By subscribing you will receive the latest in celebrity news, gossip, rumors and more! Your information is safe with us and it will not be shared with anyone.</p>
</div>

</div>
<!-- END .panel-block -->
</div>
<?php } ?>
