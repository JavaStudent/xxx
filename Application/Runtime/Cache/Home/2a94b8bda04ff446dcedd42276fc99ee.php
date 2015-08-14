<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>XXX-首页</title>

    <!-- Bootstrap -->
    <link href="/xxx/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-button
        {
          border: 0;
          background-color: #fff;
        }
        .delete
        {
          color: #d9534f;
        }
        .edit
        {
          color: #337ab7;
        }
        .glyphicon
        {
            top:0;/*调整原来的样式（top:1)*/
        }
        .input-group
        {
            
        }
        .input-group .addon-first
        {
            border-radius: 0;
            border-top-left-radius: 6px;
        }
        .input-group .addon, .input-group .input-middle
        {
            border-radius: 0;
        }
        .input-group .addon-last
        {
            border-radius: 0;
            border-bottom-left-radius: 6px;
        }
        .input-group .input-first
        {
            border-radius: 0;
            border-top-right-radius: 6px;
        }
        .input-group .input-last
        {
            border-radius: 0;
            border-bottom-right-radius: 6px;
        }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header" style="width:5%;">
            <a class="navbar-brand" href="#">XXX</a>
        </div>
        <div>
            <ul class="nav navbar-nav" style="width:95%;">
                <li class="active"><a href="<?php echo U('Home/Index/index');?>">首页</a></li>
                <li><a href="<?php echo U('Home/Index/register');?>">注册</a></li>
                <li><a href="<?php echo U('Home/Index/login');?>">登陆</a></li>
                <li class="dropdown" style="float:right; right: 5%;">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ($user_info['username']); ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">个人信息</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo U('Home/Index/logout');?>">注销</a></li>
                  </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="alert alert-dismissible" role="alert" style="width: 30%;margin-left: auto;margin-right: auto; display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong id="message"></strong>
    </div>
    <div style="margin:0 auto; float:none;" class="col-md-5">
        <table class="table table-hover">
            <thead>
              <tr><th>编号</th><th>用户名</th><th>邮箱</th><th>手机号码</th><th>操作</th></tr>
            </thead>
            <tbody>
              <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
                  <td><?php echo ($user["id"]); ?></td><td><?php echo ($user["username"]); ?></td><td><?php echo ($user["email"]); ?></td><td><?php echo ($user["phone"]); ?></td>
                  <td>
                    <button class="modal-button glyphicon glyphicon-pencil edit" data-toggle="modal" data-target="#myModal<?php echo ($user["id"]); ?>"></button>
                    <button class="modal-button glyphicon glyphicon-remove delete" onclick="javascript:firm(<?php echo ($user["id"]); ?>,<?php echo ($nowPage); ?>);"></button>
                  </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div style="width:100%;">
      <nav style="width:40%; margin:0 auto;">
        <?php echo ($show); ?>
      </nav>
    </div> <!--/分页 -->
    <!-- 模态框-->
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><div class="modal fade" id="myModal<?php echo ($user["id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="myModleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="bs-example bs-example-form" role="form" action="<?php echo U('uptUser');?>" method="POST">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel">更改信息</h4>
                      </div>
                      <div class="modal-body">
                          <!-- 表单 -->
                          <input type="hidden" id="id" name="id" value="<?php echo ($user["id"]); ?>"/>
                          <div class="input-group input-group-lg">
                              <span class="glyphicon glyphicon-envelope input-group-addon addon-first"></span>
                              <input type="text" class="form-control input-first" id="email" name="email" placeholder="请输入邮箱" value="<?php echo ($user["email"]); ?>" required>
                          </div>
                          <div class="input-group input-group-lg">
                              <span class="glyphicon glyphicon-phone input-group-addon addon-last"></span>
                              <input type="text" class="form-control input-last" id="phone" name="phone" placeholder="请输入手机号码" value="<?php echo ($user["phone"]); ?>" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                          <button type="submit" class="btn btn-primary">提交更改</button>
                      </div>
                    </form>
                </div>
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?><!--/模态框-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>-->
    <script src="/xxx/Public/Home/js/jquery-1.11.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/xxx/Public/Home/js/bootstrap.min.js"></script>
    <script>
        function firm(id,p) {
          if (confirm("你确定删除吗？")) {
            var url = 'delUser/id/'+id;
            window.location.href="<?php echo U('"+url+"');?>";
          }
        }
    </script>
  </body>
</html>