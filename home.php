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
			<!--	<article class='topcontent'>
					<header>
						<h3><a href="#">VPN 特点</a></h3>
					</header>
					<hr>
					<content>
						<ul class="list">
							<li>速度快：服务器在香港，延时小于60ms</li>
							<li>使用方便：无需安装任何客户端</li>
							<li>多系统支持：支持windows、OSX、iphone、安卓等</li>
							<li>不限流量：不限制流量，有效期内可以随意使用</li>
							<li>免费3天试用：注册即赠送3天试用</li>
						</ul>
					</content>
			
				</article>
			-->
				<article class='bottomcontent'>
					<header>
						<h3>Windows 连接VPN说明</h3>
					</header>
					<hr>
					<content>
						<p>第一步：<a href="inportca.php">［导入证书］win7/8/10 首先点击这里导入VPN证书</a></p>
						<p>第二步：［创建VPN连接］根据您的操作系统类型，点击下面的链接，按照提示进行操作</p>
						<ul class="list">
							<li><a href="win7.php">Windows 7/8配置VPN连接(IKEV2)</a></li>
							<li><a href="win10.php">Windows 10配置VPN连接(IKEV2)</a></li>
							<li><a href="winxp.php">Windows XP配置VPN连接</a></li>
						</ul>
					</content>
				</article>
				<article class='bottomcontent'>
					<header>
						<h3>其它操作系统连接VPN说明</h3>
					</header>
					<hr>
					<content>
						<ul class="list">
							<li><a href="osx.php">OS X（苹果笔记本一体机）配置VPN</a></li>
							<li><a href="iphone.php">iPhone/iPad设置VPN连接</a></li>
						</ul>
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
