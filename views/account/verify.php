<?php
if (isset($_GET['mailVerify']) && $_GET['mailVerify'] == '1')
	echo "An email has been sent to you. To complete the registration, follow the instructions in the email.<br>";
if (isset($_GET['mailVerify']) && $_GET['mailVerify'] == 'yes')
	echo "Account activated. Please <a href=\"/account/login\" title=\"Sign in\" class=\"headerText\">Sign in</a>.<br>";