<?php


function my_action_callback() {
	require_once('../../../wp-load.php' );
	global $wpdb; // this is how you get access to the database

	$name = $_POST['name'];
	$email = $_POST['email'];
	$my_email = $_POST['my_email'];
	$subject = $_POST['subject'];
	$msg = $_POST['message'];
	if (strlen($name)>2 && strlen($msg)>5)
	{
		$head = 'Full Name: '.$name.' | Email Adress : '.$email;
		$result = wp_mail( $my_email, $subject, $msg, $head);
		if ($result)
        {
			echo "Message sent!";
		}
        else
		{
			echo "Message was not sent!";
		}
	}
	die(); // this is required to return a proper result
}
my_action_callback();?>