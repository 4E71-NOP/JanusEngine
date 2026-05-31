<?php
 // // @JanusEngine:license-start
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



// @JanusEngine:IDE-begin
// Some definitions in order to ease the IDE work and to provide details about what is available.
//
// @var $bts BaseToolSet
// @var $CurrentSetObj CurrentSet
// @var $ClassLoaderObj ClassLoader
//
// @var $RequestDataObj RequestData
// @var $SDDMObj DalFacade
// @var $SqlTableListObj SqlTableList
//
// @var $StringFormatObj StringFormat
// @var $MapperObj Mapper
// @var $DocumentDataObj DocumentData
// @var $ThemeDataObj ThemeData
// @var $UserObj User
// @var $WebSiteObj WebSite
//
// @var $CMObj ConfigurationManagement
// @var $LMObj LogManagement
//
// @var $InteractiveElementsObj InteractiveElements
// @var $RenderTablesObj RenderTables
//
// @var $Content String
// @var $Block String
// @var $infos array
// @var $l String
//
// @JanusEngine:IDE-end



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
