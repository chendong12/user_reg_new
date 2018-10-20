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
		<!--					<li class="">
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
						<h3>Windows XP 配置VPN连接</h3>
					</header>
					<hr>
					<content>
						<p>1. <a href="http://www.beijinghuayu.com.cn/down/sslvpn-install-1.0.0-i686-XP.exe">点击这里</a>下载vpn连接客户端程序，并执行默认安装</p>
						<p>2. <a href="openvpnclient.zip">点击这里</a>下载VPN证书文件，并减压缩，拷贝减压后的，ca.crt、client.ovpn文件到C:\Program Files\SSLVPN\config\目录下，覆盖原来的文件</p>
						
						<!-- ><p>3. 下面方法介绍如何查找vpn客户端的安装配置目录</p>
						
						<p>第一步：找到桌面安装的sslvpn软件，右击点击属性，如下图<br /><image src="images/openvpn1.png"></image></p>
						
						<p>第二步：点击打开文件位置<br /><image src="images/openvpn2.png"></image></p>
						
						<p>第三步：找到config目录，如果是默认安装，目录为C:\Program Files\SSLVPN\config\ ，将上面复制的文件拷贝到这里，覆盖原来的文件<br /><image src="images/openvpn3.png"></image></p> -->
						
						<p>3. 双击桌面右下角图标,如图<br /><image src="images/openvpn4.png"></image></p>
						
						<p>4. 在出现的下面对话框中输入VPN用户名和密码（注册时填写的邮箱地址和密码）<br /><image src="images/openvpn5.png"></image></p>
						
						<p>5. 连接成功显示如下信息<br /><image src="images/openvpn6.png"></image></p>
									
					</content>
				</article>
			</div>
		</div>
		<aside class='top-sidebar sidebar'>
			<article>
				<h3>用户基本信息</h3>
				<hr>
				<p>在线时间：<?php echo $row['online_day']?> 天</p>
				<p>有效期至：<span style="color:red"><?php echo date("Y-m-d",strtotime($row['end_day']));?></span></p>
				<p>已用流量：<?php echo $row['used_traffic']?> G</p>
				<p>允许同时在线人数：<?php echo $row['group_sim']?> 人</p>
			</article>
		</aside>
<!--		<aside class='middle-sidebar sidebar'>
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
