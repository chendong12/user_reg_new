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
						<h3>Windows 7/8 配置VPN连接</h3>
					</header>
					<hr>
					<content>
						<p>win7/8/10 首先<a href="inportca.php">点击这里导入VPN证书</a>，如果已经导入，请按照下面操作创建VPN连接</p>
						<p>1. 依次点击 开始->控制面板->网络和共享中心->设置新的连接或网络</p>
						<p><image src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/jcimg/135432W9R.jpg"></image></p>
						<p>2. 选择“连接到工作区”，点击“下一步”；</p>
						<p><image src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/jcimg/135438chV.jpg"></image></p>
						<p>3. 如果已经存在其他连接，则在这一步选择“否，创建新连接”；如果没有，则这一步将被跳过；</p>
						<p><image src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/jcimg/135441yU0.jpg"></image></p>
						<p>4. 选择“使用我的Internet连接（VPN）”，点击“下一步”;</p>
						<p><image src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/jcimg/135444Ikb.jpg"></image></p>
						<p>5. 在“Internet地址”栏填写VPN服务器地址<b style="color:red"><?php echo $user_home->pubIP; ?></b>，请选择一条节点地址填入。“目标名称”随意填写，点击下一步;</p>
						<p><image src="images/vpndizhi.png"></image></p>
						<p>6. 填写你的用户名（注册时的邮箱地址）和密码，点击“连接”，</p>
						<p><image src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/jcimg/135450nlJ.jpg"></image></p>
						<p>7. 链接成功后在桌面右下角会有提示</p>
						<p><image src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/jcimg/135452p93.jpg"></image></p>
						
											
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
