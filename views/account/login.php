<a href="account/register" title="Sign up" class="signedUp">Sign up</a>
<div class="registerForm">
	<div class="formHeader">
		<h2>Sign in</h2>
	</div>
	<form method="POST" action="account/login">
		<div class="registerErrors">
			<p><?php
				if (isset($_GET['mailVerify'])) {
						echo "An email has been sent to you. To complete the registration, follow the instructions in the email.<br>";
				}
				if (isset($_POST['error'])) {
					foreach ($_POST['error'] as $kay)
						echo $kay."<br>";
					}
				?></p>
		</div>
		<div class="registerField">
			<label>Email</label><br>
			<input name="u_email" size="20" type="email" placeholder="Email" value="<?php if (isset($_POST['u_email'])) echo $_POST['u_email'];?>"><br>
		</div>
		<div class="registerField">
			<label>Password</label><br>
			<input name="u_pass" type="password" placeholder=""><br>
		</div>
		<div class=registerButton">
			<input name="submit" type="submit" value="Submit"><br>
		</div>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
	</form>
</div>