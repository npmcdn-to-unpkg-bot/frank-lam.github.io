/*  ##获取早餐TOP值
 *  返回JSON如下：
 *  {"id":"1","item":"top_rank","privilege_intro":"设置可选早餐TOP排名","value":"10","status":"1","on_tips":null,"begintime":null,"endtime":null}
 *  example： getTopOfPrivilege().value;
*/
function getTopOfPrivilege() {
	var result;
	$.ajax({
		type: "GET",
		url: "/?action=doQuery",
		async: false,
		data: {
			sql: "select * from att_privilege_config where item='top_rank'"
		},
		datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
		success: function(data) {
			JsonData = JSON.parse(data);
			result = JsonData;
		}
	});
	return result;
}


/*  ##获取有效时间段
 *  返回JSON如下：
 *  {"id":"1","item":"valid_time","privilege_intro":"设置有效时间时段","value":"10","status":"1","on_tips":null,"begintime":null,"endtime":null}
 *  example： getValidTimeOfPrivilege().begintime;
 *  example： getValidTimeOfPrivilege().endtime;
*/
function getValidTimeOfPrivilege() {
	var result;
	$.ajax({
		type: "GET",
		url: "/?action=doQuery",
		async: false,
		data: {
			sql: "select * from att_privilege_config where item='valid_time'"
		},
		datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
		success: function(data) {
			JsonData = JSON.parse(data);
			result = JsonData;
		}
	});
	return result;
}