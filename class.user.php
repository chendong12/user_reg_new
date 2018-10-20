<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;

    	public $pubIP = '公网IP地址';
	
	//获取共享密钥函数，需要把/usr/local/etc/ipsec.secrets权限设置为o+r
	public function ipsec_config_set()
	{
		if (file_exists("/usr/local/etc/ipsec.secrets"))
		{
		exec("cat /usr/local/etc/ipsec.secrets | grep ': PSK' | cut -f3 -d' '", $strongswanPSK, $key_return);
			if (!$key_return)
			{
				$strongswanPSK = trim($strongswanPSK[0]);
			}
		}
		return $strongswanPSK;
	}
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	public function userinfo($email)
    	{
		try
		{
			//获取用户在线天数
			$stmt = $this->conn->query("SELECT IF(COUNT(radacctid>=1),(UNIX_TIMESTAMP() - IFNULL(UNIX_TIMESTAMP(AcctStartTime),0)),0) DIV 86400 as online_days FROM radacct WHERE username = '$email' AND AcctSessionTime >= 1 ORDER BY AcctStartTime LIMIT 1");
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$userGroupValue['online_day'] = $row[online_days];
			//获取用户组的到期时间
			$stmt = $this->conn->query("SELECT * FROM radgroupcheck WHERE groupname ='$email' AND attribute = 'Expiration'");
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$userGroupValue['end_day'] = $row[value];
			//获取用户使用流量
			$stmt = $this->conn->query("SELECT SUM(acctinputoctets + acctoutputoctets) as traffic FROM radacct WHERE username = '$email'");
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$userGroupValue['used_traffic'] = round($row[traffic]/1024/1024/1024,2);
			//获取用户组同时在线人数
			$stmt = $this->conn->query("SELECT * FROM radgroupcheck WHERE groupname ='$email' AND attribute = 'Simultaneous-Use'");
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$userGroupValue['group_sim'] = $row[value];
			return $userGroupValue;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
    	}	
	
	public function register($uname,$email,$upass,$code)
	{
		try
		{							
			$password = $upass;
			date_default_timezone_set('Asia/Shanghai');
			$time_now = date('Y-m-d H:i:s');
			$date_now = date('d M Y');
			//确定注册用户试用天数，如果为0，则不提供试用,Simultaneous-Use 设置同时在线用户数
			$date_try = date('d M Y',strtotime($date_now. '+ 3000 days'));
			$stmt = $this->conn->prepare("INSERT INTO radcheck(username,attribute,op,nickname,value,tokenCode) 
			                                             VALUES(:user_mail, 'Cleartext-Password',':=',:user_name, :user_pass, :active_code)");
			$stmtInfo = $this->conn->prepare("INSERT INTO userinfo (username,email,creationdate, creationby,updatedate,updateby)
			       			                     VALUES('$email','$email','$time_now','user_reg','$time_now','user_reg')");
			$stmtBill = $this->conn->prepare("INSERT INTO userbillinfo (username,creationdate, creationby,updatedate,updateby)
							                   VALUES ('$email','$time_now','user_reg','$time_now','user_reg')");
			#$stmtDis = $this->conn->prepare("INSERT INTO radusergroup (UserName,GroupName,priority) VALUES ('$email', 'daloRADIUS-Disabled-Users', 0)");
			$stmtGroup = $this->conn->prepare("INSERT INTO radusergroup(UserName,GroupName,priority)
									   VALUES ('$email','$email', 0)");
			$stmtGroupExp = $this->conn->prepare("INSERT INTO radgroupcheck (GroupName,Attribute,op,Value)
                                                                            VALUES ('$email','Expiration',':=','$date_try')");
			$stmtGroupSim = $this->conn->prepare("INSERT INTO radgroupcheck (GroupName,Attribute,op,Value) 
									    VALUES ('$email','Simultaneous-Use',':=', '100')");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmtInfo->execute();
			$stmtBill->execute();
			#$stmtDis->execute();
			$stmtGroup->execute();
			$stmtGroupExp->execute();
			$stmtGroupSim->execute();
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM radcheck WHERE username=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['value']==$upass)
					{
						$_SESSION['userSession'] = $userRow['id'];
						return true;
					}
					else
					{
						header("Location: index.php?error");
						exit;
					}
				}
				else
				{
					header("Location: index.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: index.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "smtp.139.com";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username="13910723894@139.com";  
		$mail->Password="邮箱密码";            
		$mail->SetFrom('13910723894@139.com','华御VPN系统');
		$mail->AddReplyTo("13910723894@139.com","华御VPN系统");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
}
