<?php

self::$InitTable[0] = function (&$a) {
	$a['errFlag'] = 1;
};



self::$InitTable['article'] = function (&$a) {
	$a['params'] = array(
		"id" => "",
		"ref" => 0,
		"slug" => "",
		"deadline" => "initial_offline",
		"name" => "new article",
		"desc" => "",
		"title" => "Nouvel article",
		"subtitle" => "",
		"page" => "1",

		"layout_generic_name" => "default",
		"config" => "par_defaut",
		"config_id" => 0,

		"creator" => $a['Initiator']['user_name'],
		"creation_date" => 0,
		"validator" => $a['Initiator']['user_name'],
		"validation_date" => 0,
		"validation_state" => "NON_VALIDE",

		"parution_date" => 0,
		"docu_id" => 0,
		"docu_name" => "",
		"filtre" => "",
		"ws_id" => $a['Context']['ws_id']
	);
	$a['params']['document']	= &$a['params']['docu_name'];
	$a['params']['reference']	= &$a['params']['ref'];
};

self::$InitTable['article_tag'] = function (&$a) {
	$a['params'] = array(
		"name" => "",
		"article_tag_id" => "",
		"arti_name" => "",
		"tag_name" => "",
		"docutag_lang" => "Fra"
	);
};

self::$InitTable['context'] = function (&$a) {
	$a['params'] = array(
		"name" => "",
		"user" => "",
		"user_id" => "",
		"password" => "",
	);
	$a['params']['site']		= &$a['params']['name'];
};

self::$InitTable['checkpoint'] = function (&$a) {
	$a['params'] = array(
		"name"					=> "New variable",
	);
};


self::$InitTable['content'] = function (&$a) {
	$a['params'] = array(
		"file" => "Nouveau menu",
		"into" => "",
	);
};


self::$InitTable['deadline'] = function (&$a) {
	$date = time();
	$a['params'] = array(
		"id" => "",
		"name" => "New DeadLine",
		"title" => "New deadline title",
		"state" => 0,
		"date_creation" => $date,
		"end_date" => ($date + (60 * 60 * 24 * 31 * 12 * 10)),
		"ws_id" => $a['Context']['ws_id'],
	);
	//	$a['params']['date_expiration']	= &$a['params']['end_date'];
};

self::$InitTable['definition'] = function (&$a) {
	$a['params'] = array(
		"id"		=> 0,
		"name"		=> "New definition",
		"number"	=> 0,
		"text"		=> "_",
	);
};


