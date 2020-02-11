window.onload = pageController;

function pageController() {

	let token = document.getElementById('token');
	let submitBottomName = document.getElementById("submitBottomName");
	let submitBottomPass = document.getElementById("submitBottomPass");
	let changeNotificationStatus = document.getElementById("changeNotificationStatus");
	let status = 0;
	
	initNotification();
	
	submitBottomName.addEventListener("click", changeName);
	submitBottomPass.addEventListener("click", changePass);
	changeNotificationStatus.addEventListener("click", changeNotification);
	
	
	
	function changePass() {
		let oldPass = document.getElementById("oldPass").value;
		let newPass = document.getElementById("newPass").value;
		let newPassConfirm = document.getElementById("newPassConfirm").value;
		
		if (newPass !== newPassConfirm){
			alert(newPass + " != " +newPassConfirm);
			return 0;
		}
		
		let data = new FormData();
		data.append('changePass', 1);
		data.append('oldPass', oldPass);
		data.append('newPass', newPass);
		data.append('newPassConfirm', newPassConfirm);
		data.append('token', token.value);
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'JS/request');
		xhr.onload = function () {
			let json = JSON.parse(this.response);
			token.value = json.token;
			if (json.error)
				alert(json.error);
			else
				location.reload();
		};
		xhr.send(data);
	}
	
	
	function changeName() {
		let oldName = document.getElementById("oldName").value;
		let newName = document.getElementById("newName").value;
		
		let data = new FormData();
		data.append('changeName', 1);
		data.append('oldName', oldName);
		data.append('newName', newName);
		data.append('token', token.value);
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'JS/request');
		xhr.onload = function () {
			let json = JSON.parse(this.response);
			token.value = json.token;
			if (json.error)
				alert(json.error);
			else
				location.reload();
		};
		xhr.send(data);
	}
	
	function initNotification() {
		let notificationBody = document.getElementById('notificationStatus');
		let data = new FormData();
		data.append('getNotificationStatus', 1);
		data.append('token', token.value);
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'JS/request');
		xhr.onload = function () {
			let json = JSON.parse(this.response);
			token.value = json.token;
			status = json.status;
			notificationBody.innerHTML = status === 1 ? 'Notification on' : 'Notification off';
		};
		xhr.send(data);
	}
	
	function changeNotification() {
		let data = new FormData();
		data.append('switchNotification', 1);
		data.append('token', token.value);
		data.append('to', status === 1 ? 0 : 1);
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'JS/request');
		xhr.onload = function () {
			let json = JSON.parse(this.response);
			token.value = json.token;
			location.reload();
		};
		xhr.send(data);
	}
}