<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/lost_and_found/config.php";

function con_db() {
	$mysqli = new mysqli(DB_INFO['HOST'], DB_INFO['USER'], DB_INFO['PASSWARD'], DB_INFO['NAME']);

	if ($mysqli -> connect_errno) {
		if (PRINT_DEBUG == true) {
			echo "MySQL연결에 실패했습니다: " . $mysqli -> connect_error;
			exit();
		}
		return -1;
	}

	$mysqli -> set_charset('utf8');

	return $mysqli;
}

function execute_query($sql) {
	$mysqli = con_db();

	$sql = $mysqli -> real_escape_string($sql);

	$result = $mysqli -> query($sql);

	if (!$result) {
		if (PRINT_DEBUG == true) {
			echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
			exit();
		}
		return -1;
	}

	$mysqli -> close();
	return $result;
}

function escape($val) {
	$mysqli = con_db();

	$val = $mysqli -> real_escape_string($val);

	$mysqli -> close();

	return $val;
}

function cut_last($str) {
	return substr($str, 0, -1);
}

function bwf_insert($table_name, $data) {

	$mysqli = con_db();
	
	$table_name = $mysqli -> real_escape_string($table_name);
	
	$sql = "INSERT INTO `{$table_name}` (";

	foreach($data as $key => $value) {
		$key = $mysqli -> real_escape_string($key);
		$sql .= "`{$key}`,";
	}

	$sql = cut_last($sql);

	$sql .= ")VALUES(";

	foreach($data as $key => $value) {
		if (gettype($value) == "integer") {
			$sql .= "{$value},";
		} else {
			$value = $mysqli -> real_escape_string($value);
			$sql .= "'{$value}',";
		}
	}

	$sql = cut_last($sql);

	$sql .= ");";
	
	$result = $mysqli -> query($sql);

	if (!$result) {
		if (PRINT_DEBUG == true) {
			echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
			exit();
		}
		return -1;
	}
	
	$mysqli -> close();
	
	return $result;
}

function bwf_select($table, $orderby = 0) {
	
	$mysqli = con_db();
	
	$table = $mysqli -> real_escape_string($table);
	
	
	$sql = "SELECT * FROM `{$table}`";
	
	if (gettype($orderby) == "array") {
		$sql .= " ORDER BY";
		
		foreach($orderby as $key => $value) {
			
			$key = $mysqli -> real_escape_string($key);
			$value[0] = $mysqli -> real_escape_string($value[0]);
			$value[1] = strtoupper($mysqli -> real_escape_string($value[1]));
			
			if ($value[1] != "DESC" and $value [1] != "ASC") {
				
				if (PRINT_DEBUG == TRUE) {
					echo "쿼리에 오류가 있습니다: {$key}번째 ORDER BY {$value[1]} - 올바르지 않은 값입니다.";
				}
				
				return -1;
				
			}
			
			$sql .= " {$value[0]} {$value[1]},";
			
		}
	}
	
	$sql = cut_last($sql);
	
	$sql .= ";";
	
	$result = $mysqli -> query($sql);

	if (!$result) {
		if (PRINT_DEBUG == true) {
			echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
			exit();
		}
		return -1;
	}
	
	$mysqli -> close();
	
	return $result;
}

function bwf_update($table, $data, $rules = 0) {
	
	$mysqli = con_db();
	
	$table = $mysqli -> real_escape_string($table);
	
	$sql = "UPDATE `{$table}` SET";
	
	foreach($data as $key => $value) {
		
		$key = $mysqli -> real_escape_string($key);
		
		if (gettype($value) == "integer") {
			$sql .= " `{$key}`={$value},";
		} else {
			$value = $mysqli -> real_escape_string($value);
			$sql .= " `{$key}`='{$value}',";
		}
		
	}
	
	$sql = cut_last($sql);
	
	if (gettype($rules) == "array") {
		$sql .= ' WHERE 1 = 1';
		
		foreach($rules as $key => $value) {
			$key = $mysqli -> real_escape_string($key);
			
			if (gettype($value) == "integer") {
				$sql .= " AND `{$key}`={$value}";
			} else {
				$value = $mysqli -> real_escape_string($value);
				$sql .= " AND `{$key}`='{$value}'";
			}
			
		}
	}
	
	$result = $mysqli -> query($sql);

	if (!$result) {
		if (PRINT_DEBUG == true) {
			echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
			exit();
		}
		return -1;
	}
	
	$mysqli -> close();
	
	return $result;
	
}