self::$InitTable['decoration'] = function (&$a) {
	$a['params'] = array(
		"name"			=> "New Decoration",
		"id"			=> "",
		"directory"		=> "",
		"state"			=> "ONLINE",
		"type"			=> "1_div",

		"background_url"	=> "",
		"background_color"	=> "",

		"border_top_width"		=> 0,	"border_top_color"		=> "",	"border_top_style"		=> "",	"padding_top"		=> 0,	"margin_top"		=> 0,
		"border_bottom_width"	=> 0,	"border_bottom_color"	=> "",	"border_bottom_style"	=> "",	"padding_bottom"	=> 0,	"margin_bottom"		=> 0,
		"border_left_width"		=> 0,	"border_left_color"		=> "",	"border_left_style"		=> "",	"padding_left"		=> 0,	"margin_left"		=> 0,
		"border_right_width"	=> 0,	"border_right_color"	=> "",	"border_right_style"	=> "",	"padding_right"		=> 0,	"margin_right"		=> 0,
		"border_all_width"		=> 0,	"border_all_color"		=> "",	"border_all_style"		=> "",	"padding_all"		=> 0,	"margin_all"		=> 0,


		"ex11" => "vide.gif",		"ex12" => "vide.gif",			"ex13" => "vide.gif",		"ex14" => "vide.gif",	"ex15" => "vide.gif",
		"ex21" => "vide.gif",		"ex22" => "vide.gif",			"ex23" => "vide.gif",		"ex24" => "vide.gif",	"ex25" => "vide.gif",
		"ex31" => "vide.gif",		"ex32" => "vide.gif",			"ex33" => "vide.gif",		"ex34" => "vide.gif",	"ex35" => "vide.gif",
		"ex41" => "vide.gif",		"ex42" => "vide.gif",			"ex43" => "vide.gif",		"ex44" => "vide.gif",	"ex45" => "vide.gif",
		"ex51" => "vide.gif",		"ex52" => "vide.gif",			"ex53" => "vide.gif",		"ex54" => "vide.gif",	"ex55" => "vide.gif",
		"ex11_x" => "2",			"ex11_y" => "2",				"ex11_bgp" => "top-left",
		"ex12_x" => "2",			"ex12_y" => "2",				"ex12_bgp" => "top-left",
		"ex13_x" => "2",			"ex13_y" => "2",				"ex13_bgp" => "top-left",
		"ex14_x" => "2",			"ex14_y" => "2",				"ex14_bgp" => "top-left",
		"ex15_x" => "2",			"ex15_y" => "2",				"ex15_bgp" => "top-left",
		"ex21_x" => "2",			"ex21_y" => "2",				"ex21_bgp" => "top-left",
		"ex22_x" => "2",			"ex22_y" => "2",				"ex22_bgp" => "top-left",
		"ex23_x" => "2",			"ex23_y" => "2",				"ex23_bgp" => "top-left",
		"ex24_x" => "2",			"ex24_y" => "2",				"ex24_bgp" => "top-left",
		"ex25_x" => "2",			"ex25_y" => "2",				"ex25_bgp" => "top-left",
		"ex31_x" => "2",			"ex31_y" => "2",				"ex31_bgp" => "top-left",
		"ex32_x" => "2",			"ex32_y" => "2",				"ex32_bgp" => "top-left",
		"ex33_x" => "2",			"ex33_y" => "2",				"ex33_bgp" => "top-left",
		"ex34_x" => "2",			"ex34_y" => "2",				"ex34_bgp" => "top-left",
		"ex35_x" => "2",			"ex35_y" => "2",				"ex35_bgp" => "top-left",
		"ex41_x" => "2",			"ex41_y" => "2",				"ex41_bgp" => "top-left",
		"ex42_x" => "2",			"ex42_y" => "2",				"ex42_bgp" => "top-left",
		"ex43_x" => "2",			"ex43_y" => "2",				"ex43_bgp" => "top-left",
		"ex44_x" => "2",			"ex44_y" => "2",				"ex44_bgp" => "top-left",
		"ex45_x" => "2",			"ex45_y" => "2",				"ex45_bgp" => "top-left",
		"ex51_x" => "2",			"ex51_y" => "2",				"ex51_bgp" => "top-left",
		"ex52_x" => "2",			"ex52_y" => "2",				"ex52_bgp" => "top-left",
		"ex53_x" => "2",			"ex53_y" => "2",				"ex53_bgp" => "top-left",
		"ex54_x" => "2",			"ex54_y" => "2",				"ex54_bgp" => "top-left",
		"ex55_x" => "2",			"ex55_y" => "2",				"ex55_bgp" => "top-left",

		"in11" => "vide.gif",		"in12" => "vide.gif",			"in13" => "vide.gif",		"in14" => "vide.gif",	"in15" => "vide.gif",
		"in21" => "vide.gif",																										"in25" => "vide.gif",
		"in31" => "vide.gif",																										"in35" => "vide.gif",
		"in41" => "vide.gif",																										"in45" => "vide.gif",
		"in51" => "vide.gif",		"in52" => "vide.gif",			"in53" => "vide.gif",		"in54" => "vide.gif",	"in55" => "vide.gif",
		"in11_x" => "2",			"in11_y" => "2",	"in11_bgp" => "top-left",
		"in12_x" => "2",			"in12_y" => "2",	"in12_bgp" => "top-left",
		"in13_x" => "2",			"in13_y" => "2",	"in13_bgp" => "top-left",
		"in14_x" => "2",			"in14_y" => "2",	"in14_bgp" => "top-left",
		"in15_x" => "2",			"in15_y" => "2",	"in15_bgp" => "top-left",
		"in21_x" => "2",			"in21_y" => "2",	"in21_bgp" => "top-left",
		"in25_x" => "2",			"in25_y" => "2",	"in25_bgp" => "top-left",
		"in31_x" => "2",			"in31_y" => "2",	"in31_bgp" => "top-left",
		"in35_x" => "2",			"in35_y" => "2",	"in35_bgp" => "top-left",
		"in41_x" => "2",			"in41_y" => "2",	"in41_bgp" => "top-left",
		"in45_x" => "2",			"in45_y" => "2",	"in45_bgp" => "top-left",
		"in51_x" => "2",			"in51_y" => "2",	"in51_bgp" => "top-left",
		"in52_x" => "2",			"in52_y" => "2",	"in52_bgp" => "top-left",
		"in53_x" => "2",			"in53_y" => "2",	"in53_bgp" => "top-left",
		"in54_x" => "2",			"in54_y" => "2",	"in54_bgp" => "top-left",
		"in55_x" => "2",			"in55_y" => "2",	"in55_bgp" => "top-left",

		"in11_e" => "OFFLINE",
		"in12_e" => "OFFLINE",
		"in13_e" => "OFFLINE",
		"in14_e" => "OFFLINE",
		"in15_e" => "OFFLINE",

		"in21_e" => "OFFLINE",
		"in25_e" => "OFFLINE",

		"in31_e" => "OFFLINE",
		"in35_e" => "OFFLINE",

		"in41_e" => "OFFLINE",
		"in45_e" => "OFFLINE",

		"in51_e" => "OFFLINE",
		"in52_e" => "OFFLINE",
		"in53_e" => "OFFLINE",
		"in54_e" => "OFFLINE",
		"in55_e" => "OFFLINE",


		"ft1" => "vide.gif",		"ft2" => "vide.gif",		"ft3" => "vide.gif",
		"ft1_x" => "16",			"ft3_x" => "16",			"ft_y" => "16",

		"bgca" => "vide.gif",		"bgcb" => "vide.gif",
		"bgcc" => "vide.gif",		"bgcd" => "vide.gif",
		"bgcta" => "vide.gif",		"bgctb" => "vide.gif",
		"bgcsa" => "vide.gif",		"bgcsb" => "vide.gif",
		"bgco" => "vide.gif",

		"main_unit" =>	"mm",	"txt_font_unit" =>	"px",
		"txt_fonte" => "Arial, Helvetica, Sans-serif",
		"txt_fonte_size_min" => 12,	"txt_fonte_size_max" => 24,
		"p_txt_indent" => 0,		"p_txt_align" => "justify",	"p_special" => "",

		"txt_col" => "000000",		"txt_highlight_col" => "000000",		"txt_bg_col" => "transparent",			"txt_titre_col" => 		"000000",
		"txt_ok_col" => "000000",	"txt_avert_col" => "000000",			"txt_erreur_col" => "000000",			"txt_fade_col" => "000000",

		"txt_l_01_display" => "inline",	"txt_l_01_size" => 0,					"txt_l_01_weight" => "normal",				"txt_l_01_decoration" => "none",
		"txt_l_01_margin_top" => 0,		"txt_l_01_margin_bottom" => 0,			"txt_l_01_margin_left" => 0,				"txt_l_01_margin_right" => 0,
		"txt_l_01_hover_size" => 0,		"txt_l_01_hover_weight" => "normal",	"txt_l_01_hover_decoration" => "none",
		"txt_l_01_fg_col" => "000000",	"txt_l_01_fg_hover_col" => "444444",	"txt_l_01_fg_active_col" => "000000",		"txt_l_01_fg_visite_col" => "000000",
		"txt_l_01_bg_col" => "",		"txt_l_01_bg_hover_col" => "",			"txt_l_01_bg_active_col" => "000000",		"txt_l_01_bg_visite_col" => "000000",

		"txt_l_td_display" => "inline",	"txt_l_td_size" => 0,					"txt_l_td_weight" => "normal",				"txt_l_td_decoration" => "none",
		"txt_l_td_margin_top" => 0,		"txt_l_td_margin_bottom" => 0,			"txt_l_td_margin_left" => 0,				"txt_l_td_margin_right" => 0,
		"txt_l_td_hover_size" => 0,		"txt_l_td_hover_weight" => "normal",	"txt_l_td_hover_decoration" => "none",
		"txt_l_td_fg_col" => "000000",	"txt_l_td_fg_hover_col" => "444444",	"txt_l_td_fg_active_col" => "000000",		"txt_l_td_fg_visite_col" => "000000",
		"txt_l_td_bg_col" => "",		"txt_l_td_bg_hover_col" => "",			"txt_l_td_bg_active_col" => "000000",		"txt_l_td_bg_visite_col" => "000000",

		"txt_input1_fg_col" => "000000",	"txt_input1_bg_col" => "ffffff",
		"txt_input2_fg_col" => "000000",	"txt_input2_bg_col" => "ffffff",
		"txt_input1_td_fg_col" => "000000",	"txt_input1_td_bg_col" => "ffffff",
		"txt_input2_td_fg_col" => "000000",	"txt_input2_td_bg_col" => "ffffff",

		"code_font" => "",				"code_fg_col" => "000000",	"code_bg_col" => "ffffff",
		"code_mrg_top" => 0,			"code_mrg_bottom" => 0,		"code_mrg_left" => 0,				"code_mrg_right" => 0,
		"code_pad_top" => 0,			"code_pad_bottom" => 0,		"code_pad_left" => 0,				"code_pad_right" => 0,
		"code_special" => "",

		"ca_txt_col" => "000000",			"ca_txt_bg_col" => "transparent",
		"cb_txt_col" => "000000",			"cb_txt_bg_col" => "transparent",
		"cc_txt_col" => "000000",			"cc_txt_bg_col" => "transparent",
		"cd_txt_col" => "000000",			"cd_txt_bg_col" => "transparent",
		"cta_txt_col" => "000000",			"cta_txt_bg_col" => "transparent",
		"ctb_txt_col" => "000000",			"ctb_txt_bg_col" => "transparent",
		"csa_txt_col" => "000000",			"csa_txt_bg_col" => "transparent",
		"csb_txt_col" => "000000",			"csb_txt_bg_col" => "transparent",
		"co_txt_col" => "000000",			"co_txt_bg_col" => "transparent",


		"s1_txt_col" => "000000",				"s2_txt_col" => "000000",				"s3_txt_col" => "000000",
		"s1_txt_weight" => "normal",			"s2_txt_weight" => "normal",			"s3_txt_weight" => "normal",
		"s1_txt_shadow" => "0 0 0px #000000",	"s2_txt_shadow" => "0 0 0px #000000",	"s3_txt_shadow" => "0 0 0px #000000",

		"s1_txt_hover_col" => "000000",				"s2_txt_hover_col" => "000000",				"s3_txt_hover_col" => "000000",
		"s1_txt_hover_weight" => "normal",			"s2_txt_hover_weight" => "normal",			"s3_txt_hover_weight" => "normal",
		"s1_txt_hover_shadow" => "0 0 0px #000000",	"s2_txt_hover_shadow" => "0 0 0px #000000",	"s3_txt_hover_shadow" => "0 0 0px #000000",

		"tab_up_txt_col" => "000000",		"tab_up_txt_bg_col" => "000000",	"tab_up_txt_weight" => "normal",	"tab_up_txt_shadow" => "0 0 0px #000000",
		"tab_down_txt_col" => "000000",		"tab_down_txt_bg_col" => "000000",	"tab_down_txt_weight" => "normal",	"tab_down_txt_shadow" => "0 0 0px #000000",
		"tab_hover_txt_col" => "000000",	"tab_hover_txt_bg_col" => "000000",	"tab_hover_txt_weight" => "normal",	"tab_hover_txt_shadow" => "0 0 0px #000000",

		"tab_a" => 	"", 			"tab_b" => 	"", 				"tab_c" => 	"",
		"tab_offset_x" => 	"", 	"tab_offset_y" => 	"",

		"transparent_8x8"		=> "transparent_8x8.png",

		"p_mrg_top" => 0,		"p_mrg_bottom" => 0,		"p_mrg_left" => 0,				"p_mrg_right" => 0,
		"p_pad_top" => 0,		"p_pad_bottom" => 5,		"p_pad_left" => 0,				"p_pad_right" => 0,

		// ***************************************************************************
		// New style
		"main_unit" => 	"mm", 	"txt_font_unit" => 	"px",
		"txt_font_family" => 	"Arial", 	"txt_font_size" => 	"14",
		"txt_font_name_normal" => 	"", 	"txt_font_filename_normal" => 	"",
		"txt_font_name_bold" => 	"", 	"txt_font_filename_bold" => 	"",
		"txt_font_name_italic" => 	"", 	"txt_font_filename_italic" => 	"",

		"p_txt_indent" => 	"", 	"p_txt_align" => 	"",		"p_special" => "",
		"p_mrg_top" => 	"", 		"p_mrg_bottom" => 	"", 	"p_mrg_left" => 	"", 	"p_mrg_right" => 	"",
		"p_pad_top" => 	"", 		"p_pad_bottom" => 	"", 	"p_pad_left" => 	"", 	"p_pad_right" => 	"",
		"p_special" => 	"",

		"txt_col" => 	"000000", 	"txt_highlight_col" => 	"", 	"txt_bg_col" => 	"", 	"txt_title_col" => 	"",
		"txt_ok_col" => "", 		"txt_warning_col" => 	"", 	"txt_error_col" => 	"", 	"txt_fade_col" => 	"",

		"a_fg_col" => 	"", 	"a_bg_col" => 	"", 	"a_decoration" => 	"", 	"a_special" => 	"",
		"a_hover_fg_col" => 	"", 	"a_hover_bg_col" => 	"", 	"a_hover_decoration" => 	"", 	"a_hover_special" => 	"",
		"a_active_fg_col" => 	"", 	"a_active_bg_col" => 	"", 	"a_active_decoration" => 	"", 	"a_active_special" => 	"",
		"a_visited_fg_col" => 	"", 	"a_visited_bg_col" => 	"", 	"a_visited_decoration" => 	"", 	"a_visited_special" => 	"",

		"table_rules" => 	"border-spacing:0px; border-collapse:collapse; width:100%",
		"t01_caption_fg_col" => 	"", 	"t01_caption_bg_col" => 	"", 	"t01_caption_special" => 	"",
		"t01_txt_col" => 	"",
		"t01_tr_bg_col" => 	"", 	"t01_td_bg_odd_col" => 	"",
		"t01_tr_bg_odd_col" => 	"", 	"t01_td_bg_even_col" => 	"",
		"t01_tr_bg_even_col" => 	"", 	"t01_td_special" => 	"",
		"t01_tr_bg_hover_col" => 	"",
		"t01_tr_special" => 	"",
		"t01_legend_txt_col" => 	"", 	"t01_legend_bg_col" => 	"", 	"t01_legend_special" => 	"",

		"td_a_fg_col" => 	"", 			"td_a_bg_col" => 	"", 	"td_a_decoration" => 	"", 	"td_a_display" => 	"",
		"td_a_hover_fg_col" => 	"", 		"td_a_hover_bg_col" => 	"", 	"td_a_hover_decoration" => 	"", 	"td_a_hover_display" => 	"",
		"td_a_active_fg_col" => 	"", 	"td_a_active_bg_col" => 	"", 	"td_a_active_decoration" => 	"", 	"td_a_active_display" => 	"",
		"td_a_visited_fg_col" => 	"", 	"td_a_visited_bg_col" => 	"", 	"td_a_visited_decoration" => 	"", 	"td_a_visited_display" => 	"",

		"code_font" => 	"", 		"code_fg_col" => 	"FFFFFF", 	"code_bg_col" => 	"000000", 		"",
		"code_mrg_top" => 	"", 	"code_mrg_bottom" => 	"", 	"code_mrg_left" => 	"", 	"code_mrg_right" => 	"",
		"code_pad_top" => 	"", 	"code_pad_bottom" => 	"", 	"code_pad_left" => 	"", 	"code_pad_right" => 	"",
		"code_special" => 	"",

		"input_fg_col" => 	"", 	"input_bg_col" => 	"", 	"input_special" => 	"",
		"td_input_fg_col" => 	"", 	"td_input_bg_col" => 	"", 	"td_input_special" => 	"",

		"s1_txt_col" => 	"", 	"s2_txt_col" => 	"", 	"s3_txt_col" => 	"",
		"s1_txt_weight" => 	"", 	"s2_txt_weight" => 	"", 	"s3_txt_weight" => 	"",
		"s1_txt_special" => 	"", 	"s2_txt_special" => 	"", 	"s2_txt_special" => 	"",
		"s1_txt_hover_col" => 	"", 	"s2_txt_hover_col" => 	"", 	"s3_txt_hover_col" => 	"",
		"s1_txt_hover_weight" => 	"", 	"s2_txt_hover_weight" => 	"", 	"s3_txt_hover_weight" => 	"",
		"s1_txt_hover_special" => 	"", 	"s2_txt_hover_special" => 	"", 	"s3_txt_hover_special" => 	"",

		"s1_a" => 	"", 	"s1_b" => 	"", 	"s1_c" => 	"",
		"s2_a" => 	"", 	"s2_b" => 	"", 	"s2_c" => 	"",
		"s3_a" => 	"", 	"s3_b" => 	"", 	"s3_c" => 	"",
		"s1_01_width" => 	"8", 	"s1_01_height" => 	"32", 	"s1_03_width" => 	"8",
		"s2_01_width" => 	"8", 	"s2_01_height" => 	"32", 	"s2_03_width" => 	"8",
		"s3_01_width" => 	"8", 	"s3_01_height" => 	"32", 	"s3_03_width" => 	"8",

		// ***************************************************************************
		"tab_up_txt_col" => 	"", 	"tab_up_txt_bg_col" => 	"", 		"tab_up_txt_weight" => 	"", 		"tab_up_txt_special" => 	"",
		"tab_down_txt_col" => 	"", 	"tab_down_txt_bg_col" => 	"", 	"tab_down_txt_weight" => 	"", 	"tab_down_txt_special" => 	"",
		"tab_hover_txt_col" => 	"", 	"tab_hover_txt_bg_col" => 	"", 	"tab_hover_txt_weight" => 	"", 	"tab_hover_txt_special" => 	"",
		"tab_height" => 	"32", 		"tab_a_width" => 	"16", 			"tab_c_width" => 	"16",
		"tab_down_a" => 	"", 		"tab_down_b" => 	"", 			"tab_down_c" => 	"",
		"tab_up_a" => 	"", 			"tab_up_b" => 	"", 				"tab_up_c" => 	"",
		"tab_hover_a" => 	"", 		"tab_hover_b" => 	"", 			"tab_hover_c" => 	"",
		"tab_frame_bg_col" => 	"", 	"tab_frame_bg_img" => 	"",

		"ft2_font" => 	"", 	"ft2_font_size" => 	"20", 	"ft2_fg_col" => 	"", 	"ft2_special" => 	"",
		"ft1_bg" => 	"", 	"ft2_bg" => 	"", 	"ft3_bg" => 	"",
		"ft1_width" => 	"16", 	"ft3_width" => 	"16", 	"ft_height" => 	"32",

		"icon_directory" => 	"", 	"icon_erase" => 	"",
		"icon_ok" => 	"", 	"icon_ko" => 	"",
		"icon_left" => 	"", 	"icon_right" => 	"", 	"icon_top" => 	"", 	"icon_bottom" => 	"",
		"icon_question" => 	"", 	"icon_notification" => 	"",
		"transparent_8x8" => 	"",
		"icon_width" => 	"32",
		"icon_height" => 	"32",

		"h1_font_family"	=> "",	"h1_font_size"	=> "",	"h1_txt_col"	=> "",	"h1_special"	=> "",
		"h2_font_family"	=> "",	"h2_font_size"	=> "",	"h2_txt_col"	=> "",	"h2_special"	=> "",
		"h3_font_family"	=> "",	"h3_font_size"	=> "",	"h3_txt_col"	=> "",	"h3_special"	=> "",
		"h4_font_family"	=> "",	"h4_font_size"	=> "",	"h4_txt_col"	=> "",	"h4_special"	=> "",
		"h5_font_family"	=> "",	"h5_font_size"	=> "",	"h5_txt_col"	=> "",	"h5_special"	=> "",
		"h6_font_family"	=> "",	"h6_font_size"	=> "",	"h6_txt_col"	=> "",	"h6_special"	=> "",
		"h7_font_family"	=> "",	"h7_font_size"	=> "",	"h7_txt_col"	=> "",	"h7_special"	=> "",

		"page_selector"				=> "display:inline-block; background-color:#80808030; border-radius:0.1cm; border:solid 1px #00000080; padding:0.2cm 0.35cm; margin:0.1cm;",
		"page_selector_highlight"	=> "display:inline-block; background-color:#80808080; border-radius:0.1cm; border:solid 1px #00000080; padding:0.2cm 0.35cm; margin:0.1cm;",
		// end new style
		// ***************************************************************************

		"level"					=> 0,
		"genre"					=> 1,
		"animmation"			=> "fgts",
		"graphic"				=> "",
		"text"					=> "",

		"dock_smenu"			=> "top-left",
		"target_dock"			=> "top-right",
		"dock_decal_x"			=> 0,
		"dock_decal_y"			=> 0,

		"div_width"				=> 0,
		"div_height"			=> 0,

		"display_icons"			=> "no",
		"icons_width"			=> 16,
		"icons_height"			=> 16,
		"icon_directory_01"		=> "",
		"icon_directory_02"		=> "",
		"icon_file_01"			=> "",
		"icon_file_02"			=> "",
		"icon_special_01"		=> "",
		"icon_special_02"		=> "",

		"icone_dim_x"			=> 48,
		"icone_dim_y"			=> 48,

		"a_line_height"			=> 14,
	);
	$a['listVars'] = array(
		"10" => array(
			"id",
			"level",
			"directory",
			"graphic",
			"text",
			"genre",
			"animation",
			"a_line_height",
			"display_icons",
			"div_height",
			"div_width",
			"target_dock",
			"dock_decal_x",
			"dock_decal_y",
			"dock_smenu",
			"icon_file_01",
			"icon_file_02",
			"icon_directory_01",
			"icon_directory_02",
			"icon_special_01",
			"icon_special_02",
			"icons_width",
			"icons_height"
		),
		"20" => array(
			// "repertoire",
			"directory",
			"txt_fonte",			"txt_fonte_size_min",		"txt_fonte_size_max",
			"txt_fonte_size",
			"txt_fonte_dl_nom",		"txt_fonte_dl_url",
			"p_txt_indent",			"p_txt_align",									"p_special",

			"main_unit",			"txt_font_unit",
			"txt_col",				"txt_highlight_col",		"txt_bg_col",		"txt_titre_col",
			"txt_ok_col",			"txt_avert_col",			"txt_erreur_col",	"txt_fade_col",
			"txt_l_01_display",		"txt_l_01_size",			"txt_l_01_weight",	"txt_l_01_decoration",

			"txt_l_01_margin_top",	"txt_l_01_margin_bottom",	"txt_l_01_margin_left",		"txt_l_01_margin_right",
			"txt_l_01_hover_size",	"txt_l_01_hover_weight",	"txt_l_01_hover_decoration",
			"txt_l_01_fg_col",		"txt_l_01_fg_hover_col",	"txt_l_01_fg_active_col",	"txt_l_01_fg_visite_col",
			"txt_l_01_bg_col",		"txt_l_01_bg_hover_col",	"txt_l_01_bg_active_col",	"txt_l_01_bg_visite_col",

			"txt_l_td_display",		"txt_l_td_size",			"txt_l_td_weight",
			"txt_l_td_decoration",
			"txt_l_td_margin_top",	"txt_l_td_margin_bottom",	"txt_l_td_margin_left",			"txt_l_td_margin_right",
			"txt_l_td_hover_size",	"txt_l_td_hover_weight",	"txt_l_td_hover_decoration",
			"txt_l_td_fg_col",		"txt_l_td_fg_hover_col",	"txt_l_td_fg_active_col",		"txt_l_td_fg_visite_col",
			"txt_l_td_bg_col",		"txt_l_td_bg_hover_col",	"txt_l_td_bg_active_col",		"txt_l_td_bg_visite_col",

			"txt_input1_fg_col",	"txt_input1_bg_col",
			"txt_input2_fg_col",	"txt_input2_bg_col",
			"txt_input1_td_fg_col",	"txt_input1_td_bg_col",
			"txt_input2_td_fg_col",	"txt_input2_td_bg_col",

			"code_font",		"code_fg_col",			"code_bg_col",
			"code_mrg_top",		"code_mrg_bottom",		"code_mrg_left",				"code_mrg_right",
			"code_pad_top",		"code_pad_bottom",		"code_pad_left",				"code_pad_right",
			"code_special",

			"table_rules",
			"t01_txt_col",
			"t01_caption_fg_col",
			"t01_caption_bg_col",
			"t01_caption_special",
			"t01_tr_bg_col",
			"t01_tr_bg_odd_col",
			"t01_tr_bg_even_col",
			"t01_tr_bg_hover_col",
			"t01_tr_special",
			"t01_td_bg_odd_col",
			"t01_td_bg_even_col",
			"t01_td_special",

			"ca_txt_col",			"ca_txt_bg_col",
			"cb_txt_col",			"cb_txt_bg_col",
			"cc_txt_col",			"cc_txt_bg_col",
			"cd_txt_col",			"cd_txt_bg_col",
			"cta_txt_col",			"cta_txt_bg_col",
			"ctb_txt_col",			"ctb_txt_bg_col",
			"csa_txt_col",			"csa_txt_bg_col",
			"csb_txt_col",			"csb_txt_bg_col",
			"co_txt_col",			"co_txt_bg_col",

			"s1_txt_col",			"s2_txt_col",			"s3_txt_col",
			"s1_txt_weight",		"s2_txt_weight",		"s3_txt_weight",
			"s1_txt_shadow",		"s2_txt_shadow",		"s3_txt_shadow",

			"s1_txt_hover_col",		"s2_txt_hover_col",		"s3_txt_hover_col",
			"s1_txt_hover_weight",	"s2_txt_hover_weight",	"s3_txt_hover_weight",
			"s1_txt_hover_shadow",	"s2_txt_hover_shadow",	"s3_txt_hover_shadow",

			"tab_up_txt_col",		"tab_up_txt_bg_col",	"tab_up_txt_weight",	"tab_up_txt_shadow",
			"tab_down_txt_col",		"tab_down_txt_bg_col",	"tab_down_txt_weight",	"tab_down_txt_shadow",
			"tab_hover_txt_col",	"tab_hover_txt_bg_col",	"tab_hover_txt_weight",	"tab_hover_txt_shadow",

			"p_mrg_top",			"p_mrg_bottom",		"p_mrg_left",	"p_mrg_right",
			"p_pad_top",			"p_pad_bottom",		"p_pad_left",	"p_pad_right",
			"ft1",					"ft2",				"ft3",
			"ft1_x",				"ft3_x",			"ft_y",

			"bgca",	"bgcb",	"bgcc",	"bgcd",	"bgcta",	"bgctb",	"bgcsa",	"bgcsb",	"bgco",
			"transparent_8x8",
			"icone_dim_x",		"icone_dim_y",


			// ***************************************************************************
			// new style

			"main_unit", 				"txt_font_unit",
			"txt_font_family", 			"txt_font_size",
			"txt_font_name_normal", 	"txt_font_filename_normal",
			"txt_font_name_bold", 		"txt_font_filename_bold",
			"txt_font_name_italic", 	"txt_font_filename_italic",

			"p_txt_indent", 	"p_txt_align",								"p_special",
			"p_mrg_top", 		"p_mrg_bottom", 		"p_mrg_left", 		"p_mrg_right",
			"p_pad_top", 		"p_pad_bottom", 		"p_pad_left", 		"p_pad_right",
			"p_special",

			"txt_col", 			"txt_highlight_col", 	"txt_bg_col", 			"txt_title_col",
			"txt_ok_col", 		"txt_warning_col", 		"txt_error_col", 		"txt_fade_col",

			"a_fg_col", 			"a_bg_col", 			"a_decoration", 		"a_special",
			"a_hover_fg_col", 		"a_hover_bg_col", 		"a_hover_decoration", 	"a_hover_special",
			"a_active_fg_col", 		"a_active_bg_col", 		"a_active_decoration", 	"a_active_special",
			"a_visited_fg_col", 	"a_visited_bg_col", 	"a_visited_decoration", "a_visited_special",

			"table_rules",
			"t01_caption_fg_col", 	"t01_caption_bg_col", 		"t01_caption_special",
			"t01_txt_col",
			"t01_tr_bg_col", 		"t01_td_bg_odd_col",
			"t01_tr_bg_odd_col", 	"t01_td_bg_even_col",
			"t01_tr_bg_even_col", 	"t01_td_special",
			"t01_tr_bg_hover_col",
			"t01_tr_special",
			"t01_legend_txt_col", 	"t01_legend_bg_col", 	"t01_legend_special",

			"a_fg_col", 			"a_bg_col", 			"a_decoration", 			"a_display",
			"a_hover_fg_col", 		"a_hover_bg_col", 		"a_hover_decoration", 		"a_hover_display",
			"a_active_fg_col", 		"a_active_bg_col", 		"a_active_decoration", 		"a_active_display",
			"a_visited_fg_col", 	"a_visited_bg_col", 	"a_visited_decoration", 	"a_visited_display",

			"td_a_fg_col", 			"td_a_bg_col", 			"td_a_decoration", 			"td_a_display",
			"td_a_hover_fg_col", 	"td_a_hover_bg_col", 	"td_a_hover_decoration", 	"td_a_hover_display",
			"td_a_active_fg_col", 	"td_a_active_bg_col", 	"td_a_active_decoration", 	"td_a_active_display",
			"td_a_visited_fg_col", 	"td_a_visited_bg_col", 	"td_a_visited_decoration", 	"td_a_visited_display",

			"code_font", 			"code_fg_col", 			"code_bg_col",
			"code_mrg_top", 		"code_mrg_bottom", 		"code_mrg_left", 		"code_mrg_right",
			"code_pad_top", 		"code_pad_bottom", 		"code_pad_left", 		"code_pad_right",
			"code_special",

			"input_fg_col", 		"input_bg_col", 		"input_special",
			"td_input_fg_col", 		"td_input_bg_col", 		"td_input_special",

			"s1_txt_col", 			"s2_txt_col", 				"s3_txt_col",
			"s1_txt_weight", 		"s2_txt_weight", 			"s3_txt_weight",
			"s1_txt_special", 		"s2_txt_special", 			"s2_txt_special",
			"s1_txt_hover_col", 	"s2_txt_hover_col", 		"s3_txt_hover_col",
			"s1_txt_hover_weight", 	"s2_txt_hover_weight", 		"s3_txt_hover_weight",
			"s1_txt_hover_special", "s2_txt_hover_special", 	"s3_txt_hover_special",

			"s1_01_width", 		"s1_01_height", 	"s1_03_width",
			"s1_n01", 			"s1_n02", 			"s1_n03",
			"s1_h01", 			"s1_h02", 			"s1_h03",

			"s2_01_width", 		"s2_01_height", "s2_03_width",
			"s2_n01", 			"s2_n02", 		"s2_n03",
			"s2_h01", 			"s2_h02", 		"s2_h03",

			"s3_01_width", 	"s3_01_height", 	"s3_03_width",
			"s3_n01", 		"s3_n02", 			"s3_n03",
			"s3_h01", 		"s3_h02", 			"s3_h03",

			"s1_a", 		"s1_b", 	"s1_c",
			"s2_a", 		"s2_b", 	"s2_c",
			"s3_a", 		"s3_b", 	"s3_c",
			"s1_offset_x", 	"s1_offset_y",
			"s2_offset_x", 	"s2_offset_y",
			"s3_offset_x", 	"s3_offset_y",

			"tab_a", 	"tab_b", 	"tab_c",
			"tab_offset_x", 	"tab_offset_y",

			"tab_up_txt_col", 		"tab_up_txt_bg_col", 		"tab_up_txt_weight", 		"tab_up_txt_special",
			"tab_down_txt_col", 	"tab_down_txt_bg_col", 		"tab_down_txt_weight", 		"tab_down_txt_special",
			"tab_hover_txt_col", 	"tab_hover_txt_bg_col", 	"tab_hover_txt_weight", 	"tab_hover_txt_special",
			"tab_height", 			"tab_a_width", 				"tab_c_width",
			// "tab_down_a", 		"tab_down_b", 				"tab_down_c",
			// "tab_up_a", 			"tab_up_b", 				"tab_up_c",
			// "tab_hover_a", 		"tab_hover_b", 				"tab_hover_c",
			"tab_frame_bg_col",		"tab_frame_bg_img",

			"ft2_font", 		"ft2_font_size", 		"ft2_fg_col", 		"ft2_special",
			"ft1_bg", 			"ft2_bg", 				"ft3_bg",
			"ft1_width", 		"ft3_width", 			"ft_height",

			"icon_directory", 	"icon_erase",
			"icon_ok", 			"icon_nok",
			"icon_left", 		"icon_right", 			"icon_top", 		"icon_bottom",
			"icon_question", 	"icon_notification",
			"transparent_8x8",
			"icon_width",
			"icon_height",

			"h1_font_family",	"h1_font_size",	"h1_txt_col",	"h1_special",
			"h2_font_family",	"h2_font_size",	"h2_txt_col",	"h2_special",
			"h3_font_family",	"h3_font_size",	"h3_txt_col",	"h3_special",
			"h4_font_family",	"h4_font_size",	"h4_txt_col",	"h4_special",
			"h5_font_family",	"h5_font_size",	"h5_txt_col",	"h5_special",
			"h6_font_family",	"h6_font_size",	"h6_txt_col",	"h6_special",
			"h7_font_family",	"h7_font_size",	"h7_txt_col",	"h7_special",

			"page_selector",
			"page_selector_highlight",

			// end new style
			// ***************************************************************************

		),
		"30" => array(
			"background_color",
			"background_url",
			"border_top_width", 		"border_top_color",			"border_top_style",			"padding_top",		"margin_top",
			"border_bottom_width",		"border_bottom_color",		"border_bottom_style", 		"padding_bottom",	"margin_bottom",
			"border_left_width", 		"border_left_color",		"border_left_style", 		"padding_left",		"margin_left",
			"border_right_width", 		"border_right_color",		"border_right_style", 		"padding_right",	"margin_right",
			"border_all_width",			"border_all_color",			"border_all_style", 		"padding_all",		"margin_all"
		),
		"40" => array(
			// "repertoire",
			"directory",
			"ex11",	"ex12",	"ex13",
			"ex21",	"ex22",	"ex23",
			"ex31",	"ex32",	"ex33",
			"ex11_x",	"ex11_y",	"ex11_bgp",
			"ex12_x",	"ex12_y",	"ex12_bgp",
			"ex13_x",	"ex13_y",	"ex13_bgp",
			"ex21_x",	"ex21_y",	"ex21_bgp",
			"ex22_x",	"ex22_y",	"ex22_bgp",
			"ex23_x",	"ex23_y",	"ex23_bgp",
			"ex31_x",	"ex31_y",	"ex31_bgp",
			"ex32_x",	"ex32_y",	"ex32_bgp",
			"ex33_x",	"ex33_y",	"ex33_bgp"
		),
		"50" => array(
			// "repertoire",
			"directory",
			"ex11",	"ex12",	"ex13",	"ex14",	"ex15",
			"ex21",	"ex22",					"ex25",
			"ex31",							"ex35",
			"ex41",							"ex45",
			"ex51",	"ex52",	"ex53",	"ex54",	"ex55",
			"ex11_x",	"ex11_y",		"ex11_bgp",
			"ex12_x",	"ex12_y",		"ex12_bgp",
			"ex13_x",	"ex13_y",		"ex13_bgp",
			"ex14_x",	"ex14_y",		"ex14_bgp",
			"ex15_x",	"ex15_y",		"ex15_bgp",
			"ex21_x",	"ex21_y",		"ex21_bgp",
			"ex22_x",	"ex22_y",		"ex22_bgp",
			"ex25_x",	"ex25_y",		"ex25_bgp",
			"ex31_x",	"ex31_y",		"ex31_bgp",
			"ex35_x",	"ex35_y",		"ex35_bgp",
			"ex41_x",	"ex41_y",		"ex41_bgp",
			"ex45_x",	"ex45_y",		"ex45_bgp",
			"ex51_x",	"ex51_y",		"ex51_bgp",
			"ex52_x",	"ex52_y",		"ex52_bgp",
			"ex53_x",	"ex53_y",		"ex53_bgp",
			"ex54_x",	"ex54_y",		"ex54_bgp",
			"ex55_x",	"ex55_y",		"ex55_bgp"
		),
		"60" => array(
			// "repertoire",
			"directory",
			"ex11",	"ex12",	"ex13",	"ex14",	"ex15",
			"ex21",	"ex22",					"ex25",
			"ex31",							"ex35",
			"ex41",							"ex45",
			"ex51",	"ex52",	"ex53",	"ex54",	"ex55",
			"ex11_x",	"ex11_y",		"ex11_bgp",
			"ex12_x",	"ex12_y",		"ex12_bgp",
			"ex13_x",	"ex13_y",		"ex13_bgp",
			"ex14_x",	"ex14_y",		"ex14_bgp",
			"ex15_x",	"ex15_y",		"ex15_bgp",
			"ex21_x",	"ex21_y",		"ex21_bgp",
			"ex22_x",	"ex22_y",		"ex22_bgp",
			"ex25_x",	"ex25_y",		"ex25_bgp",
			"ex31_x",	"ex31_y",		"ex31_bgp",
			"ex35_x",	"ex35_y",		"ex35_bgp",
			"ex41_x",	"ex41_y",		"ex41_bgp",
			"ex45_x",	"ex45_y",		"ex45_bgp",
			"ex51_x",	"ex51_y",		"ex51_bgp",
			"ex52_x",	"ex52_y",		"ex52_bgp",
			"ex53_x",	"ex53_y",		"ex53_bgp",
			"ex54_x",	"ex54_y",		"ex54_bgp",
			"ex55_x",	"ex55_y",		"ex55_bgp",

			"in11",	"in12",	"in13",	"in14",	"in15",
			"in21",							"in25",
			"in31",							"in35",
			"in41",							"in45",
			"in51",	"in52",	"in53",	"in54",	"in55",
			"in11_x",	"in11_y",		"in11_bgp",
			"in12_x",	"in12_y",		"in12_bgp",
			"in13_x",	"in13_y",		"in13_bgp",
			"in14_x",	"in14_y",		"in14_bgp",
			"in15_x",	"in15_y",		"in15_bgp",
			"in21_x",	"in21_y",		"in21_bgp",
			"in25_x",	"in25_y",		"in25_bgp",
			"in31_x",	"in31_y",		"in31_bgp",
			"in35_x",	"in35_y",		"in35_bgp",
			"in41_x",	"in41_y",		"in41_bgp",
			"in45_x",	"in45_y",		"in45_bgp",
			"in51_x",	"in51_y",		"in51_bgp",
			"in52_x",	"in52_y",		"in52_bgp",
			"in53_x",	"in53_y",		"in53_bgp",
			"in54_x",	"in54_y",		"in54_bgp",
			"in55_x",	"in55_y",		"in55_bgp",

			"in11_e",	"in12_e",	"in13_e",	"in14_e",	"in15_e",
			"in21_e",										"in25_e",
			"in31_e",										"in35_e",
			"in41_e",										"in45_e",
			"in51_e",	"in52_e",	"in53_e",	"in54_e",	"in55_e"
		),
	);
};

