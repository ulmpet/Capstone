<?php

        $captcha;
        
        if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        
        if(!$captcha)
        {
          echo '<h2>Please check the the captcha form.</h2>';
          exit;
        }
        
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ldg5AUTAAAAAL-yaLI2L6HyD0MYehEWS_XxOYWJ&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        
        if($response.success==false)
        {
          echo '<h2>You are spammer, get the @$%* out!</h2>';
        }

        else
        {
          echo '<h2>Thank you for registering an account!.</h2>';
        }
?>