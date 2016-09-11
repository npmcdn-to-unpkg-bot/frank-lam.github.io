/*公共JS函数库
    2016-7-31 16:39创建  by 林立城
*/

//获取字符串长度
function getStrSize(str) {
	var realLength = 0,
		len = str.length,
		charCode = -1;
	for(var i = 0; i < len; i++) {
		charCode = str.charCodeAt(i);
		if(charCode >= 0 && charCode <= 128) realLength += 1;
		else realLength += 2;
	}
	return realLength;
};

//获取URL参数
function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = location.search.substr(1).match(reg);
	if(r != null) return unescape(decodeURI(r[2]));
	return null;
}

function getParam(b) {
	var c = document.location.search;
	if(!b) {
		return c
	}
	var d = new RegExp("[?&]" + b + "=([^&]+)", "g");
	var g = d.exec(c);
	var a = null;
	if(null != g) {
		try {
			a = decodeURIComponent(decodeURIComponent(g[1]))
		} catch(f) {
			try {
				a = decodeURIComponent(g[1])
			} catch(f) {
				a = g[1]
			}
		}
	}
	return a;
}
//Cookies操作方法
//写入cookie
function SetCookie(name, value) {
	var Days = 30; //此 cookie 将被保存 30 天
	var exp = new Date();
	exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
	document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}
///删除cookie
function delCookie(name) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if(cval != null) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}
//读取cookie
function getCookie(name) {
	var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
	if(arr != null)
		return unescape(arr[2]);
	return null;
}

//判断设备
function IsPC() {
	var userAgentInfo = navigator.userAgent;
	var Agents = ["Android", "iPhone",
		"SymbianOS", "Windows Phone",
		"iPad", "iPod"
	];
	var flag = true;
	for(var v = 0; v < Agents.length; v++) {
		if(userAgentInfo.indexOf(Agents[v]) > 0) {
			flag = false;
			break;
		}
	}
	return flag;
}

$("#public").load("tabar.html");

// 判断时间是否在范围内
function time_range(beginTime, endTime, nowTime) {
	var strb = beginTime.split(":");
	if(strb.length != 2) {
		return false;
	}

	var stre = endTime.split(":");
	if(stre.length != 2) {
		return false;
	}

	var strn = nowTime.split(":");
	if(stre.length != 2) {
		return false;
	}
	var b = new Date();
	var e = new Date();
	var n = new Date();

	b.setHours(strb[0]);
	b.setMinutes(strb[1]);
	e.setHours(stre[0]);
	e.setMinutes(stre[1]);
	n.setHours(strn[0]);
	n.setMinutes(strn[1]);

	if(n.getTime() - b.getTime() > 0 && n.getTime() - e.getTime() < 0) {
		return true;
	} else {
		//alert("当前时间是：" + n.getHours() + ":" + n.getMinutes() + "，不在该时间范围内！");
		return false;
	}
}

//调用：
//alert( CompareDate("12:00","11:15") );
//t1时间大于t2时间返回true
function CompareDate(t1, t2) {
	var date = new Date();
	var a = t1.split(":");
	var b = t2.split(":");
	return date.setHours(a[0], a[1]) > date.setHours(b[0], b[1]);
}