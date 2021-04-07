<?php
//서버 정보를 관리하는 파일 호출
require_once "config.php";
//사용자 함수 호출
require_once "./model/functions.php";
if(bwf_verify_login() == FALSE) {
	unset($_COOKIE['Email']);
    setcookie('Email', '', time() - 3600, '/');
	unset($_COOKIE['verify_token']);
    setcookie('verify_token', '', time() - 3600, '/');
	echo "
	<script>
		alert('로그인 오류가 발생했습니다. 로그아웃 후 다시 로그인해 주세요');
		window.location.href = './index.php?page=login';
	</script>";
}
?>

<!DOCTYPE html>
<html>
	<?php
		//상단 페이지(head 부분)
		require_once "./view/templates/head.php";
	?>

	<body>
		<?php
			//컨텐츠 페이지(body 안쪽 부분)
			if (isset($_GET['page'])) {
				require_once "./view/{$_GET['page']}.php";
			} else {
				require_once "./view/home.php";
			}
		?>
	</body>
</html>