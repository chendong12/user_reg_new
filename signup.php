<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
	$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM radcheck WHERE username=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>抱歉 !</strong>  email 地址已经存在，请尝试另一个email地址
			  </div>
			  ";
	}
	else
	{
		if($reg_user->register($uname,$email,$upass,$code))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
			$message = "					
						Hello $uname,
						<br /><br />
						欢迎您注册公司企业 VPN !<br/>
						为了完成注册，请按照下面提示进行激活账号<br/>
						<br /><br />
						<a href='http://$reg_user->pubIP:9091/verify.php?id=$id&code=$code'>点击这里激活账号 :)</a>
						<br /><br />
						谢谢!";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>用户创建成功!</strong>  我们给您这个 $email.
                    邮箱发送了一封邮件，请点击电子邮件中的确认链接来激活您的帐户. 
			  		</div>
					";
		}
		else
		{
			echo "抱歉 , 查询未能执行...";
		}		
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup | Coding Cage</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
				<?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">企业VPN-新用户注册</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email 地址" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="密码" name="txtpass" required />
        <input type="text" class="input-block-level" placeholder="姓名" name="txtuname" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">注册</button>
        <a href="index.php" style="float:right;" class="btn btn-large">登录</a>
      </form>

    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
