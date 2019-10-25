<?php


$mawhome = "/var/www/maw";
$mawcat = $mawhome . "/common/mawcat";


#$texpath="/opt/texlive2007/bin/i386-linux/";
$pdflatex = $texpath . "pdflatex";
$latex = $texpath . "latex";
$dvips = $texpath . "dvips";
$epstopdf = $texpath . "epstopdf";
$mpost = $texpath . "mpost";
$ps2pdf = "/usr/bin/ps2pdf";


$maxima2 = "/opt/maxima-5.21/bin/maxima";
$maxima = "/usr/bin/maxima";

$maw_cache_directory = "/var/www/maw_cache/integral/";

$TeX_rgbcolor = "0.21,0.71,0.22";

function maw_after_flush()
{
	for ($iiii = 1; $iiii <= 1000; $iiii++) {
		echo("       \n");
	}
	ob_flush();
	flush();
}

$load_limit = 5;  // no computation if the server load exceeds this limit
$processes_limit = 25;  // no computation if the number of processes on server exceeds this limit

$maw_html_custom_head = "<link rel=\"shortcut icon\" href=\"http://wood.mendelu.cz/math/favicon.ico\" />";

if ($lang == "ru") {
	$TeX_language = '\usepackage[utf8]{inputenc}\usepackage[russian]{babel}';
} elseif ($lang == "cs") {
	$TeX_language = '\usepackage[utf8]{inputenc}\usepackage{lmodern}\usepackage[T1]{fontenc}\usepackage[czech]{babel}';
}

?>
