<div class="registerForm">
	<div class="formHeader">
		<h2>Sign up</h2>
	</div>
	<form method="POST" action="account/register">
		<div class="registerErrors">
			<p><?php if (isset($_POST['error']))
				foreach ($_POST['error'] as $kay)
					echo $kay."<br>";
				?></p>
		</div>
		<div class="registerField">
			<label>Nickname</label><br>
			<input name="u_nickname" size="20" type="text" placeholder="Nickname" value="<?php if (isset($_POST['u_nickname'])) echo $_POST['u_nickname'];?>"><br>
		</div>
		<div class="registerField">
			<label>Email</label><br>
			<input name="u_email" size="20" type="email" placeholder="Email" value="<?php if (isset($_POST['u_email'])) echo $_POST['u_email'];?>"><br>
		</div>
		<div class="registerField">
			<label>Password</label><br>
			<input name="u_pass" type="password" placeholder="At least 6 symbols"><br>
		</div>
		<div class="registerField">
			<label>Re-enter password</label><br>
			<input name="u_passCheck" type="password" placeholder="Password"><br>
		</div>
		<div class=registerButton">
			<input name="submit" type="submit" value="Submit"><br>
		</div>
	</form>
</div>