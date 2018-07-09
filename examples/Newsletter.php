<?php
class Newsletter {

public $submit_value = 1;

public function process() {
  $form = new NewsletterForm();
  $form->build(); $form->populate($_POST);

  // check to see if a search was submitted
  $submit_button = $form->getField('nl_submit');
  $form_fields = $form->getFields();
  if ((!is_null($submit_button)) && (strcasecmp($submit_button->value,$this->submit_value) == 0)) {
    // validate the form
    $form->validate();
    $input = $form->getFields();

    $form->submitted(TRUE);

    if ($form->isValid()) {
      // do valid actions
      $this->process_action($input);
    }
    else {
      // if no error in nl_email
      if ($input['nl_email']->valid) {
        $input['nl_email']->error = "We were unable to accept your subscription request at this time";
      }
    }
    $form_fields = $input;
  }
  return $form;
}

private function process_action($input) {
  $frequency = "none";

  // check to see if email is already present
  $user = DB::table('user')->select('user.user_id','user.email','user.comm_type')->where('user.email','=',$input['nl_email']->value)->get();

  // handle the comm_type selection
  if ($input['nl_frequency']->value == 2) {
    $frequency = 'newsletter_weekly';
  }
  else if ($input['nl_frequency']->value == 1) {
    $frequency = 'newsletter_daily';
  }
  else {
    $frequency = "newsletter_weekly";
  }

  if (count($user) == 1) {
    // this user already exists
    DB::table('user')->where('user_id',$user[0]->user_id)
      ->update(
        array('email'=>$input['nl_email']->value,'comm_type'=>$frequency,'role'=>'subscriber')
      );
  }
  else {
    // if not, insert email and newsletter frequency 
    $user_id = DB::table('user')->insertGetId(
        array('email' => $input['nl_email']->value, 'comm_type' => $frequency, 'role'=>'subscriber')
      );
  }
}

}
?>
