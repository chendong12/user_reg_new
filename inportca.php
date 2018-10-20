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
<!--							<li class="">
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
						<h3>Windows 7/8/10 导入VPN证书</h3>
					</header>
					<hr>
					<content>
						<p>1.（<a href="client.zip" target="_blank">点击下载</a>）证书压缩包（2018年2月12号更新），解压证书（client.cert.p12）存放于任意位置，然后点击运行命令&rdquo;mmc&rdquo;</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win1.jpg" alt="" /></p>
						<p>2.点击文件–添加或删除管理单元，在可用管理单元中选择&ldquo;证书&rdquo;，添加，再选择计算机帐户，点本地计算机完成，确定。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win2.jpg" alt="" /> <img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win3.jpg" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win4.jpg" alt="" /> <img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win5.jpg" alt="" /></p>
						<p>3.右键点击受信任的根证书颁发机构的证书–所有任务–导入，再点下一步，点击浏览选择在第一步中下载的证书文件，然后再点下一步，证书存储在&ldquo;受信任的根证书颁发机构&rdquo;，然后再点下一步完成。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win6.jpg" alt="" /> <img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win7.jpg" alt="" /></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win8.jpg" alt="" /></p>
						<p>注意，有人说在这里找不到刚才下载的证书文件，，在打开的框里，右下角处，&ldquo;打开（O）&rdquo;的上面选择&ldquo;所有文件（*.*）&rdquo;这样就可以找到了。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win9.jpg" alt="" /></p>
						<p>这里密码为空</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win10.jpg" alt="" /> <img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win11.jpg" alt="" /></p>
						<p>4.创建VPN连接，然后点击创建的VPN连接属性首先填写IKEv2的VPN服务器地址<b style="color:red"><?php echo $user_home->pubIP; ?></b>（点击网站顶部&ldquo;服务器地址&rdquo;挑选支持IKEv2的节点填写）。<a href="home.php">【若不会创建VPN连接，请点此查看，根据您的操作系统选择查看相应教程】</a></p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win12.jpg" alt="" /></p>
						<p>5.点击安全选项卡，VPN类型选择IKEv2，身份验证选择EAP-MSCHAP v2。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win13.jpg" alt="" /></p>
						<p>6.点击设置的VPN连接输入VPN用户名和密码（域不需要填写），然后就可以连接。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-includes/images/userimg/ipsec/win14.jpg" alt="" /></p>	
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
