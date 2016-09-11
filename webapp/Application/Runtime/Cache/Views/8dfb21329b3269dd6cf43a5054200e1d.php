<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>极客学院-ThinkPHP</title>
        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">极客学院-ThinkPHP</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">主页</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">主题 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('index',array('t'=>'default'));?>">默认主题</a></li>
                            <li><a href="<?php echo U('index',array('t'=>'jike'));?>">极客主题</a></li>
                        </ul>
                    </li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        <div class="container">
            
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>header</strong> 模板继承
                </div>
            
        </div>
        <div class="container">
            <div class="col-md-2 list-group">
                <a class="list-group-item" href="<?php echo U('index');?>">主页</a>
                <a class="list-group-item"  href="<?php echo U('friends');?>">好友</a>
            </div>
            <div class="col-md-10">
                
<!-- 好友列表 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">好友列表</h3>
                </div>
                <ul class="list-group media-list">
                    <!-- volist循环 -->
                    <?php if(is_array($friends)): $i = 0; $__LIST__ = $friends;if( count($__LIST__)==0 ) : echo "难道这就是强大到没朋友的节奏" ;else: foreach($__LIST__ as $key=>$friend): $mod = ($i % 2 );++$i;?><li class="list-group-item media">
                            <a class="pull-left" href="#">
                                <!-- empty判断头像是否为空 -->
                                <?php if(empty($friend['avatar'])): ?><!-- 为空则输出default.png -->
                                    <img width="120" height="120" class="media-object" src="/Uploads/avatar/default.png" alt="<?php echo ($friend['username']); ?>">
                                <?php else: ?>
                                    <!-- 不为空则输出用户的头像 -->
                                    <img width="120" height="120" class="media-object" src="/Uploads/avatar/<?php echo ($friend['avatar']); ?>" alt="<?php echo ($friend['username']); ?>"><?php endif; ?>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <?php echo ($friend['username']); ?>(今年<?php echo ($friend["age"]); ?>岁)

                                    
                                    <!--
                                        eq        :     ==
                                        neq      :     !=
                                        gt         :     >
                                        egt       :     >=
                                        lt          :     <
                                        elt        :     <=
                                        heq      :     ===
                                        nheq    :     !==
                                    -->

                                    <!-- eq，判断年龄是否是30岁 -->
                                    <?php if(($friend['age']) == "30"): ?><span class="label label-warning">您恰好30岁，真是猿粪啊！</span><?php endif; ?>

                                    <!-- if else -->
                                    <!-- 如果年龄小于18岁 -->
                                    <?php if($friend['age'] < 18): ?><span class="pull-right">因为未成年，所以不显示</span>
                                    <?php else: ?>
                                            <!-- 否则输出按钮 -->
                                            <a href="#" class="pull-right btn btn-warning">这项操作需要满18岁</a><?php endif; ?>
                                </h4>
                                <p>
                                    <!-- 比较标签 -->

                                    <!-- lt方式比较年龄 -->
                                    <?php if(($friend['age']) < "18"): ?>未成年<?php endif; ?>
                                    <!-- compare方式比较 -->
                                    <?php if(($friend['age']) < "18"): ?><span class="text-danger">注意，compare标签也表示：<?php echo ($friend['username']); ?>未成年！</span><?php endif; ?>
                                    <!-- egt方式比较年龄 -->
                                    <?php if(($friend['age']) >= "35"): ?>中年人<?php endif; ?>
                                    <!-- between方式判断年龄区间 -->
                                    <?php $_RANGE_VAR_=explode(',',"18,34");if($friend['age']>= $_RANGE_VAR_[0] && $friend['age']<= $_RANGE_VAR_[1]):?>青年<?php endif; ?>
                                </p>
                                <div>
                                    标签：
                                    <!-- Volist循环嵌套输出tags标签 -->
                                    <?php if(is_array($friend['tags'])): $i = 0; $__LIST__ = $friend['tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><span class="label label-success"><?php echo ($tag); ?></span><?php endforeach; endif; else: echo "难道这就是强大到没朋友的节奏" ;endif; ?>
                                </div>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>

            
            </div>
        </div>
                    <!-- jQuery -->
            <script src="//code.jquery.com/jquery.js"></script>
            <!-- Bootstrap JavaScript -->
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

            <!-- import -->
            <!-- <script type="text/javascript" src="/Public/Js/bootstrap.js"></script> -->

            <!-- load -->
            <!-- <script type="text/javascript" src="/Public/js/jquery.js"></script> -->

            <!-- css -->
            <!-- <link rel="stylesheet" type="text/css" href="/Public/css/bootstrap.css" /> -->

            <!-- js -->
            <!-- <script type="text/javascript" src="./Cdn/js/bootstrap.js"></script> -->
    </body>
</html>