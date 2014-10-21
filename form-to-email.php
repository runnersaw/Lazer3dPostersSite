<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}

$visitor_email = $_POST['email'];

//Validate first
if(empty($visitor_email)) 
{
    echo "Email is mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'sawyerv726@gmail.com';//<== update the email address
$email_subject = "New Form submission";
$email_body = "You have received a new message from the user $email.\n".
    
$to = "sawyer.vaughan@students.olin.edu";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: index.html');

$myfile = fopen("emails.txt", "w") or die("Unable to open file!");
fwrite($myfile, $visitor_email);
fclose($myfile);

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?> 