self::$InitTable['article_config'] = function (&$a) {
	$a['params'] = array(
		"id" => "",
		"name" => "New ArticleConfig",
		"menu_type" => "MENU_SELECT",
		"menu_style" => "FLOAT",
		"menu_float_position" => "RIGHT",
		"menu_float_size_x" => 0,
		"menu_float_size_y" => 0,
		"menu_occurence" => "TOP",
		"show_info_parution" => "ON",
		"show_info_modification" => "ON",
		"ws_id" => $a['Context']['ws_id']
	);
	$a['params']['montre_info_parution']		= &$a['params']['show_info_parution'];
	$a['params']['montre_info_modification']	= &$a['params']['show_info_modification'];
	$a['params']['menu_float_taille_x']			= &$a['params']['menu_float_size_x'];
	$a['params']['menu_float_taille_y']			= &$a['params']['menu_float_size_y'];
};


self::$InitTable['document'] = function (&$a) {
	$a['params'] = array(
		"id"				=> "",
		"name"				=> "",
		"type"				=> "MIXED",
		"origin"			=> $a['Context']['ws_id'],
		"creator"			=> $a['Initiator']['db_login'],
		"creation_date"		=> time(),
		"validation"		=> "NO",
		"validator"			=> $a['Initiator']['db_login'],
		"validation_date"	=> 0,
		"content"			=> "",
		"from_site"			=> "",
		"with_site"			=> "",
		"modification"		=> "NO",
		"to_article"		=> "",
	);
};

