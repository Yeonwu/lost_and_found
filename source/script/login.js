function getCookie(name) {
	let matches = document.cookie.match(
		new RegExp('(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)')
	);
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

// 쿠키 저장, 삭제함수
function setCookie(name, value, options = {}) {
	options = {
		path: '/',
		// 필요한 경우, 옵션 기본값을 설정할 수도 있습니다.
		...options,
	};

	if (options.expires instanceof Date) {
		options.expires = options.expires.toUTCString();
	}

	let updatedCookie = encodeURIComponent(name) + '=' + encodeURIComponent(value);

	for (let optionKey in options) {
		updatedCookie += '; ' + optionKey;
		let optionValue = options[optionKey];
		if (optionValue !== true) {
			updatedCookie += '=' + optionValue;
		}
	}
	document.cookie = updatedCookie;
}

function deleteCookie(name) {
	setCookie(name, '', {
		'max-age': -1,
	});
}

// 로그인 했을때 작동
function onSignIn(googleUser) {
	var profile = googleUser.getBasicProfile();

	let id_token = googleUser.getAuthResponse().id_token;
	let xhr = new XMLHttpRequest();
	xhr.open('POST', './model/verify_login.php');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		let json = JSON.parse(xhr.response);
		if (json.success == true) {
			setCookie('verify_token', json.verify_token, 1);
			setCookie('ID', profile.getId(), 1);
			setCookie('Name', profile.getName(), 1);
			setCookie('Image_URL', profile.getImageUrl(), 1);
			setCookie('Email', profile.getEmail(), 1);
			
			signIn();
		} else {
			alert('다시 로그인 해주세요');
		}
	};
	xhr.send('idtoken=' + id_token);
}

// 로그아웃 했을때 작동
function _signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
		console.log('User signed out.');
		deleteCookie('ID');
		deleteCookie('Name');
		deleteCookie('Image_URL');
		deleteCookie('Email');
		deleteCookie('verify_token');
		
		signOut();
	});

	
}