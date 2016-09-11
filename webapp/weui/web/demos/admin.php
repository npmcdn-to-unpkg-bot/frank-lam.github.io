<?php
require_once "jssdk/jssdk.php";
$jssdk = new JSSDK("wx83de3e83d4993779", "7003cbc80edcbe31e6730002b91e700d");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>

<head>
	<title>管理员图书录入</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.">

	<link rel="stylesheet" href="../lib/weui.min.css">
	<link rel="stylesheet" href="../css/jquery-weui.css">
	<link rel="stylesheet" href="css/demos.css">
	<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
//				$('#book_info').show();
});
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

</head>

<body ontouchstart>


	<header class='demos-header'>
		<h4 class="demos-title" style="font-size: 25px;">管理员图书录入</h4>
	</header>
	<div class="weui_cells weui_cells_form">
		<div class="weui_cell">
		
			<div class="weui_cell_hd"><label class="weui_label">ISBN</label></div>
			<div class="weui_cell_bd weui_cell_primary">
				<input id="isbn" class="weui_input" type="tel" placeholder="请输入ISBN" maxlength="13" value="">
			</div>

			<a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default" id="isbn_btn">条形码</a>
		</div>
<!-- 		<a href="javascript:;" class="weui_btn weui_btn_default" id="submitisbn2" id="submitisbn">图书信息读取</a>
 -->
		<button id="submitisbn" type="submit" class="weui_btn weui_btn_default" style="width: 100%;" class="weui_btn weui_btn_default">
			查阅图书信息
		</button>
	</div>


	<div id="book_info" style="display: none;">
		<div class="weui_cells">
			<div class="weui_media_box weui_media_text">
				<h4 class="weui_media_title">书名</h4>
				<p class="weui_media_desc" id="title">
					高效能人士的七个习惯（精华版）
				</p>
			</div>
			<div class="weui_media_box weui_media_text">
				<h4 class="weui_media_title">外文名</h4>
				<p class="weui_media_desc" id="origin_title">
					The Seven Habits of Highly Effective People
				</p>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>封面</p>
				</div>
				<div class="weui_cell_ft">
					<img id="image" style="width: 120px;" src="https://img3.doubanio.com/lpic/s6817120.jpg">
				</div>
			</div>
			
			<div class="weui_media_box weui_media_text">
				<h4 class="weui_media_title">作者</h4>
				<p class="weui_media_desc" id="author">
					[美] 史蒂芬·柯维
				</p>
			</div>

			<div class="weui_media_box weui_media_text">
				<h4 class="weui_media_title">作者简介</h4>
				<p class="weui_media_desc" id="author_intro">史蒂芬·柯维（Stephen R. Covey），哈佛大学企业管理硕士，杨百翰大学博士。他是柯维领导中心的创始人，也是富兰克林柯维公司（Franklin Covey）的联合主席，曾协助众多企业、教育单位与政府机关培训领导人才。柯维在领导理论，家庭与人际关系，个人管理等领域久负盛名。</p>
				
			</div>
			<div class="weui_media_box weui_media_text">
				<h4 class="weui_media_title">概要</h4>
				<p class="weui_media_desc" id="summary">
					史蒂芬・柯维（Stephen R.Covey）哈佛大学企业管理硕士，杨百翰大学博士。他是柯维领导中心的创始人，也是富兰克林柯维公司（Franklin Covey）的联合主席，曾协助众多企业、教育单位与政府机关培训领导人才。柯维博士曾被《时代》杂志誉为“人类潜能的导师”，并入选为全美二十五位最有影响力的人物之一。在领导理论，家庭与人际关系，个人管理等领域久负盛名。本书自出书以来，高居美国畅销书排行榜长达七年，在全球七十个国家以二十八种语言发行共超过一亿册。　　富兰克林柯维公司是为组织和个人提供培训和管理咨询的世界顶尖级公司，与财富（Fortune）500强中80%以上的公司和成千上万个中小型企业以及政府职能部门都有建设性的合作关系。　　富兰克林柯维公司的服务与产品遍布全球，在全球38个国家设有44个分支机构。 关于本书　　企业领导人都知道：只有每一位员工成为高效能人士，企业才会真正成高效率企业。　　这本书几乎覆盖所有美国成年人，它是美国成年人中最具影响力的书。　　一个强大的美国是由每一位高效能的美国人决定的，不能不说与这本书有重要的关系。 FrankinCovey富兰克林柯维公司简介　　　当您阅读完《高效能人士的七个习惯》（The 7 Habits of Highly Effective People）这本书后，是否希望获得更多的学习资讯，与更多的职业经理人探讨成功的心得？富兰克林柯维公司的培训《高效能人士的七个习惯》使您更加深入地了解书中的理论，彻底地改变思维模式，从而为您走得成功之路奠定坚实的基础。　　富兰克林柯维公司擅长于通过使用先进的培训方法和系统、完善的内容帮助个人和组织提高效能，其最著名的课程《高效能人士的七个习惯》就源于史蒂芬・柯维（Stephen R.Covey）的同名著作。它所传授的内容不是某种流行时尚或管理技巧，而是经过时间的考验并且能够指导行为的基本原则。通过彻底思维的改变达到行为的改变从而加强了组织内部的管理机制、培养组织内部的共同语言和价值观；在全球每年有七十五万人次参加富兰克林柯维公司的培训，而该公司也因其优异表现连续五年入选中国三大培训公司，并在2000年被《China Staff》（中国人事杂志）评为中国最杰出的培训公司。
				</p>
			</div>
			<div class="weui_media_box weui_media_text">
				<h4 class="weui_media_title">目录</h4>
				<p class="weui_media_desc" id="catalog">
					前言 如何善用本书 第一部分 重新探索自我 第一章 由内而外全面造就自己 第二章 七个习惯——概论 第二部分 个人的成功：从依赖到独立 第三章 习惯一：积极主动——个人愿景的原则 第四章 习惯二：以终为始——自我领导的原则 第五章 习惯三：要事第一——自我管理的原则 第三部分 公众的成功：从独立到互赖 第六章 你不是一座孤岛 第七章 习惯四：双赢思维——人际领导的原则 第八章 习惯五：知彼知己——同理心交流的原则 第九章 习惯六：统合综效——创造性合作的原则 第四部分 全面观照生命 第十章 习惯七：不断更新——平衡的自我更新的原则 第十一章 再次由内而外造就自己 附录 一、你是哪种类型的人？——生活重心面面观 二、第四代时间管理——高效能人士的一天
				</p>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>ISBN10</p>
				</div>
				<div class="weui_cell_ft" id="isbn10">7500649037</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>ISBN13</p>
				</div>
				<div class="weui_cell_ft" id="isbn13">9787500649038</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>出版社</p>
				</div>
				<div class="weui_cell_ft" id="publisher">中国青年出版社</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>出版日期</p>
				</div>
				<div class="weui_cell_ft" id="pubdate">2011-6</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>页码</p>
				</div>
				<div class="weui_cell_ft" id="pages">286</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>价格</p>
				</div>
				<div class="weui_cell_ft" id="price">29.00元</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<p>豆瓣</p>
				</div>
				<div class="weui_cell_ft">
					<a href="#" id="douban_url">详情>>请移步至豆瓣读书</a>
				</div>
			</div>

			<div class="weui_cell weui_cell_warn">
			  <div class="weui_cell_hd"><label class="weui_label">数量</label></div>
			  <div class="weui_cell_bd weui_cell_primary">
			    <input id='book_number' class="weui_input" type="text" placeholder="默认：1" value="1" style="text-align:right;"  onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')">
			  </div>
			</div>


