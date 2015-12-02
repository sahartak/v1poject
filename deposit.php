<?php

require_once('template.php');
page_header(5);



if($_SESSION['user']['is_logged']==1) {

    if(isset($_POST['submit']))
    {
        global $username;
        $a=new DBConnection();
        $Mailer=new App\Utility\Mailer($a);

        $to=getLang('site_notification');
        //$to='@gmail.com';

        $first= array_get($username, 'user_firstname');
        $last= array_get($username, 'user_lastname');
        $user_account_num=array($username,'user_account_num');
        $message="$first $last  requested funding information $user_account_num.";
        // Create the message
        $mailerMessage = Swift_Message::newInstance()

        // Give the message a subject
        ->setSubject('Request Funding Details')

        // Set the From address with an associative array
        ->setFrom(array(getLang('site_notification')=> getLang('site_notification')))

        // Set the To addresses with an associative array
        ->setTo(array($to))

        // Give it a body
        ->setBody($message);

        try{

            $Mailer->send($mailerMessage);
        }
        catch(Exeption $ex)
        {

        }



        $status=true;

    }
    echo '


  <div class="flat_area grid_16" style="opacity: 1;">
    <h2>'.getLang('deposit_head').'<small>  - '.getLang('deposit_subhead').'</small>
        </h2>
    </div>
  ';



echo '
<div class="grid_16 block box">
<div class="section">
<h3>'.getLang('deposit_regional_h').'</h3>

<p>'.getLang('deposit_regional_p').'</p>

<div class="columns">
  <div class="col_40">
    <h2 style="color:#C30;">'.getLang('deposit_funding_h').'</h2>
     <p><b>'.getLang('deposit_funding_h').'</b></p> 
     <blockquote>

      <p>'.getLang('deposit_funding_int_p').'</p> 

    </blockquote>
  </div>

  <div class="col_50 ">
    <div class="section">
      <p><br />

      '.getLang('deposit_funding_d1').'<br />

      <br />

      '.getLang('deposit_funding_d2').'<br />

    </p>
    <div>
    <form method="post" action="">
      <button type="submit" name="submit" class="dark green submit_button div_icon has_text">
        <i class="ui-icon ui-icon-check"></i>
         <span>'.getLang('deposit_request_funding_details').'</span>
      </button>
      <div class="clear"></div>
      ';

        if(isset($status) and $status)
        {
            echo '<p style="margin-top:10px;color:green;font-weight:bold;font-size:14px" class="">'.getLang('deposit_request_success').'</p>';
        }

    echo '
        </form>
              </div>
            </div>
          </div>
          </div>
        </div>
        ';



echo '

</div>';

}



page_footer();

?>