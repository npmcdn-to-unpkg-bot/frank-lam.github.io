<?php
	require_once "jssdk/jssdk.php";
	$jssdk = new JSSDK("wx83de3e83d4993779", "7003cbc80edcbe31e6730002b91e700d");
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8"/>
		<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>图书管理系统</title>
		<link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" rel="stylesheet"/>
		<style type="text/css">
			* {
				font-family: "微软雅黑";
			}
		</style>
		<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
//				$('#book_info').show();
			});
		</script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

	</head>
	<body>
		<div class="container" style="margin-top:15px;">
			<legend class="text-center" style="font-size:16px;">
				<br/>
				*图书信息录入
			</legend>
			<div class="form-group">
				<label for="">
					ISBN（例如：9787500649038）：
				</label>
				<span id="tips1">
				</span>

				<div class="row">
				  <div class="col-xs-8">
				  	<input class="form-control" maxlength="13" id="isbn" placeholder="请输入ISBN（10位或13位）" type="text" name="stu_num"/>
				  	<!--<input class="form-control" maxlength="13" id="isbn" placeholder="请输入ISBN（10位或13位）" type="text" name="stu_num" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')"/>-->

				  </div>
				  <div class="col-xs-4">
				  	<input class="form-control btn btn-primary" id="isbn_btn" value="barCode" type="button"/>
				  </div>
				</div>

				
			</div>
			<div class="form-group">
				<button id="submitisbn" type="submit" class="btn btn-primary" style="width: 100%;">
					查阅图书信息
				</button>
			</div>
			<table id="book_info" class="table table-condensed table-hover" style="display: none;">
				<caption class="text-center" id="bookInfo">
					图书信息
				</caption>
				<thead>
					<tr>
						<th style="width: 30%;">
							item
						</th>
						<th>
							information
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							标题
						</td>
						<td id="title">
						</td>
					</tr>
					<tr>
						<td>
							外文名
						</td>
						<td id="origin_title">
						</td>
					</tr>
					<tr>
						<td>
							封面
						</td>
						<td>
							<img id="image" style="width: 200px;"/>
						</td>
					</tr>
					<tr>
						<td>
							作者
						</td>
						<td id="author">
						</td>
					</tr>
					<tr>
						<td>
							作者简介
						</td>
						<td id="author_intro">
						</td>
					</tr>
					<tr>
						<td>
							概要
						</td>
						<td id="summary">
						</td>
					</tr>
					<tr>
						<td>
							目录
						</td>
						<td id="catalog">
						</td>
					</tr>
					<tr>
						<td>
							ISBN10
						</td>
						<td id="isbn10">
						</td>
					</tr>
					<tr>
						<td>
							ISBN13
						</td>
						<td id="isbn13">
						</td>
					</tr>
					<tr>
						<td>
							出版社
						</td>
						<td id="publisher">
						</td>
					</tr>
					<tr>
						<td>
							出版日期
						</td>
						<td id="pubdate">
						</td>
					</tr>
					<tr>
						<td>
							页码
						</td>
						<td id="pages">
						</td>
					</tr>
					<tr>
						<td>
							价格
						</td>
						<td id="price">
						</td>
					</tr>
					<tr>
						<td>
							豆瓣详情
						</td>
						<td>
							<a id="douban_url" target="_blank"></a>
						</td>
					</tr>
					<tr>
						<td>
							操作
						</td>
						<td>
							<input id="addtoLib" type="button" class="btn btn-primary" value="添加至我的书库" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<script>


		document.getElementById("submitisbn").onclick=function() {
			var request=new XMLHttpRequest();
			request.open("POST", "action.php");
			var data="isbn=" + document.getElementById("isbn").value;
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange=function() {
				if (request.readyState===4) {
					if (request.status===200) {
						layer.closeAll('loading');
						$('#book_info').fadeOut(50);

						var JsonData=JSON.parse(request.responseText);
						var isbnInput=document.getElementById('isbn').value;
						if(isbnInput==''){
							layer.alert('ISBN不能为空，请输入!', {
							icon:7,
							skin: 'layer-ext-moon'})
						}
						else{
							if(JsonData['code']==6000){
								$('#book_info').fadeOut(50);

								layer.alert('您输入的ISBN无效，请重新输入。', {
								icon:0,
								skin: 'layer-ext-moon'})
								
							}
							else{
								//加载层-默认风格
								layer.load();

								$('#book_info').fadeIn(1000);
								
								var title=JsonData['title'];
								var origin_title=JsonData['origin_title'];
								var image=JsonData['images']['large'];
								var author=JsonData['author'][0];
								var author_intro=JsonData['author_intro'];
								var summary=JsonData['summary'];
								var catalog=JsonData['catalog'];
								var isbn10=JsonData['isbn10'];
								var isbn13=JsonData['isbn13'];
								var publisher=JsonData['publisher'];
								var pubdate=JsonData['pubdate'];
								var pages=JsonData['pages'];
								var price=JsonData['price'];
								var douban_url=JsonData['alt'];
								if (origin_title=='') {
									origin_title="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无外文名</span>";
								}
								
								if (author_intro=='') {
									origin_title="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无作者简介</span>";
								}
		
								if (summary=='') {
									origin_title="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无概要</span>";
								}
								if (catalog=='') {
									origin_title="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无目录</span>";
								}
								document.getElementById("bookInfo").innerHTML=author+"《"+title+"》";
								document.getElementById("title").innerHTML=title;
								document.getElementById("origin_title").innerHTML=origin_title;
								document.getElementById("image").src=image;
								document.getElementById("author").innerHTML=author;
								document.getElementById("author_intro").innerHTML=author_intro;
								document.getElementById("summary").innerHTML=summary;
								document.getElementById("catalog").innerHTML=catalog;
								document.getElementById("isbn10").innerHTML=isbn10;
								document.getElementById("isbn13").innerHTML=isbn13;
								document.getElementById("isbn10").innerHTML=isbn10;
								document.getElementById("publisher").innerHTML=publisher;
								document.getElementById("pubdate").innerHTML=pubdate;
								document.getElementById("pages").innerHTML=pages;
								document.getElementById("price").innerHTML=price;
								document.getElementById("douban_url").href=douban_url;
								document.getElementById("douban_url").innerHTML="豆瓣《"+title+"》";
								
								
								//此处演示关闭
								setTimeout(function(){
								  layer.closeAll('loading');
								}, 800);
							}
							
						}
						
					}
					else 
					{
						alert("失败");
					}
				}
			}
		}
</script>


<script>
  /*
   * 注意：
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'scanQRCode'
    ]
  });
  wx.ready(function () {
  	
  	//微信扫一扫
	  document.querySelector('#isbn_btn').onclick = function () {
	    wx.scanQRCode({
	      needResult: 1,
	      desc: 'scanQRCode desc',
	      scanType: ["barCode"],
	      success: function (res) {
	        //alert(JSON.stringify(res));
	        var reData=JSON.stringify(res);
	        var isbnString=res['resultStr'].substring(7);
	        document.getElementById("isbn").value=isbnString;
	        document.getElementById("submitisbn").click();
	        
	      }
	    });
	  };

  	
    
  });
</script>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="layer/layer.js"></script>
		<!-- Bootstrap JavaScript -->
		<script crossorigin="anonymous" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="Hello World"></script>
	</body>
</html>