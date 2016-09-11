/**
* 基础控制中心
*/
var BaseControl = {
    _siteName:"红创金服",//站点名称
    _maxRequestTime:3,//最大重新请求次数
    _curRequestTime:0,//当前请求次数
    _interval: 20,//时间器间隔毫秒数 用于检测load是否执行
    _isload: false,//是否成功请求了用户是否登录的检验
    _uid: 0,//用户编号
    _paypassinit: false,//是否进行了支付密码私钥初始化
    _paypasssed: "",//私钥
    _callback: null,//回调方法 用于临时存放ajax传递过来的回调函数
    _j: null,// 用于存放用户登录后的_ME对象
    _winwidth: 300,//弹窗宽度
    _winheight: 200,//弹窗高度
    _loginurl: "/ind/login.html",
    _wxloginurl:"/index_wx.php",//微信内登录跳转地址
    _ucenterurl:"/page/ucenter.html",//用户登录后进入的主页面地址
    _kjsid:12,//快捷支付渠道统一设置 12：宝付,
    _wintype:"lhgdialog",//弹窗类型 （ruidialog 自定义弹窗 | lhgdialog 第三方弹窗 $.dialog 方式
    /**
    * 预加载数据包括板块
    */
  
    /**
    * 根据不同设备跳转到不同的登录页面
    */

    /**
    * 跳转到某个页面
    * @param url(string) 跳转页面链接
    * @param gotime(number) 等待跳转的秒数
    * @param needlogin(bool) 是否需要登录 需要则直接跳转至login.html页面
    */

    /**
    * 切换tab
    * @param thisObj:object 点击的tab对象
    * @param Num：number 对应tab的序号
    * @param noCls:string 未选中状态的样式表 默认为sta
    * @param yesCls:string 选中状态的样式表 默认为active
    */

    /**
    * ajax获取json数据 支持回调
    * @param url(string) 接口地址 同时也支持对象传递{url:",data:{}}
    */
    loadJson: function (url, callback) {
        var _data = {}, _type = "post";

        if (typeof url == 'object' && url.url) {
            _data = url.data;
            if (url.type)
                _type = url.type;
            url = url.url;
        }
        $.ajax({
            url: url,
            type: _type, // 默认post
            dataType: "json",
            data: _data,
            success: function (json) {
                if (typeof callback == "function") {
                    callback(json);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (typeof callback == "function") {
                    callback({ reload: true });//reload：为true表示重新执行数据请求 多见适用于用户是否登录认证
                }
            }
        });
    },
    loadJsonNoAsync: function (url, callback) {
        var _data = {}, _type = "post";

        if (typeof url == 'object' && url.url) {
            _data = url.data;
            if (url.type)
                _type = url.type;
            url = url.url;
        }
        $.ajax({
            url: url,
            type: _type, // 默认post
            dataType: "json",
            async: false,//同步机制开启
            data: _data,
            success: function (json) {
                if (typeof callback == "function") {
                    callback(json);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //alert(textStatus);
            }
        });
    },
    /**
     * 将json数据对象根据模板进行数据显示解析
     * @param json:obejct 数据对象
     * @param templateId:string 数据模板ID 兼容已逗号间隔的ID串形如：template1,template2
     * @param showId:string  html显示容器ID 兼容已逗号间隔的ID串形如：show1,show2
     * @param callback:function 回调函数（模板解析完毕后的回调函数 需要对生成的html元素进行后续操作）
     * @param isAppend:bool 是否为数据附加模式（常见于列表分页加载的需求）
     */
    converTemplateToHtml:function(json, templateId, showId,callback,isAppend) {
        if(json && templateId && showId) {
            var templateArr = templateId.split(','),showArr = showId.split(',');
            if(templateArr.length != showArr.length)
            {
                console.error("模板个数与容器个数不对等，请检查!");
                return;
            }
            for(var i = 0;i<templateArr.length;i++) {
                if ($("#" + templateArr[i]).length == 0) {
                    console.error(templateArr[i] + " 的模板不存在");
                    return;
                }
                if ($("#" + showArr[i]).length == 0) {
                    console.error(showArr[i] + " 的容器不存在");
                    return;
                }
                var rst = TrimPath.processDOMTemplate(templateArr[i], json);  // 解析制定的 _tid 中的模版代码
                //是否附加模式
                if (isAppend)
                    $("#" + showArr[i]).append(rst.toString());
                else
                    $("#" + showArr[i]).html(rst.toString());
            }
            if(typeof callback == "function")
                callback();
        }
    },
    /**
     * 普通ajax表单提交
     * @param {Object} form
     * @param {Object} callback
     * @param {String} confirmMsg 提示确认信息
     */
    validateCallback: function (form, callback) {
        var $form = $(form);
        var sdata = $form.serializeArray();
        for (var i in sdata) {
            if (sdata[i].name != undefined && sdata[i].name == 'pwd')
                sdata[i].value = this.encryptPass(sdata[i].value);
        }

        var _submitFn = function () {
            $.ajax({
                type: form.method?form.method:"get",
                url: $form.attr("action"),
                data: sdata,
                dataType: "json",
                cache: false,
                success: callback,
                error: callback
            });
        }
        _submitFn();

        return false;
    },

    ///表状态处理函数

    /**
    * 根据dom对象 数据源和 属性进行内容渲染
    */
    SetItemDom: function (_dom, json, k) {
        //front:前缀  back :后缀  format:是否格式化为千分位 len :显示长度 showstart 是截取字符串开始位置  default:默认填充文字 当数据对象为空时
        var _front = '', _back = '', _format = "0", _len = 0, _default = "";

        if (_dom.tagName == 'A') {
            var _href = decodeURI(_dom.getAttribute('href'));
            while (_href.indexOf('{' + k + '}') > 1) {
                _len++;
                _href = _href.replace('{' + k + '}', json[k]);
            }

            if (_len) {
                _dom.setAttribute('href', _href);
                _dom.setAttribute('ishaveK', 1);
            }
        } else if (_dom.tagName == 'IMG') {
            var _src = decodeURI(_dom.getAttribute('src'));
            if (typeof json[k] == "string" && (json[k].substr(0, 8) == 'https://' || json[k].substr(0, 7) == 'http://')) {
                _src = json[k]; _len++;
            } else {
                while (_src.indexOf('{' + k + '}') >= 0) {
                    _src = _src.replace('{' + k + '}', json[k]);
                    _len++;
                }
            }

            if (_len) {
                _dom.setAttribute('src', _src);
                _dom.setAttribute('ishaveK', 1);
            }
        }
        if (_dom.getAttribute('ishaveK') == 1) return;;  // 说明上面的代码以及处理过了，后续不需要再处理
        _back = _dom.getAttribute('kattr');         // _back 这个时候是需要高修改的属性的名称
        if (_back) { // 如果是要设置属性，那么这里替换属性中的数值即可
            _front = _dom.getAttribute('kval');
            if (!_front)
                _front = _dom.getAttribute(_back);
            while (_front.indexOf('{' + k + '}') != -1) {
                _front = _front.replace('{' + k + '}', json[k]);
            }
            if (_back == 'src' && typeof json[k] == "string" && (json[k].substr(0, 8) == 'https://' || json[k].substr(0, 7) == 'http://')) _front = json[k];
            _dom.setAttribute(_back, _front);
            _dom.setAttribute('ishaveK', 1);
        } else {
            if (_dom.tagName == 'SELECT') {
                _dom.value = json[k].toString();
                 //兼容页面k.a 与k_a的情况
                if(_dom.id.split('.').length == 2)
                {
                    if(document.getElementById(_dom.id.replace(".","_")))
                        document.getElementById(_dom.id.replace(".","_")).value = _dom.value;
                }
            } else if ((_dom.type === 'text' || _dom.type === 'hidden') && typeof _dom.value === 'string') {
                _dom.value = json[k].toString();
                 //兼容页面k.a 与k_a的情况
                if(_dom.id.split('.').length == 2)
                {
                    if(document.getElementById(_dom.id.replace(".","_")))
                        document.getElementById(_dom.id.replace(".","_")).value = _dom.value;
                }
            } else if (_dom.tagName == 'INPUT' && typeof _dom.checked === 'boolean') {
                if (_dom.value == json[k]) _dom.checked = true; else _dom.checked = false;
                //兼容页面k.a 与k_a的情况
                if(_dom.id.split('.').length == 2)
                {
                    if(document.getElementById(_dom.id.replace(".","_")))
                        document.getElementById(_dom.id.replace(".","_")).checked = _dom.checked;
                }
            } else if (typeof _dom.innerHTML !== 'undefined') {
                _front = _dom.getAttribute('front'); // 显示的前缀
                _back = _dom.getAttribute('back'); // 显示的后缀
                _len = _dom.getAttribute('showlen');
                _format = _dom.getAttribute('format');
                _default = _dom.getAttribute("default");
                if (!_front) _front = ''; if (!_back) _back = ''; if (!_default) _default = ''; if (!_format) _format = '0'; if (!_len) _len = 0; _len = _len * 1;
                if (_len) {
                    var _start = _dom.getAttribute('showstart'); _start = _start * 1; if (!_start) _start = 0;   // showstart 是截取字符串开始位置
                    _dom.innerHTML = _front + json[k].toString().substr(_start, _len) + _back;
                    //兼容页面k.a 与k_a的情况
                    if(_dom.id.split('.').length == 2)
                    {
                        if(document.getElementById(_dom.id.replace(".","_")))
                            document.getElementById(_dom.id.replace(".","_")).innerHTML = _dom.innerHTML;
                    }
                } else {
                    var _s = json[k].toString();

                    _len = _dom.getAttribute('ooqfw');
                    if (_len && _len != '' && !isNaN(_len)) {
                        //_s = moneyStr3(_s, parseInt(_len), '');
                        //_len = parseInt(_len.substr(2));
                        //if (_len) sprintf("%" + _len + "s", _s); 
                        if (!isNaN(_s)) {
                            _s = Number(_s).toFixed(Number(_len));
                            if (Number(_len) > 0 && _s.indexOf(".") == -1) _s += ".00";
                        }
                    }
                    if (_format * 1 && !isNaN(_s)) {
                        //需要格式化
                        _s = Number(_s).toLocaleString();
                        if (_s.indexOf(".") == -1) _s += ".00";
                    }

                    //自动填充内容
                    if (_default.length > 0 && (!_s || _s.length == 0)) {
                        _s = _default;
                    }
                    _dom.innerHTML = _front + _s + _back;
                    //兼容页面k.a 与k_a的情况
                    if(_dom.id.split('.').length == 2)
                    {
                        if(document.getElementById(_dom.id.replace(".","_")))
                            document.getElementById(_dom.id.replace(".","_")).innerHTML = _front + _s + _back;
                    }
                }
            }
        }
    },
    /**
    * 根据json数据内每一个层级的数据对象去页面内对应查找ID元素进行赋值
    */
    SetItemToK_Id: function (json, _pre) {
        if (!_pre) _pre = 'k.';
        for (var k in json) {
            if (json[k] == null) json[k] = '';
            if (typeof json[k] === 'string' || typeof json[k] === 'number') {
                var _dom = document.getElementById(_pre + k);   // 如果存在同 key 同名的 dom 对象  getElementById 只能获得第一个
                if (!_dom && json[k].toString().length < 20) {
                    _dom = document.getElementById(_pre + k + '_' + json[k]);   // 特殊用法用来处理 radio box的情况
                }
                if (!_dom) _dom = document.getElementById('k_' + k);  // 为了兼容老的

                if (_dom) {
                    if (_dom.getAttribute('ismore') == '1') {
                        var _d = $("[id='" + _dom.id + "']", document); // 这里针对有多个 id 相同的情况处理一下
                        if (_d.length > 1) {
                            //_d.html(json[k].toString());
                            for (var i = 1; i < _d.length; i++) {
                                this.SetItemDom(_d[i], json, k);
                            }
                        }
                    }
                    this.SetItemDom(_dom, json, k);
                } else if (!_dom && !isNaN(json[k] * 1)) {
                    _dom = document.getElementsByName(k + '[]');   // 这个情况是 checkbox 按位与的情况
                    if (_dom) {
                        for (var i = 0; i < _dom.length; i++) {
                            if (typeof _dom[i].checked === 'boolean') {
                                if (_dom[i].value & json[k]) {
                                    _dom[i].checked = true;
                                } else {
                                    _dom[i].checked = false;
                                }
                            }
                        }
                    }
                }
            } else if (json[k] && typeof json[k] === 'object') {
                //** 注意 这里跳过了数组，不去遍历数组能节约大量时间，这里一直是效率的瓶颈
                if (json[k] instanceof Array) { } else this.SetItemToK_Id(json[k], _pre + k + '.');
            }
        }
    },
    /**
    * 弹窗回调
    */
    /**
     * 写入cookies
     * @param key 键
     * @param val 值
     * @param day 存放多少天
     */
    setCookies:function(key,val,day)
    {
        //获取当前日期
        var expiresDate = new Date();
        //设置生存期，一天后过期
        expiresDate.setDate(expiresDate.getDate() + (day?day:1));
        document.cookie = key+"="+val+";expires= " + expiresDate.toGMTString();//标记已经访问了站点
    },
    /**
     * 获取cookies
     * @param key
     */
    getCookies:function(key)
    {
        var search = key + "=";
        var returnvalue = "";
        if (document.cookie.length > 0) {
            offset = document.cookie.indexOf(search);
            if (offset != -1) {
                // 已经存在cookies内
                offset += search.length;
                // set index of beginning of value
                end = document.cookie.indexOf(";", offset);
                // set index of end of cookie value
                if (end == -1)
                    end = document.cookie.length;
                returnvalue = unescape(document.cookie.substring(offset, end));
            }
        }
        return returnvalue;
    },
    /**
     * 删除cookies
     * @param key
     */
    delCookies:function(key)
    {
        //获取当前日期
        var expiresDate = new Date();
        //设置生存期，一天后过期
        expiresDate.setDate(expiresDate.getDate() - 100);
        document.cookie = key+"="+val+";expires= " + expiresDate.toGMTString();//标记已经访问了站点
    },
    /**
     * 时间戳格式化为X天X小时X分X秒 的字符串形式
     * @param sec(long long int) :时间戳
     * @param targetId（string):显示容器id
     * @returns {*}
     */
    timeFormat:function(sec,targetId) {
        if(!document.getElementById(targetId)) return;
        var _formatStr = "",_oldSec = sec;
        if (sec <= 0) {
            _formatStr = '已过期';
            document.getElementById(targetId).innerHTML = _formatStr ;
            return;
        }
        var _day = Math.floor(sec / (24 * 3600));
        if (_day)_day = _day + '天'; else _day = '';
        var _hour = Math.floor((sec % (24 * 3600)) / 3600);
        if (_hour)_hour = _hour + '小时'; else _hour = '';
        var _min = Math.floor((sec % 3600) / 60);
        if (_min)_min = _min + '分'; else _min = '';
        var _sec = Math.floor(sec % 60);
        _sec = '<font color=red>' + _sec + '</font>' + '秒';
        _formatStr =  _day + _hour + _min + _sec;
        document.getElementById(targetId).innerHTML = _formatStr ;
        setTimeout(function() {
            BaseControl.timeFormat(--_oldSec, targetId);
        },1000);
    },
    /**
    * 动态加载外部js资源文件
    * @param _scripts:string 外部脚本路径串多个路径用|间隔 形如：a.js|b.js|c.js
    * @param _callback:funciton js文件载入完毕后的回调函数
    */
    loadScript:function(_scripts,_callback)
    {
        if(_scripts)
        {
            var oHead = document.getElementsByTagName('HEAD').item(0); 
            var oScript= document.createElement("script"); 
            oScript.type = "text/javascript";             
            var scriptArr = _scripts.split('|');
            for(var i = 0;i<scriptArr.length;i++)
            {
                if(scriptArr[i])
                {
                    oScript.src = scriptArr[i]; 
                    oHead.appendChild( oScript); 
                }
            }
            if(typeof _callback == "function")
                _callback.call();
        }
    },
    /**
     * 其他插件扩展公用入口
     */
  
};