function bwf_delete($table, $rules) {
	
	$mysqli = con_db();
	
	$table = $mysqli -> real_escape_string($table);
	
	$sql = "DELETE FROM `{$table}` WHERE 1=1";
	
	foreach($rules as $key => $value) {
		$key = $mysqli -> real_escape_string($key);
		
		if (gettype($value) == 'integer') {
			$sql .= " AND {$key}={$value}";
		} else {
			$value = $mysqli -> real_escape_string($value);
			$sql .= " AND {$key}='{$value}'";
		}
		
	}
	
	$sql .= ";";
	
	$result = $mysqli -> query($sql);

	if (!$result) {
		if (PRINT_DEBUG == true) {
			echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
			exit();
		}
		return -1;
	}
	
	$mysqli -> close();
	
	return $result;
}

function bwf_redirect($url = 0) {
	
	$to = 0;

	if ($url !== 0) {
		$to = $url;
	} else if (isset($_SERVER["HTTP_REFERER"])) {
		$to = $_SERVER["HTTP_REFERER"];
	}

	if ($to !== 0) {
		if (PRINT_DEBUG == TRUE) {
			echo "<a href='{$to}'>Redierct to: {$to}</a>";
		} else {
			header('location:'.$to);
		}
		return TRUE;
	} else {
		return FALSE;
	}
}

function bwf_verify_login() {
	if(!isset($_COOKIE['verify_token']) && !isset($_COOKIE['Email'])) {
		return -1; // 로그인이 안돼어 있는 경우
	}
	if($_COOKIE['verify_token'] != hash('sha256', $_COOKIE['Email'])) {
		return FALSE; // 로그인이 되어있지만 정보가 변조된 경우
	}
	return TRUE; // 로그인이 되어있고 정보도 안전한 경우
}

class Bwf_Model {
	public $table;
	public $data;
	public $rules;
	public $orderby;
	public $result;
	public $url;
	
	private function create_where() {
		$mysqli = con_db();
		
		$sql = ' WHERE 1 = 1';

		foreach($this -> rules as $key => $value) {
			$key = $mysqli -> real_escape_string($key);

			if (gettype($value) == "integer") {
				$sql .= " AND `{$key}`={$value}";
			} else {
				$value = $mysqli -> real_escape_string($value);
				$sql .= " AND `{$key}`='{$value}'";
			}

		}
		
		$mysqli -> close();
		
		return $sql;
	}
	
	public function insert() {
		$CHECK_SETTING = TRUE;
		$CHECK_SETTING = ($this -> table != "") && $CHECK_SETTING;
		$CHECK_SETTING = (count($this -> data) != 0) && $CHECK_SETTING;
		if (!$CHECK_SETTING) {
			if (PRINT_DEBUG == TRUE) {
				echo "ERROR: SELECT문을 실행하기 위해 값들을 설정해주세요";
			}
			return -1;
		}
		
		$this -> result = bwf_insert($this -> table, $this -> data);
	}
	
