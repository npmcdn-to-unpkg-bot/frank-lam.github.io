<?php
return array(
    
    //'配置项'=>'配置值'
    // 'DEFAULT_V_LAYER' 		=> 'Template',	//默认视图层
    // 'TMPL_TEMPLATE_SUFFIX'	 => '.jike',		//模板后缀
    // 'TMPL_FILE_DEPR' 		=> '_',			//分隔符
    // 'VIEW_PATH' 			=> './Theme/Views/',	//自定义视图目录
    'DEFAULT_THEME'		=>'default',
    'TMPL_DETECT_THEME'	=>true,
    'THEME_LIST'			=>'default,jike',
    'TMPL_L_DELIM'                      =>'{{',
    'TMPL_R_DELIM'                      =>'}}',
    'TMPL_PARSE_STRING'           =>array(
                '__CDN__'=>'./Cdn',
                '__AVATAR__'=>__ROOT__.'/Uploads/avatar'
        ),
    'TAGLIB_PRE_LOAD'=>'Views\TagLib\Jike',
    //'TAGLIB_BUILD_IN'=>'Views\TagLib\Jike',
    // 'LAYOUT_ON'=>true,
    // 'LAYOUT_NAME'=>'layout',
    // 'TMPL_LAYOUT_ITEM'=>'{__CONTENT__}'
);