<!-- 			<div class="weui_media_box weui_media_text">
							<h4 class="weui_media_title">入库说明</h4>
			<div class="weui_cells_title ">入库说明</div>
				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" placeholder="这里可以写说明哦(☆_☆)/~~" rows="3"></textarea>
				</div>
			</div> -->
			
<!-- 			<div class="weui_cell">

				<div class="weui_cell_bd weui_cell_primary">
					<textarea class="weui_textarea" placeholder="这里可以写说明哦(☆_☆)/~~" rows="3"></textarea>
				</div>
			</div> -->

		    	<div class="weui_cells_title">入库说明</div>
		    <!-- <h4 class="weui_media_title">作者简介</h4> -->
		      <div class="weui_cell">
		        <div class="weui_cell_bd weui_cell_primary">
		          <textarea id="add_intro" class="weui_textarea" placeholder="这里可以写说明哦(☆_☆)/~~" rows="3"></textarea>
		        </div>
		      </div>
		      <div class="weui_cells weui_cells_form">
		      	<div class="weui_cells_tips">嘿！又新增一本书啦。</div>
		      	<div class="weui_btn_area">
		      		<a class="weui_btn weui_btn_primary" href="javascript:" id="showTooltips">添加至书库</a>
		      	</div>
		      </div>
		    
		</div>

		


	



</div>
	

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../lib/jquery-2.1.4.js"></script>
<script src="../js/jquery-weui.js"></script>

<script>
//	$("#showTooltips").click(function() {
//
//		$.toptip('查询成功', 'success');
//		// var tel = $('#tel').val();
//		// var code = $('#code').val();
//		// if(!tel || !/1[3|4|5|7|8]\d{9}/.test(tel))
//		//  $.toptip('请输入手机号');
//		// else if(!code || !/\d{6}/.test(code)) $.toptip('请输入六位手机验证码');
//		// else $.toptip('提交成功', 'success');
//
//
//	});
	
	$(document).on("click", "#showTooltips", function() {

		var book_name=$("#title").text();
        $.confirm("是否要添加《"+book_name+"》至书库?", "确认添加", function() {
          // $.toast("添加成功!",function(){
          // 	window.location="http://www.baidu.com";
          // });
          addToLibrary();
          // window.location="add_success.html";

        }, function() {
          //取消操作
        });
    });