	public function select() {
		
		$mysqli = con_db();
		
		$CHECK_SETTING = TRUE;
		$CHECK_SETTING = ($this -> table != "") && $CHECK_SETTING;
		if (!$CHECK_SETTING) {
			if (PRINT_DEBUG == TRUE) {
				echo "ERROR: SELECT문을 실행하기 위해 값들을 설정해주세요";
			}
			return -1;
		}
	
		$this -> table = $mysqli -> real_escape_string($this -> table);

		$sql = "SELECT * FROM `{$this -> table}`";

		if (count($this -> rules) > 0) {
			$sql .= $this -> create_where();
		}

		if (count($this -> orderby) > 0) {
			$sql .= " ORDER BY";

			foreach($this -> orderby as $key => $value) {

				$key = $mysqli -> real_escape_string($key);
				$value[0] = $mysqli -> real_escape_string($value[0]);
				$value[1] = strtoupper($mysqli -> real_escape_string($value[1]));

				if ($value[1] != "DESC" and $value [1] != "ASC") {

					if (PRINT_DEBUG == TRUE) {
						echo "쿼리에 오류가 있습니다: {$key}번째 ORDER BY {$value[1]} - 올바르지 않은 값입니다.";
					}

					return -1;

				}

				$sql .= " {$value[0]} {$value[1]},";

			}
		}

		$sql = cut_last($sql);

		$sql .= ";";

		$result = $mysqli -> query($sql);

		if (!$result) {
			if (PRINT_DEBUG == true) {
				echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
				exit();
			}
			return -1;
		}

		$mysqli -> close();

		$this -> result =  $result;
		
	}
	
	public function update() {
		
		$mysqli = con_db();
	
		$CHECK_SETTING = TRUE;
		$CHECK_SETTING = ($this -> table != "") && $CHECK_SETTING;
		$CHECK_SETTING = (count($this -> data) != 0) && $CHECK_SETTING;
		if (!$CHECK_SETTING) {
			if (PRINT_DEBUG == TRUE) {
				echo "ERROR: SELECT문을 실행하기 위해 값들을 설정해주세요";
			}
			return -1;
		}
		
		$this -> table = $mysqli -> real_escape_string($this -> table);

		$sql = "UPDATE `{$this -> table}` SET";

		foreach($this -> data as $key => $value) {

			$key = $mysqli -> real_escape_string($key);

			if (gettype($value) == "integer") {
				$sql .= " `{$key}`={$value},";
			} else {
				$value = $mysqli -> real_escape_string($value);
				$sql .= " `{$key}`='{$value}',";
			}

		}

		$sql = cut_last($sql);

		if (count($this -> rules) > 0) {
			$sql .= $this -> create_where();
		}

		$result = $mysqli -> query($sql);

		if (!$result) {
			if (PRINT_DEBUG == true) {
				echo "쿼리에 오류가 있습니다: " . $mysqli -> error;
				exit();
			}
			return -1;
		}

		$mysqli -> close();

		$this -> result = $result;
		
	}
	
	public function delete() {
		
		$CHECK_SETTING = TRUE;
		$CHECK_SETTING = ($this -> table != "") && $CHECK_SETTING;
		if (!$CHECK_SETTING) {
			if (PRINT_DEBUG == TRUE) {
				echo "ERROR: SELECT문을 실행하기 위해 값들을 설정해주세요";
			}
			return -1;
		}
		$this -> result = bwf_delete($this -> table, $this -> rules);
		
	}
	
	public function redirect($url_arg = 0) {
		
		$to = 0;
		
		if ($url_arg !== 0) {
			$to = $url_arg;
		} else if ($this -> url !== 0) {
			$to = $this -> url;
		} else if (isset($_SERVER["HTTP_REFERER"])) {
			$to = $_SERVER["HTTP_REFERER"];
		} else {
			$to = ROOT . "/index.php";
		}
		
		if ($to !== 0) {
			if (PRINT_DEBUG == TRUE) {
				echo "<a href='{$to}'>Redierct to: {$to}</a>";
			} else {
				header('location:'.$to);
			}
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	public function __construct() {
		$this -> data = array();
		$this -> url = 0;
		$this -> table = "";
		$this -> rules = array();
		$this -> orderby = array();
	}
}

?>