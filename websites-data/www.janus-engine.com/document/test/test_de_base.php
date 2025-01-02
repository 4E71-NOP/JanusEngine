<?php
 /*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*JanusEngine-IDE-end*/


/*JanusEngine-Content-Begin*/

$Content .= "
<p>Lorem ipsum dolor sit amet, <span style='background-color:#ff800080; color:#0080ff; font-weight:bold; font-style:italic;'>consectetur adipiscing elit.</span> Donec blandit urna eu orci semper molestie. Cras sit amet porttitor erat. Fusce lobortis purus leo, a vulputate sem ullamcorper in. Vivamus ultricies egestas orci, vel pellentesque ligula facilisis vel. Vivamus pellentesque sapien molestie, dignissim mi a, porta quam. Etiam metus sem, bibendum nec euismod sed, imperdiet eget enim. Quisque ornare, eros id dignissim laoreet, nibh sapien euismod diam, at pharetra tortor nibh id massa. Vestibulum faucibus egestas nibh eget aliquam. Morbi quis urna dictum, condimentum dui tristique, rhoncus mauris. Suspendisse potenti. In ligula ligula, ornare nec tortor ac, scelerisque placerat sem. In non ligula et arcu ullamcorper pellentesque ac quis velit.</p>
<p>Nunc lacinia orci. <span class='".$Block."_warning'>vel sagittis iaculis.</span> Quisque ac nulla non lectus tincidunt tempor congue a nunc. Maecenas posuere mauris sed lorem sodales, volutpat condimentum arcu iaculis. Mauris vehicula sagittis quam at mattis. Pellentesque bibendum posuere suscipit. Sed id pharetra felis. Etiam sapien felis, pharetra eu metus id, vulputate finibus odio.</p>

<p>Quisque ac nulla non lectus <span class='".$Block."_ok'>tincidunt tempor </span>congue a nunc.</p>
<p>Quisque ac nulla non lectus <span class='".$Block."_warning'>tincidunt tempor </span>congue a nunc.</p>
<p>Quisque ac nulla non lectus <span class='".$Block."_error'>tincidunt tempor </span>congue a nunc.</p>
<p>Quisque ac nulla non lectus <span class='".$Block."_fade'>tincidunt tempor </span>congue a nunc.</p>
<p>Quisque ac nulla non lectus <span class='".$Block."_highlight'>tincidunt tempor </span>congue a nunc.</p>
<code>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec blandit urna eu orci semper molestie. Cras sit amet porttitor erat. Fusce lobortis purus leo, a vulputate sem ullamcorper in. </code>
";
/*JanusEngine-Content-End*/

?>
