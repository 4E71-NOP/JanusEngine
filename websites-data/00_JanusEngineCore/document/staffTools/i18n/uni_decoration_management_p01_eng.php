<?php
// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"eng" => array(
			"invite1"		=> "This part will allow you to manage decoration.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "State",
			"col_3_txt"		=> "Type",
			"tabTxt1"		=> "Informations",
			"type"			=> array(
				10	=>	"Menu",
				20	=>	"Caligraphr",
				30	=>	"1_DIV",
				40	=>	"Elegance",
				50	=>	"Exquisite",
				60	=>	"Elysion",
			),
			"state"			=> array(
				0	=> "Offline",
				1	=> "Online",
				2	=> "Deleted",
			),
			"pageSelectorQueryLike"		=>	"Filter with",
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
		),
	)
);
?>