self::$InitTable['group'] = function (&$a) {
	$a['params'] = array(
		"name" => "NewGroup",
		"parent" => "reader",
		"tag" => 1,
		"title" => "New group",
		"file" => "media/img/universal/icon_dev_001.jpg",
		"desc" => "New group"
	);
};

self::$InitTable['keyword'] = function (&$a) {
	$a['params'] = array(
		"name"		=> "nouveau_keyword",
		"id"		=> "",
		"state"		=> "ONLINE",
		"article"	=> 0,
		"site"	 	=> $a['Context']['ws_id'],
		"string"	=> "",
		"count"		=> 1,
		"type"		=> "TOOLTIP",
		"data" 		=> "?",
	);
};




self::$InitTable['language'] = function (&$a) {
	$a['params'] = array(
		"name"				=> "",
		"to_website"		=> "",
	);
};



self::$InitTable['layout'] = function (&$a) {
	$a['params'] = array(
		"id"				=> "",
		"layout_theme_id"	=> "",
		"name"				=> "New Layout",
		"title"				=> "New Layout",
		"generic_name"		=> "New Layout",
		"desc"				=> "",
		"layout_file"		=> "default.lyt.html",
		"to_theme"			=> "",
		"default"			=> "NO",
	);
	$a['params']['description'] = &$a['params']['desc'];
	$a['params']['filename'] = &$a['params']['layout_file'];
};

