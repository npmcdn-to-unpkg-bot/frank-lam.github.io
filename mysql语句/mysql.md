
http://pandao.github.io/editor.md/

###获取昨日日期
date(verify_time) = date_sub(curdate(),interval 1 day);



###mysql语句中把string类型字段转datetime类型
select * from h_hotelcontext where now() between STR_TO_DATE(Start_time,'%Y-%m-%d %H:%i:%s') and STR_TO_DATE(End_time,'%Y-%m-%d %H:%i:%s'); 
注：'%Y-%m-%d %H:%i:%s'格式为：2012-10-11 16:42:30
