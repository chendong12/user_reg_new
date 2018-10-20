<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM radcheck WHERE id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//获取用户组属性
$username=$row['username'];
$row = $user_home->userinfo($username)

?>

<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title><?php echo $username; ?></title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
    </head>
    
    <body class="body">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="home.php">会员首页</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> 
								<?php echo $username; ?> <i class="caret"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="logout.php">退出登录</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="home.php">教程说明</a>
                            </li>
			<!--				<li class="home.php">
                                <a href="">在线购买</a>
                            </li>
			-->
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <!--/.fluid-container-->
        <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/scripts.js"></script>
		<div class='mainContent'>
			<div class='content'>
				<article class='topcontent'>
					<header>
						<h3>Windows 7/8 配置VPN连接</h3>
					</header>
					<hr>
					<content>
						<p><strong>win7/8/10 首先点击<a href="inportca.php">这里导入VPN证书</a></strong>，如果已导入，请按照下面操作创建VPN连接。</p>
						<p>第一步：WINDOWS 10添加VPN连接。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-1.png" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-2.png" alt="" /></p>
						<p>第二步：按照图中的示例输入和选择各类参数，服务器名地址为：<b style="color:red"><?php echo $user_home->pubIP; ?></b></p>
						<p>帐户名(注册的email)和VPN登录密码。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-3.png" alt="" /></p>
						<p>第三步：连接之前还需要修改VPN连接的加密选项，点击&lsquo;更改适配器选项&rsquo; -&gt;右击属性-&gt;选择安全标签，出现下面的界面，设置与图中一样即可</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-4.png" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10//C19_PDP@IEE3BU0LZQ.png" alt="" width="655" height="491" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10//IK0R@GWV@ERQYAUR4FKD.jpg" alt="" width="446" height="511" /><br />
						  <img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/6IGC07797NOAS_VQ3S.png" alt="" width="447" height="550" /></p>
						<p>点击确定。</p>
						<p>第四步：点击连接，然后按照图中的示例操作即可。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-5.png" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-6.png" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-7.png" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/win10/win-ikev2-8.png" alt="" /></p>
					</content>
				</article>
			</div>
		</div>
		<aside class='top-sidebar sidebar'>
			<article>
				<h3>用户基本信息</h3>
				<hr>
				<p>在线时间：<?php echo $row['online_day']?> 天</p>
				<p>有效期至：<?php echo date("Y-m-d",strtotime($row['end_day']));?></p>
				<p>已用流量：<?php echo $row['used_traffic']?> G</p>
				<p>允许同时在线人数：<?php echo $row['group_sim']?> 人</p>
			</article>
		</aside>
	<!--	<aside class='middle-sidebar sidebar'>
			<article>
				<h3>VPN 价格说明</h3>
				<hr>
				<p>按月支付：每月30元，您需要一次性支付30元</p>
				<p>按季支付：每月25月，您需要一次性支付75元，每月节省5月</p>
				<p>按年支付：每月20元，您需要一次性支付240元，每月节省10元</li>
				<p><a href="#">淘宝购买链接</a></p>
			</article>
		</aside>
	-->
		<footer class='mainFooter'>
			<p>Fast VPN</p>
		</footer>

 
</body>

</html>