self::$InitTable['layout_file'] = function (&$a) {
	$a['params'] = array(
		'id'			=> 0,
		'name'			=> "New Layout_file",
		'generic_name'	=> "NewLyt",
		'filename'		=> "Layout_FileName.lyt.html",
		'desc'			=> "Desc",
	);
	$a['params']['description'] = &$a['params']['desc'];
};


self::$InitTable['log'] = function (&$a) {
	$a['params'] = array(
		"initiator"	=> "",
		"action"	=> "",
		"signal"	=> "",
		"msgCode"	=> "",
		"text"		=> "",
	);
	$a['params']['i']	= &$a['params']['initiator'];
	$a['params']['a']	= &$a['params']['action'];
	$a['params']['s']	= &$a['params']['signal'];
	$a['params']['m']	= &$a['params']['msgCode'];
	$a['params']['t']	= &$a['params']['text'];
};


self::$InitTable['menu'] = function (&$a) {
	$a['params'] = array(
		"id"			=> "",
		"name"			=> "New menu",
		"title"			=> "New menu",
		"desc"			=> "New menu",
		"type"			=> "ARTICLE",
		"ws_id"			=> $a['Context']['ws_id'],
		"lang"			=> "eng",
		"deadline"		=> "",
		"state"			=> "OFFLINE",
		"parent"		=> 0,
		"position"		=> "",
		"permission"	=> "group_default_read_permission",
		"role"			=> "NO",
		"first_doc"		=> "NO",
		"article"		=> 1,
		"slug"			=> "",
		"last_modif"	=> time(),
	);

	$a['params']['deadline_id']	= &$a['params']['deadline'];
};


