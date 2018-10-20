<?php
session_start();
require_once 'class.user.php';
$user = new USER();
if($user->is_logged_in()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-submit']))
{
	$email = $_POST['txtemail'];
	
	$stmt = $user->runQuery("SELECT id FROM radcheck WHERE username=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['id']);
		$code = md5(uniqid(rand()));
		
		$stmt = $user->runQuery("UPDATE radcheck SET tokenCode=:token WHERE username=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "
				   你好 , $email
				   <br /><br />
				   密码重置操作：如果您想重置您的密码，请按照下面方式操作，如果您不想重置密码，请忽略此电子邮件,
				   <br /><br />
				   点击下面的链接重置密码
				   <br /><br />
				   <a href='http://$user->pubIP:9091/resetpass.php?id=$id&code=$code'>点击这里重置密码</a>
				   <br /><br />
				   谢谢 :)
				   ";
		$subject = "Password Reset";
    
		$user->send_mail($email,$message,$subject);
		
		$msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					我们发送了一封邮件到您的邮箱： $email.
                    请打开您的邮件，按照提示重置密码. 
			  	</div>";
	}
	else
	{
		$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>抱歉!</strong>  this email not found. 
			    </div>";
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Forgot Password</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="login">
    <div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">忘记密码</h2><hr />
        
        	<?php
			if(isset($msg))
			{
				echo $msg;
			}
			else
			{
				?>
              	<div class='alert alert-info'>
				请输入您注册时的email。 您将收到一个一封重置密码的邮件，根据邮件提示重置密码.!
				</div>  
                <?php
			}
			?>
        
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
     	<hr />
        <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">生成新密码</button>
      </form>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
