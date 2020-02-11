
<a href="/profile/createPhoto" title="My profile" class="headerText">addPhoto</a>
<br>

<div class="settings">
	<div class="changeNameBody">
		<input class="settingsInput" id="oldName" type="text" maxlength="20" placeholder="Old Name">
		<input class="settingsInput" id="newName" type="text" maxlength="20" placeholder="New Name">
		<button type="submit" class="settingBottom" id="submitBottomName">Change Name</button>
	</div>
	<div class="changePasswordBody">
		<input class="settingsInput" id="oldPass" type="password" maxlength="20" placeholder="Old Pssword">
		<input class="settingsInput" id="newPass" type="password" maxlength="20" placeholder="New Password">
		<input class="settingsInput" id="newPassConfirm" type="password" maxlength="20" placeholder="Confirm New Password">
		<button type="submit" class="settingBottom" id="submitBottomPass">Change Password</button>
	</div>
	<div class="changeEmailReceiveBody">
		<div class="notificationStatus" id="notificationStatus"></div>
		<button type="submit" class="settingBottom" id="changeNotificationStatus">Change Email Notification</button>
	</div>
</div>

<script src="js/settings.js"></script>