self::$InitTable['module'] = function (&$a) {
	$a['params'] = array(
		"id"					=> "",
		"name"					=> "New Module",
		"classname"				=> "NewModuleClass",
		"deco"					=> "ON",
		"deco_nbr"				=> "1",
		"deco_txt_default"		=> "3",
		"title"					=> "New module",
		"directory"				=> "NA",
		"file"					=> "NA",
		"type"					=> 1,
		"desc"					=> "New module",
		"permission"			=> "group_default_read_permission",
		"group_allowed_to_see"	=> 1,
		"group_allowed_to_use"	=> 1,
		"state"					=> "ONLINE",
		"position"				=> 1,
		"adm_control"			=> "NO",
		"container_name"		=> "",
		"container_style"		=> "",
		"execution"				=> "DURING",
	);
};

self::$InitTable['permission'] = function (&$a) {
	$a['params'] = array(
		"id"				=> "",
		"state" 			=> "enabled",
		"name" 				=> "defaultPermission",
		"affinity"			=> "user",
		"object_type"		=> "module",
		"desc"				=> "defaultPermission description",
		"level"				=> "read",

	);
	$a['params']['description'] = &$a['params']['desc'];
};

self::$InitTable['group_permission'] = function (&$a) {
	$a['params'] = array(
		"id"						=> "",
		"name"						=> "",
		"to_group"					=> "",
		"to_all_groups"				=> "no",
	);
};

