<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
//在class.user.php中定义了获取共享密钥
$ipsecpsk = $user_home->ipsec_config_set();
//echo $ipsecpsk;

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
						<h3>苹果操作系统（OS X）配置IPsecVPN连接</h3>
					</header>
					<hr>
					<content>
						<p>1、进入系统偏好设置－网络</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_02.jpg" alt="mac_ipsec_02" width="650" height="598" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_02-200x184.jpg 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_02-300x276.jpg 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_02-400x368.jpg 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_02-600x552.jpg 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_02.jpg 650w" sizes="(max-width: 650px) 100vw, 650px" /></p>
						<p>2、创建一个新服务（点列表下方的+），之后点击&ldquo;创建&rdquo;</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_03.jpg" alt="mac_ipsec_03" width="650" height="564" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_03-200x174.jpg 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_03-300x260.jpg 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_03-400x347.jpg 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_03-600x521.jpg 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_03.jpg 650w" sizes="(max-width: 650px) 100vw, 650px" /></p>
						<p>接口：VPN<br />
						  VPN类型：Cisco IPsec<br />
						  服务名称：任意填写</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_04.jpg" alt="mac_ipsec_04" width="650" height="564" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_04-200x174.jpg 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_04-300x260.jpg 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_04-400x347.jpg 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_04-600x521.jpg 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_04.jpg 650w" sizes="(max-width: 650px) 100vw, 650px" /></p>
						<p> </p>
						<p>3、设置服务器地址:<b style="color:red"><?php echo $user_home->pubIP; ?></b>账户名称(注册的email)、密码</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_05.png" alt="mac_ipsec_05" width="668" height="563" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_05-200x169.png 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_05-300x253.png 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_05-400x337.png 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_05-600x506.png 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_05.png 668w" sizes="(max-width: 668px) 100vw, 668px" /></p>
						<p>4、点击&ldquo;鉴定设置&rdquo;，填写&ldquo;共享的密钥为<b style="color:red"><?php echo $ipsecpsk;?></b>之后点击&ldquo;好&rdquo;，再点&ldquo;应用&rdquo;。</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_06.png" alt="mac_ipsec_06" width="672" height="567" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_06-200x169.png 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_06-300x253.png 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_06-400x338.png 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_06-600x506.png 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_06.png 672w" sizes="(max-width: 672px) 100vw, 672px" /></p>
						<p>5、应用之后，点击连接</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_07.png" alt="mac_ipsec_07" width="668" height="563" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_07-200x169.png 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_07-300x253.png 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_07-400x337.png 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_07-600x506.png 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_07.png 668w" sizes="(max-width: 668px) 100vw, 668px" /></p>
						<p>连接后状态如下图所示</p>
						<p><img src="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_08.png" alt="mac_ipsec_08" width="668" height="563" srcset="http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_08-200x169.png 200w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_08-300x253.png 300w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_08-400x337.png 400w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_08-600x506.png 600w, http://www.beijinghuayu.com.cn/wp-content/uploads/2017/07/mac_ipsec_08.png 668w" sizes="(max-width: 668px) 100vw, 668px" /></p>
						
											
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
