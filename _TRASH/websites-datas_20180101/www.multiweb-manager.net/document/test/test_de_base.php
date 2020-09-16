<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

echo ( "
<p>Lorem ipsum dolor sit amet, <mark style='background-color:#ff8000; color:#0000ff; font-weight:bold; font-style:italic;'>consectetur adipiscing elit.</mark> Donec blandit urna eu orci semper molestie. Cras sit amet porttitor erat. Fusce lobortis purus leo, a vulputate sem ullamcorper in. Vivamus ultricies egestas orci, vel pellentesque ligula facilisis vel. Vivamus pellentesque sapien molestie, dignissim mi a, porta quam. Etiam metus sem, bibendum nec euismod sed, imperdiet eget enim. Quisque ornare, eros id dignissim laoreet, nibh sapien euismod diam, at pharetra tortor nibh id massa. Vestibulum faucibus egestas nibh eget aliquam. Morbi quis urna dictum, condimentum dui tristique, rhoncus mauris. Suspendisse potenti. In ligula ligula, ornare nec tortor ac, scelerisque placerat sem. In non ligula et arcu ullamcorper pellentesque ac quis velit.</p>
<p>Nunc lacinia orci. <mark class='".$theme_tableau.$_REQUEST['bloc']."_avert'>vel sagittis iaculis.</mark> Quisque ac nulla non lectus tincidunt tempor congue a nunc. Maecenas posuere mauris sed lorem sodales, volutpat condimentum arcu iaculis. Mauris vehicula sagittis quam at mattis. Pellentesque bibendum posuere suscipit. Sed id pharetra felis. Etiam sapien felis, pharetra eu metus id, vulputate finibus odio.</p>
");


/*
$pv['mt01'] = microtime(TRUE);
$pv['mt02'] = explode(".", microtime(TRUE));
list($usec, $sec) = explode(" ", microtime(TRUE));

echo (
"01|".$pv['mt01']."|<br>\r".
"02|".print_r_html ( $pv['mt02'] ) ."|<br>\r".
"03|".$usec."/".$sec."|<br>\r"
);


echo("<hr>
Test de outil_debug<br\r
>");
outil_debug ( $pv , "Test_de_base.php<br>\$pv" );

echo ("
<hr>
<table>
<thead>
<tr> <td colspan='5'>Je suis l'entete de la table</td> </tr>
</thead>
<tbody  style='display:block; overflow-y:scroll; height:256px;'>
");
for ( $i=1 ; $i<=20 ; $i++) {
	echo ("
	<tr>
	<td>cellule</td>
	<td>cellule</td>
	<td>cellule</td>
	<td>cellule</td>
	<td>cellule</td>
	</tr>
	");
}
echo ("
</tbody>
</table>
<vr>
");

echo ("0/" . floor(memory_get_usage()/1024) . "<br>\r");

$pv['schtroumph1'] = array();
for ( $i=1 ; $i<1000; $i++ ) { $pv['schtroumph1'][] = "plouf on the fonky side of the world"; }
echo ("1/" . floor(memory_get_usage()/1024) . "<br>\r");

$pv['schtroumph2'] = array();
for ( $i=1 ; $i<1000; $i++ ) { $pv['schtroumph2'][] = "plouf on the fonky side of the world"; }
echo ("2/" . floor(memory_get_usage()/1024) . "<br>\r");

unset ($pv['schtroumph1'] );
echo ("3/" . floor(memory_get_usage()/1024) . "<br>\r");

unset ($pv['schtroumph2'] );
echo ("4/" . floor(memory_get_usage()/1024) . "<br>\r");


outil_debug ( $_REQUEST['FS_table']['0'] , "test_de_base.php<br>\$_REQUEST['FS_table']" );


$pv['phpfunc'] = microtime_chrono();

echo ( "<hr>Fonction PHP :" . $pv['phpfunc'] . "<br>" );

$pv['phpexplode'] = explode(".", $pv['phpfunc']);
echo ( "<hr>PHP explode:" . print_r_html ( $pv['phpexplode'] ) . "<br>" );

list( $pv['phplist']['0'], $pv['phplist']['1'] )  = explode(".", $pv['phpfunc']);
echo ( "<hr>PHP list:" . print_r_html ( $pv['phplist'] ) . "<br>" );

$pv['float'] = ((float)$pv['phplist']['0'] + (float)$pv['phplist']['1']);
echo ( "<hr>PHP float:" . $pv['float'] . "<br>" );
sleep(2);

$pv['phpfunc2'] = microtime_chrono();
echo ( "<hr>PHP calcul:".$pv['phpfunc2']."-".$pv['phpfunc']."=".($pv['phpfunc2']-$pv['phpfunc'])."<br>" );

*/

/*
list($usec, $sec) = explode(" ", microtime(TRUE));
*/


?>