self::$InitTable['user_permission'] = function (&$a) {
	$a['params'] = array(
		"id"						=> "",
		"name"						=> "",
		"to_user"					=> "",
		"to_all_users"				=> "no",
	);
};


self::$InitTable['tag'] = function (&$a) {
	$a['params'] = array(
		"id"		=> "",
		"name"		=> "New Tag",
		"html"		=> "",
		"site"		=> $a['Context']['ws_id'],
		"article"	=> "",
	);
	$a['params']['to_article'] = &$a['params']['article'];
};

self::$InitTable['theme'] = function (&$a) {
	$a['params'] = array(
		"id"	=> "",
		"name"	=> "New Layout",
		"title"	=> "Nouveau theme",
		"desc"	=> "Nouveau theme",
		"date"	=> time(),
		"state" => "ONLINE",
	);
};



self::$InitTable['theme_definition'] = function (&$a) {
	$a['params'] = array(
		'id'			=> 0,
		'for_theme'		=> "",
		'fk_theme_id'	=> 0,
		'type'			=> "string",
		'name'			=> "bg",
		'number'		=> 0,
		'string'		=> "bg.png",
	);
};

self::$InitTable['translation'] = function (&$a) {
	$a['params'] = array(
		"id"					=> "",
		"lang"					=> "eng",
		"package"				=> "initial",
		"name"					=> "default_err",
		"text"					=> "something went wrong",

	);
};
self::$InitTable['user'] = function (&$a) {
	$a['params'] = array(
		"id"					=> "",
		"name"					=> "New user",
		"login"					=> "NA",
		"password"				=> "NA",
		"date_inscription"		=> time(),
		"status"				=> "ACTIVE",
		"role_function"			=> "PUBLIC",
		"forum_access"			=> "ON",

		"email"					=> "NA",
		"msn"					=> "NA",
		"aim"					=> "NA",
		"icq"					=> "NA",
		"yim"					=> "NA",
		"website"				=> "NA",

		"perso_name"			=> "NA",
		"perso_copuntry"		=> "NA",
		"perso_town"			=> "NA",
		"perso_occupation"		=> "NA",
		"perso_interest"		=> "NA",

		"last_visit"			=> 0,
		"last_ip"				=> "0.0.0.0",
		"timezone"				=> 1,
		"lang"					=> 0,

		"pref_theme"						=> "",
		"pref_newsletter"					=> "yes",
		"pref_show_email"					=> "no",
		"pref_show_status_online"			=> "no",
		"pref_notification_reponse_forum"	=> "yes",
		"pref_notification_new_pm"			=> "yes",
		"pref_allow_bbcode"					=> "yes",
		"pref_allow_html"					=> "yes",
		"pref_allow_smilies"				=> "yes",
		"image_avatar"						=> "",
		"admin_comment"						=> "",

		"join_group" 						=> 0,
		"initial_group"						=> 0,
	);
};

