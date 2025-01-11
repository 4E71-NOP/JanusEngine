<?php
// --------------------------------------------------------------------------------------------
// THE DEFINE SECTION IS SET HERE AND IT IS FINE.
// If you're slow : Meaning, don't 'define' anyhere else!

/* @var $application String */

define("JANUS_ENGINE_CORE_TITLE", ("Janus Engine Core"));
define("JANUS_ENGINE_CORE_SHORT", ("JnsEngCore"));
define("JANUS_ENGINE_CORE_SCRIPT_DIR", ("00_JanusEngineCore"));

define("DEFAULT_ERROR_REPORTING", (E_ALL ^ E_WARNING ^ E_NOTICE));
define("DEFAULT_SITE_ID", "JanusEngine");

define("USER_ACTION_SIGN_IN", "singIn");
define("USER_ACTION_DISCONNECT", "disconnect");
define("ANONYMOUS_USER_NAME", "anonymous");

define("DOCUMENT_TAG_BEGIN", "/*JanusEngine-Content-Begin*/");
define("DOCUMENT_TAG_BEGIN_OFFSET", strlen(DOCUMENT_TAG_BEGIN) + 1);
define("DOCUMENT_TAG_END", "/*JanusEngine-Content-End*/");


// --------------------------------------------------------------------------------------------
// Directories 
define("_EXTENSIONS_DIRECTORY_", "extensions/");
define("_CURRENT_DIRECTORY_", "current/");
define("_LAYOUTS_DIRECTORY_", "layouts/");
define("_MEDIA_DIRECTORY_", "media/");
define("_MODULES_DIRECTORY_", "modules/");
define("_STYLESHEETS_DIRECTORY_", "stylesheets/");
define("_WEBSITESDATA_DIRECTORY_", "websites-data/");

define("_UTILITY_DIRECTORY_", "current/engine/utility/");
define("_SDDM_DIRECTORY_", "current/engine/sddm/");
define("_ENTITY_DIRECTORY_", "current/engine/entity/");

// --------------------------------------------------------------------------------------------
// Logs
define("LOGLEVEL_DEBUG_LVL0",	6); // Byte by byte...
define("LOGLEVEL_BREAKPOINT",	5); // You definitely like to read or you're a crappy developper
define("LOGLEVEL_STATEMENT",	4); // Every statements like "I'm the <class::method> and i recieved this data"
define("LOGLEVEL_INFORMATION",	3); // Moaar
define("LOGLEVEL_WARNING",		2); // More
define("LOGLEVEL_ERROR",		1); // Usual level
define("LOGLEVEL_NO_LOG",		0); // You don't like to read. Or you don't wanna polute your server.

// define ( "LOG_TARGET", "both" ); // none, both, internal, system

// define ( "INSTALL_LOG_TARGET", "system" );			//DEPRECATED SOON
// define ( "FILESELECTOR_LOG_TARGET", "system" );			//DEPRECATED SOON

// --------------------------------------------------------------------------------------------
// Object SendToDb mode
define("OBJECT_SENDTODB_MODE_DEFAULT", 0);
define("OBJECT_SENDTODB_MODE_INSERTONLY", 1);
define("OBJECT_SENDTODB_MODE_UPDATEONLY", 2);


// log dedicated to debug and users
// define ("INTERNAL_LOG_LEVEL" , LOGLEVEL_ERROR);
$ll = 0;
switch ($application) {
	case 'install':
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_WARNING;

		$llvsl = LOGLEVEL_BREAKPOINT;
		$llvil = LOGLEVEL_BREAKPOINT;
		break;
	case 'monitor':
		$llvsl = LOGLEVEL_ERROR;
		$llvil = LOGLEVEL_ERROR;

		// $llvsl = LOGLEVEL_WARNING;
		// $llvil = LOGLEVEL_WARNING;

		// $llvsl = LOGLEVEL_BREAKPOINT;
		// $llvil = LOGLEVEL_BREAKPOINT;
		break;
	case 'website':
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_WARNING;

		$llvsl = LOGLEVEL_BREAKPOINT;
		$llvil = LOGLEVEL_BREAKPOINT;
		break;
	case 'FileSelector':
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_BREAKPOINT;

		// $llvsl = LOGLEVEL_BREAKPOINT;
		// $llvil = LOGLEVEL_BREAKPOINT;
		break;
	default:
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_BREAKPOINT;
		break;
}
define("SYSTEM_LOG_LEVEL", $llvsl);
define("INTERNAL_LOG_LEVEL", $llvil);

define("LOG_CONFIG_DISPLAY_ERROR", 1);
define("LOG_CONFIG_LOG_ERRORS", 'On');
define("LOG_CONFIG_ERROR_LOG", "/var/log/apache2/error.log ");

unset(
	$ll,
	$llvsl,
	$llvil,
);


// --------------------------------------------------------------------------------------------
// URL elements
define("_JNSENGLINKURLTAG_", "JnsEngLink");

// --------------------------------------------------------------------------------------------
// Option menu arrays 
// The fields have dynamic name in case we use combo box that require different entry names etc...
define("_MENU_OPTION_DB_",			"db");
define("_MENU_OPTION_SELECTED_",	"s");
define("_MENU_OPTION_TXT_",		"t");

define("_NULL_", 0);
define("_NO_", 0);
define("_OFF_", 0);
define("_OFFLINE_", 0);
define("_DISABLED_", 0);
define("_STATIC_", 0);
define("_DURING_", 0);
define("_NOT_VALIDATED_", 0);

define("_YES_", 1);
define("_ON_", 1);
define("_ONLINE_", 1);
define("_ENABLED_", 1);
define("_DYNAMIC_", 1);
define("_PRIVATE_", 1);
define("_BEFORE_", 1);
define("_VALIDATED_", 1);

define("_DELETED_", 2);
define("_AFTER_", 2);
define("_PUBLIC_", 2);

define("_FORBIDDEN_", 0);
define("_READ_", 1);
define("_WRITE_", 2);

define("_ANONYMOUS_", 0);
define("_READER_", 1);
define("_STAFF_", 2);
define("_SENIOR_STAFF_", 3);

// --------------------------------------------------------------------------------------------
// Class names
define("_CLASS_TABLE01_",			"_Table01");
define("_CLASS_TABLE_STD_",		"_TableStd");
define("_CLASS_TXT_OK_",			"_ok");
define("_CLASS_TXT_WARNING_",		"_warning");
define("_CLASS_TXT_ERROR_",		"_error");
define("_CLASS_TXT_FADE_",		"_fade");
define("_CLASS_TXT_HIGHLIGHT_",	"_highlight");
define("_CLASS_TBL_LGND_TOP_",	"_TblLgndTop");
define("_CLASS_TBL_LGND_BOTTOM_", "_TblLgndBottom");
define("_CLASS_TBL_LGND_LEFT_",	"_TblLgndLeft");
define("_CLASS_TBL_LGND_RIGHT_",	"_TblLgndRight");

define("_CLASS_ADM_CTRL_SWITCH_",			"div_AdminControlSwitch");
define("_CLASS_ADM_CTRL_PANEL_",			"div_AdminControlPanel");
define("_CLASS_FILE_SELECTOR_CONTAINER_",	"FileSelectorContainer");
define("_CLASS_FILE_SELECTOR_",			"FileSelector");

// --------------------------------------------------------------------------------------------
// Behavior
define("_ADMIN_PAGE_TABLE_DEFAULT_NBR_LINE_",			10);
