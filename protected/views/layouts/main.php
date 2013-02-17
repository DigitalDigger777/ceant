<?php
    Yii::import('application.vendors.*');
    require_once 'facebook/facebook.php';
    
    $fb = new Facebook(array(
        'appId'=>  Yii::app()->params['appId'],
        'secret'=>  Yii::app()->params['secret'],
    ));
    
    $user_fb = $fb->getUser();
    if($user_fb)
        $profile = $fb->api('/me');
    $base = Yii::app()->request->getBaseUrl();
    $host = Yii::app()->request->getHostInfo();
    //echo $host.$base;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<link rel="stylesheet" href="<?php echo $this->assetsBase?>/css/smoothness/jquery-ui-1.9.2.custom.css" />-->
        <link rel="stylesheet" href="<?php echo $this->assetsBase?>/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $this->assetsBase?>/bootstrap/css/bootstrap-responsive.css" />
        <link rel="stylesheet" href="<?php echo $this->assetsBase?>/lightbox/css/jquery.lightbox-0.5.css" />
        <script type="text/javascript" src="<?php echo $this->assetsBase?>/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="<?php echo $this->assetsBase?>/bootstrap/js/bootstrap.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo $this->assetsBase?>/js/jquery-ui-1.9.2.custom.min.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->assetsBase?>/lightbox/js/jquery.lightbox-0.5.js"></script>
        <script type="text/javascript" src="<?php echo $this->assetsBase?>/js/hot.js"></script>
        <script type="text/javascript" src="<?php echo $this->assetsBase?>/js/app.js"></script>
        <script type="text/javascript">
        (function($){
            $('document').ready(function(){
                //$('#navbar').affix();
                $('.thumb').lightBox();
            });
        })(jQuery)
        </script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style="padding-top: 55px">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="index.php">Ceant</a>
                <ul class="nav">
                    <li<?php echo !isset($_REQUEST['r'])||$_REQUEST['r']=='product/index'?' class="active"':'';?>><a href="index.php">Главная</a></li>
                    <li<?php echo isset($_REQUEST['r'])&&($_REQUEST['r']=='product/items'||$_REQUEST['r']=='product/item')?' class="active"':'';?>><a href="index.php?r=product/items&category_id=2">Каталог</a></li>
                    <!--<li<?php echo isset($_REQUEST['r'])&&$_REQUEST['r']=='product/auction'?' class="active"':'';?>><a href="index.php?r=product/auction&category_id=2">Куплю</a></li>-->
                    <!--<li<?php echo isset($_REQUEST['r'])&&$_REQUEST['r']=='product/selling'?' class="active"':'';?>><a href="index.php?r=product/selling&category_id=2">Продам</a></li>-->
                    <!--<li<?php echo isset($_REQUEST['view'])&&$_REQUEST['view']=='buyer'?' class="active"':'';?>><a href="index.php?r=site/page&view=buyer">Для покупателей</a></li>-->
                    <!--<li<?php echo isset($_REQUEST['view'])&&$_REQUEST['view']=='seller'?' class="active"':'';?>><a href="index.php?r=site/page&view=seller">Для продавцов</a></li>-->
                </ul>
                <form class="navbar-search pull-left">
                  <!--<input type="text" class="search-query" placeholder="Поиск" />-->
                </form>
                <ul class="nav pull-right">
                    <li>
                        <?php if(!$user_fb):?>
                            <div class="btn-group">
                                <a class="btn btn-mini btn-primary" href="#">
                                    <i class="icon-lock icon-white"></i>&nbsp;
                                    Вход
                                </a>
                                <a class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $fb->getLoginUrl(array('redirect_uri'=>$host.$base.'/index.php?r=site/login')); ?>">Facebook</a></li>
                                    <!--<li><a href="#">Вконтакте</a></li>-->
                                </ul>
                            </div>
                        <?php else:?>
                            <div class="btn-group">
                                <a class="btn btn-mini btn-primary" href="#">
                                    <i class="icon-user icon-white"></i>&nbsp;
                                    <?php echo $profile['name']; ?>
                                </a>
                                <a class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Мои аукционы</a></li>
                                    <li><a href="#">Избранное</a></li>
                                    <li><a href="index.php?r=site/logout">Выход</a></li>
                                </ul>
                            </div>      
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="padding-left: 6%">
        <div class="row-fluid">
            <?php echo $content; ?>
        </div>        
    </div>
</body>
</html>