self::$InitTable['website'] = function (&$a) {
	$a['params'] = array(
		"ws_id"				=> "",
		"name"				=> "New Website",
		"short"				=> "New Website",
		"lang"				=> "eng",
		"lang_select"		=> "YES",
		"theme_id"			=> 1,
		"theme"				=> "",
		"title"				=> "New Website",
		"home"				=> "www.newwebsite.com",
		"directory"			=> "NA",
		"info_debug"		=> "3",
		"stylesheet"		=> "DYNAMIC",
		"state"				=> "ONLINE",
		"gal_mode"			=> "BASE",
		"gal_file_tag"		=> ".thumbnail",
		"gal_quality"		=> "40",
		"gal_x"				=> "160",
		"gal_y"				=> "160",
		"gal_border"		=> "3",
		"ma_diff"			=> "YES",
		"del_lang"			=> "",
		"group"				=> "",
		"user"				=> "",
		"password"			=> "",
		"add_lang"			=> "",
	);
	// 	$a['params']['website'] = $a['params']['site'];
};


self::$InitTable['variable'] = function (&$a) {
	$a['params'] = array(
		"id"					=> "",
		"name"					=> "New variable",
		"value"					=> "1",
	);
};


//--------------------------------------------------------------------------------
// For the show command
// TODO what??????
self::$InitTable['articles']	= self::$InitTable['article'];
self::$InitTable['deadlines']	= self::$InitTable['deadline'];
self::$InitTable['decorations'] = self::$InitTable['decoration'];
self::$InitTable['definition']  = self::$InitTable['definition'];
self::$InitTable['documents']	= self::$InitTable['document'];
self::$InitTable['groups']		= self::$InitTable['group'];
self::$InitTable['keywords']	= self::$InitTable['keyword'];
self::$InitTable['menus']		= self::$InitTable['menu'];
self::$InitTable['modules']		= self::$InitTable['module'];
self::$InitTable['users']		= self::$InitTable['user'];
self::$InitTable['websites']	= self::$InitTable['website'];
