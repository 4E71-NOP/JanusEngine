<?php 
// --------------------------------------------------------------------------------------------
// THE DEFINE SECTION IS SET HERE AND IT IS FINE HERE. 
// If you're slow : Meaning don't define anyhere else!
define ("defaultSiteId" , 2);

define ("userActionSingIn" , "singIn");
define ("userActionDisconnect" , "disconnect");
define ("anonymousUserName" , "anonymous");

// Logs
define("loglevelBreakpoint",5);			// You definitely like to read or you're a crappy programmer
define("loglevelStatement",4);			// Every statements like i'm the <class::method>  and i recieved this data
define("loglevelInformation",3);		// Moaar
define("loglevelWarning",2);			// More
define("loglevelError",1);				// Usual level
define("logLevelNoLog",0);				// You don't like to read. Or you don't wanna polute your server.

define ("logTarget" , "both");		// none, both, internal, system
define ("installLogTarget" , "system");

// log dedicated to debug and users
define ("internalLoglevel" , loglevelError);

?>