</script>

<script>
	// $(document).ready(function(){
	// 	$(#book_info).hidden();
	// });

	document.getElementById("submitisbn").onclick=function() {

		// $("#book_info").fadeIn(500);

		var request=new XMLHttpRequest();
		request.open("POST", "action.php");
		var data="isbn=" + document.getElementById("isbn").value;
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(data);
		request.onreadystatechange=function() {
			if (request.readyState===4) {
				if (request.status===200) {
					// layer.closeAll('loading');
					$('#book_info').fadeOut(50);

					var JsonData=JSON.parse(request.responseText);
					var isbnInput=document.getElementById('isbn').value;
					if(isbnInput==''){
						// layer.alert('ISBN不能为空，请输入!', {
						// 	icon:7,
						// 	skin: 'layer-ext-moon'})
						$.toptip('ISBN不能为空，请输入!');
					}
					else{
						if(JsonData['code']==6000){
							$('#book_info').fadeOut(50);

							// layer.alert('您输入的ISBN无效，请重新输入。', {
							// 	icon:0,
							// 	skin: 'layer-ext-moon'})
							$("#isbn").val("");
							$.toptip('您输入的ISBN无效，请重新输入。');

						}
						else{
							$.toptip('查询成功', 'success');
										
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
											author_intro="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无作者简介</span>";
										}

										if (summary=='') {
											summary="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无概要</span>";
										}
										if (catalog=='') {
											catalog="<span style='color:gray;'>(>﹏<。)～呜呜呜……~暂无目录</span>";
										}
										// document.getElementById("bookInfo").innerHTML=author+"《"+title+"》";
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
										// document.getElementById("douban_url").innerHTML="豆瓣《"+title+"》";
										
										
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


			function addToLibrary(){
				var book_isbn=$("#isbn13").text();
				var book_intro=$("#add_intro").val();
				var book_number=$("#book_number").val();

				$.ajax({
				    //提交数据的类型 POST GET
				    type: "POST",
				    //提交的网址
				    url: "/?action=add_library",

				    //提交的数据
				    data: { isbn13: book_isbn , intro: book_intro , count: book_number},
				    //返回数据的格式
				    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
				    //在请求之前调用的函数
				    beforeSend: function () {
				    	// alert("beforeSend");
				     //    return true;
				    },
				    //成功返回之后调用的函数             
				    success: function (data) {
				        //$("#msg").html(decodeURI(data));
				        jsonDate = JSON.parse(data);
				        //入库成功
				        if(jsonDate['code']=="1" || jsonDate['code']=="2"){
				        	$.toast("入库成功");
				        	SetCookie("book_number",jsonDate['book_number']);
				        	SetCookie("book_title",$("#title").text());
				        	SetCookie("isbn13",book_isbn);

				        	window.location="add_success.html";
				        }
				        else{
				        	$.toast("入库失败");
				        }
				        // alert(jsonDate['code']);
				        // window.location="add_success.html";

				        // if (jsonDate['code'] == "-1") {
				        //     $("#username").val("");
				        //     showError('账号不存在!', $("#username"));
				        //     $("#username").focus();
				        // }
				        // else if (jsonDate['code'] == "0") {
				        //     $("#password").val("");
				        //     showError('密码错误!', $("#password"));
				        //     $("#password").focus();
				        // }
				        // else if (jsonDate['code'] == "1") {
				        //     window.location.href = "amaze/admin_index.aspx";
				        // }

				        //if (jsonDate['code'] == "1") {

				            

				        //    setTimeout(function () {
				        //        //第三方扩展皮肤
				        //        layer.alert('登录成功', {
				        //            icon: 5
				        //        })
				        //    }, 5000)
				        //    window.location.href = "userspace.aspx";
				        //} 
				        
				        ////第三方扩展皮肤
				        //layer.alert('密码错误', {
				        //    icon: 5
				        //})

				    },
				    //调用执行后调用的函数
				    complete: function (XMLHttpRequest, textStatus) {
				        //alert(XMLHttpRequest.responseText);
				        //alert(textStatus);
				        //HideLoading();
				    },
				    //调用出错执行的函数
				    error: function () {
				        //请求出错处理
				        // alert('ajax请求出错');
				        $.toast("AJAX请求失败", "cancel");
				    }
				});
			}

			/*
			name:cookie 名
			value:cookie 值
			*/
			//写入cookie
			function SetCookie(name,value){
				var Days = 30; //此 cookie 将被保存 30 天
				var exp = new Date();
				exp.setTime(exp.getTime() + Days*24*60*60*1000);
				document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
			}
			///删除cookie
			function delCookie(name){
				var exp = new Date();
				exp.setTime(exp.getTime() - 1);
				var cval=getCookie(name);
				if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
			}
			//读取cookie
			function getCookie(name){
				var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
				if(arr != null)
				return unescape(arr[2]);
				return null;
			}
		</script>



		

		<!-- jQuery -->

		<script src="layer/layer.js"></script>
	</body>

	</html>