<?php
class NewsletterForm extends UIForm {

  public function build() {
    parent::build();
    $this->addField(
      array('name'=>'nl_email','required'=>TRUE,'value'=>"",'default_error'=>"Your email address cannot be empty",
      'validator'=>array(
        array('func'=>Regex::EMAIL_ADDRESS,'message'=>"You must enter a valid email address")
      )),
      array('name'=>'nl_frequency','required'=>FALSE,'value'=>"",'default_error'=>""),
      array('name'=>'nl_timestamp','required'=>TRUE,'value'=>"",'default_error'=>"An unknown error has occurred"),
      array('name'=>'nl_submit','required'=>TRUE,'value'=>"",'default_error'=>"An unknown error has occurred")
    );
  }

  public function validate() {
    parent::validate(); 
    // loop over form fields and apply class or style
    foreach ($this->form_fields as $field) {
      if ($field->valid) {
        $this->form_fields[$field->name]->error = "";
      }
    }
  }
 
  // allows the form to have a submitted status set
  public function submitted($b) {
    $this->form_submitted = $b;
  }

  public function alter() {
    parent::alter();
  }
}
