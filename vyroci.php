<?php

/*
Mathematical Assistant on Web - web interface for mathematical
coputations including step by step solutions
Copyright 2014 Robert Marik

This file is part of Mathematical Assistant on Web.

Mathematical Assistant on Web is free software: you can
redistribute it and/or modify it under the terms of the GNU
General Public License as published by the Free Software
Foundation, either version 3 of the License, or
(at your option) any later version.

Mathematical Assistant on Web is distributed in the hope that it
will be useful, but WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Mathematical Assistant o Web.  If not, see 
<http://www.gnu.org/licenses/>.

*/

$server = "/maw";
$lang = "en";
$locale_file = "en_US";
$lang_array = ["cs", "en", "pl", "ca", "zh", "fr", "ru", "de", "it", "uk", "es"];

$custom_between_flags = "";


$submenu_inside = false;


$submenu_all = false;


$maw_overlib = true;

$maw_header = "";

if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
	$maw_overlib = false;
}

$reqlang = $_REQUEST["lang"];

if ($reqlang == "") {
	$reqlang = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	$reqlang = substr($reqlang[0], 0, 2);
}

if ($reqlang == "cz") {
	$reqlang = "cs";
}
if ($reqlang == "ua") {
	$reqlang = "uk";
}
if ($reqlang == "") {
	$reqlang = "en";
}
$lang = $reqlang;


if ($reqlang == "cs") {
	$langl = "cs_CZ";
	$locale_file = "cs_CZ";
}
if ($reqlang == "en") {
	$langl = "en_US";
	$locale_file = "en_US";
}
if ($reqlang == "pl") {
	$langl = "pl_PL";
	$locale_file = "pl_PL";
}
if ($reqlang == "ca") {
	$langl = "ca_ES";
	$locale_file = "ca_ES";
}
if ($reqlang == "fr") {
	$langl = "fr_FR";
	$locale_file = "fr_FR";
}
if ($reqlang == "zh") {
	$langl = "zh_CN";
	$locale_file = "zh_CN";
}
if ($reqlang == "ru") {
	$langl = "ru_RU";
	$locale_file = "ru_RU";
}
if ($reqlang == "de") {
	$langl = "de_DE";
	$locale_file = "de_DE";
}
if ($reqlang == "it") {
	$langl = "it_IT";
	$locale_file = "it_IT";
}
if ($reqlang == "uk") {
	$langl = "uk_UA";
	$locale_file = "uk_UA";
}
if ($reqlang == "es") {
	$langl = "es_ES";
	$locale_file = "es_ES";
}
setlocale(LC_MESSAGES, $langl . ".UTF-8");
bindtextdomain("messages", "locale");
textdomain("messages");
bind_textdomain_codeset("messages", "UTF-8");
function __($text)
{
	return gettext($text);
}


$form = $_REQUEST["form"];
$maw_before_form_custom_string = "";

if (file_exists('./mawconfightml.php')) {
	require('./mawconfightml.php');
}

require('./social_copy.php');

function fixit($text)
{
	return str_replace("'", "\'", $text);
}

if (preg_match("/[^3_2a-z]/", $form)) {
	header('Location:http://user.mendelu.cz/marik/maw');
	die();
}

$group2 = ["graf", "df", "df3d", "lagrange", "mnc"];
$group3 = ["derivace", "prubeh", "taylor", "minmax3d"];
$group4 = ["integral", "definite", "integral2", "geom", "trap", "lineintegral"];
$group5 = ["ode", "lde2", "autsyst"];
$group6 = ["banach", "newton", "regula_falsi", "bisection", "ineq2d"];
$group7 = ["map"];


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html itemscope itemtype="http://schema.org/Other">
<head>
	<meta name="verify-v1" content="x3d1tCrhI9DFDDtCOx3kjZETBlj6CmnFT1YHhe3HBC8=">
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
	<link rel="stylesheet" type="text/css" href="styl.css">


	<meta name="author" content="Robert Mařík">
	<meta property="title" content="Mathematical Assistant on Web"/>
	<meta name="description"
				content="The site for online computation of calculus problems. Enter your assignment and enjoy a computer generated solution which includes all the steps."/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="image_src" href="http://um.mendelu.cz/maw-html/mawmenu.jpg"/>

	<!-- Přidejte do záhlaví následující tři značky. -->
	<meta itemprop="name" content="Mathematical Assistant on Web">
	<meta itemprop="description"
				content="The site for online computation of calculus problems. Enter your assignment and enjoy a computer generated solution which includes all the steps.">
	<meta itemprop="image" content="http://um.mendelu.cz/maw-html/mawmenu.jpg">

	<!-- fb meta -->
	<meta property="og:title" content="Mathematical Assistant on Web"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="http://um.mendelu.cz/maw-html/menu.php"/>
	<meta property="og:image" content="http://um.mendelu.cz/maw-html/mawmenu.jpg"/>
	<meta property="og:description"
				content="The site for online computation of calculus problems. Enter your assignment and enjoy a computer generated solution which includes all the steps."/>

	<!-- twitter meta -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:creator" content="@robert_marik">
	<meta name="twitter:title" content="Mathematical Assistant on Web">
	<meta name="twitter:description"
				content="The site for online computation of mathematical problems with main focus to calculus http://user.mendelu.cz/marik/maw @robert_marik">
	<meta name="twitter:image" content="http://um.mendelu.cz/maw-html/mawmenu.jpg">


	<link rel="stylesheet" href="css/normalize.min.css"/>
	<!-- Stylesheet required to power RRSSB. Copy this css file to your header -->
	<link rel="stylesheet" href="css/rrssb.css"/>

	<script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>


	<?php
	if (file_exists('./custom.css')) {
		echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"custom.css\" >");
	}

	if (file_exists('./menu_custom.css')) {
		echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"menu_custom.css\" >");
	}


	?>

	<title><?php echo __("MAW vyroci"); ?></title>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen"/>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>


	<script src="masonry.pkgd.min.js"></script>

	<style type="text/css">
		body {
			margin: 5px;
		}

		.tlacitko {
			padding: 2px;
			border: solid 1pt;
			margin-top: 10px;
			margin-bottom: 10px;
			display: inline-block;
			min-width: 2em;
			text-align: center;
			background-color: #DDD;
		}

		.open {
			color: gray;
			padding-left: 3px;
			padding-right: 3px;
		}

		#calc {
			background-color: #EEE;
			padding: 10px;
			position: fixed;
			top: 0;
			z-index: 100;
			display: none;
		}

		.editor {
			display: none;
		}

		#vystup {
			color: green;
			font-size: 125%;
			background-color: #CCC;
			padding: 5px;
		}

		.mobilemenu, .submenu, .maw_mobile_menu {
			padding-left: 10px;
		}

		.href {
			padding: 5px;
			align: center;
		}

		.mobilemenu a {
			text-decoration: none;
			border: none;
		}

		.submenu li {
			display: inline-block;
		}

		.href {
			display: inline-block;
			width: 150px;
			height: 60px;
			background-color: #5FCC06;
			vertical-align: top;
			color: #222;
			font-size: 125%;
			text-align: center;
		}

		.submenu, .submenu_container {
			width: 95%;
		}

		#setting_title img, li img {
			width: 40px;
			cursor: pointer;
			cursor: hand;
			vertical-align: middle;
		}

		#menu_current {
			display: block;
			margin-bottom: 20px;
		}

		#setting_menu {
			position: absolute;
			zorder = 10000;
			background-color: #DDD;
			border: solid;
			box-shadow: black 4px 6px 20px;
			-webkit-box-shadow: black 4px 6px 20px;
			-moz-box-shadow: black 4px 6px 20px;
		}

		#setting_menu, #menu_cookies, #menu_nocookies {
			display: none;
		}

		#setting_div {
			display: none;
		}

		#setting_menu {
			padding: 10px;
		}

		#settings_list {
			padding-left: 5px;
		}

		#setting_div li {
			padding: 10px;
			margin: 4px;
			border: solid 1px gray;
			list-style-type: none;
			cursor: pointer;
			cursor: hand;
		}

		#menu_close {
			text-align: right;
		}

		.polozka {
			margin-bottom: 5px;
			display: inline-block;
			vertical-align: top;
			border: 1px solid gray;
		}


		.thmbnail {
			width: 150px !important;
			padding: 5px;
		}

		.polozka {
			background-color: #DDD;
		}

		.polozka:hover {
			background-color: #F4F4F4;
		}


		.thmbnail imgdiv {
			margin: 0 auto;
		}

		.href {
			height: auto;
		}


		.double .polozka, .double .href, .double .thmbnail {
			width: 320px !important;
		}

		#one, .triple .polozka {
			width: 328px !important;
		}

		.ytbimg {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
		}

		.responsive-container {
			position: relative;
			padding-bottom: 65%;
			height: 0;
			overflow: hidden;
		}

		.responsive-container .ytbimg {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}

		.cetered-div {
			max-width: 500px !important;
			margin-left: auto;
			margin-right: auto;
			display: inline-div;
		}

		.border {
			border-width: 1px;
			border-style: dashed;
			border-color: gray;
			padding: 0px;
			background-color: #5fcc06;
		}

		.popisek {
			margin-left: auto;
			margin-right: auto;
			margin-bottom: 1px;
			font-size: 75%;
			font-weight: normal;
			padding: 3px;
		}


		#one p {
			padding-right: 5px;
			padding-bottom: 3px;
		}


		@media screen and (max-width: 600px) {
			#one {
				float: none;
				margin-right: 0;
				width: auto;
				border: 0;
				border-bottom: 2px solid #000;
			}
		}

		@media screen and (max-width: 700px) {
			.optimg {
				display: none;
			}
		}

		.mobilemenu, .maw_mobile_menu {
			padding: 0px;
		}

		.mobilemenu {
			padding-top: 6px;
		}

		.fb-like {
			margin-bottom: 2px;
			margin-left: auto;
			margin-right: 3px;
		}


		.sdeleni {
			font-weight: 500;
			background-color: #F5F5DC;
			padding: 3px;
		}

		.nopadding {
			background-color: #F5F5DC;
		}


		.miniimg {
			width: 100%;
		}

		.playbtn {
			width: 20px;
			position: absolute;
			margin-left: 3px;
			color: white;
		}

		.rrssb-buttons li {
			margin-bottom: 3px;
		}

		.social .polozka:hover, .social .sdeleni, .social .polozka, .social, .social:hover {
			background-color: transparent;
			border: none;
		}


		.social {
			padding: 0px;
			width: 162px;
		}

		.social .sdeleni {
			padding: 0px;
		}

		.rrssb-buttons li {
			margin: 0px;
		}

		.rrssb-buttons li a {
			border-radius: 0px;
		}


		.banner img {
			display: block;
			position: absolute;
			max-width: 158px;
		}

		.banner {
			margin-top: 150px;
			height: 165px;
		}

		.banner #imgmain {
			display: block !important;
		}


		.maw_mobile_menu {
			padding-right: 300px;
		}
	</style>


	<script>
	  jQuery(".menu_close").bind("click",

		  function () {
			  jQuery("#setting_menu").hide();
		  });

	  $(document).ready(function () {
		  jQuery("#setting_title").bind("click",

			  function () {
				  if (navigator.cookieEnabled === true) {
					  ans = getCookie("device")
					  if ((ans == "") || (ans == "auto")) {
						  jQuery("#menu_current").text("<?php echo(__("The device type (tablet/pc) will be determined automatically."));?>");
					  }
					  if (ans == "tablet") {
						  $("#menu_current").text("<?php echo(__("The site will be shown as on the tablet."));?>");
					  }
					  if (ans == "computer") {
						  $("#menu_current").text("<?php echo(__("The site will be shown as on the computer."))?>");
					  }
					  $("#menu_cookies").show();
					  $("#setting_menu").show();
					  $(".settings_list li").bind("click",

						  function () {
							  maw_nastavit($(this).data("device"));
						  });
				  } else {
					  $("#menu_nocookies").show();
					  $("#setting_menu").show();
				  }
			  });
	  });


	  function maw_nastavit(text) {
		  setCookie("device", text, 28);
		  $("#setting_menu").hide();
	  }

	  function setCookie(cname, cvalue, exdays) {
		  var d = new Date();
		  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		  var expires = "expires=" + d.toGMTString();
		  document.cookie = cname + "=" + cvalue + "; " + expires;
	  }

	  function getCookie(cname) {
		  var name = cname + "=";
		  var ca = document.cookie.split(';');
		  for (var i = 0; i < ca.length; i++) {
			  var c = ca[i].trim();
			  if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
		  }
		  return "";
	  }
	</script>


	<?php
	echo $maw_header;
	?>
</head>
<body>

<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="main">
	<div id="head">

	</div>


	<?php

	if (file_exists('./mawcustom_top.php')) {
		echo("\n<div id=\"mawcustom\">");
		require('./mawcustom_top.php');
		echo("</div>");
	}

	echo "\n" . '<div id="title">' . "\n" . '<div id="main-title">';
	echo "Matematická výročí pro MAW";
	echo '</div></div></div>';

	?>

	<div style="font-size:120%;">V MAWu se budou automaticky zobrazovat výročí se vztahem k matematice, fyzice, vědě a
		technice. Cílem je mít
		zajímavá výročí se zajímavými odkazy (nejlépe krátká videa na Youtube) a rovnoměrně rozložená během celého roku.
		Zde je postupně budovaný soupis všech výročí. Pokud do něj chcete přispět, nebo pokud chcete přeložit
		stávající výročí do angličtiny, formát je
		<a href="https://github.com/robert-marik/mathevents/blob/master/data.yaml">volně přístupný</a> a stačí kontaktovat
		marik@mendelu.cz.

		<br>
		<a href="menu_vyroci.php">cz</a>, <a href="menu_vyroci_en.php">en</a>

	</div>


	<div style="float:right; width:300px;">

<?php
$homepage = file_get_contents('public/mathevents/events_all.html');
echo $homepage;
?>


</div>

	<?php
	if (file_exists('./mawcustom_aftertitle.php')) {
		echo("\n<div id=\"mawcustom2\">");
		require('./mawcustom_aftertitle.php');
		echo("</div>");
	}

	?>

	<!-- <div id="setting_div"><span id="setting"><span id="setting_title"><img src="http://blog.ezofficeinventory.com/wp-content/uploads/2014/02/f02a62985cde.png"/></span> -->

	<div id="setting_menu"> <span id="menu_nocookies">
    <?php echo(__("Cookies are off. Your device will be detected automatically. Set cookies on to choose your own preference.")); ?>
    <div class="menu_close">Close</div></span> <span id="menu_cookies">
        <span id="menu_current"></span>
 <?php echo(__("Change the setting to")); ?>
        <ul class="settings_list">
            <li data-device="tablet"><img src="icons/tablet.png"> <?php echo(__("tablet")); ?></li>
            <li data-device="computer"><img src="icons/computer.png"> <?php echo(__("computer")); ?></li>
            <li data-device="auto"><?php echo(__("detect automatically")); ?></li>
        </ul></span>
	</div>
	</span>
</div>


<div class="mobilemenu">
<?php 


function nospaces ($a)
{
   global $submenu_inside;
   if (!($submenu_inside)) {return (str_replace(" ","&nbsp;",$a));}
   else {return ($a);}
}

function maw_submenu ($a,$b,$c,$d,$double="normal")
{
  $picture="";
  if (file_exists("$c.svg"))
    {$picture="<div class='imgdiv'><img src='$c.svg'></div>";} else {$picture="";}
  return "\n".'<div class="polozka '.$double.'"><a href="index.php?lang='.$b.'&amp;form='.$c.'"><div class="href">'.nospaces($d).'</div><div class="thmbnail">'.$picture.'</div></a></div>';
}

function opt_shuffle ($input)
{
  if(mt_rand(0,3)!=0)
  {return ($input);}
  else
  {shuffle($input); return ($input);}
}


printf("\n<div class=\"maw_mobile_menu\">");


foreach ($sdeleniCZ as $value) {    
echo "<div class='polozka href nopadding'><div class='sdeleni'><small>$value</small></div></div> ";
}






?>

</div>


</div>
</div>


<!-- Required Javascript files. Copy these to your document. -->

<script src="js/rrssb.js"></script>


<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
			m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-41290718-1', 'mendelu.cz');
	ga('send', 'pageview');

	$(document).ready(function () {
		$('.maw_mobile_menu').masonry({

			transitionDuration: '1s',
			columnWidth: 170
		});
	});


	$(function () {
		var $element = $('#img4');

		function fadeInOut() {
			$element.fadeIn(4000, function () {
				$element.fadeOut(4000, function () {
					$element.fadeIn(4000, function () {
						setTimeout(fadeInOut, 2000);
					});
				});
			});
		}

		fadeInOut();
	});

	$(window).load(function () {
		$('.maw_mobile_menu').masonry('destroy');
		$('.maw_mobile_menu').masonry({
			transitionDuration: '1s',
			columnWidth: 170
		});
	});


	$(document).ready(function () {
		$('.fancybox-media')
			.attr('rel', 'media-gallery')
			.fancybox({
				arrows: false,
				helpers: {
					media: {},
				}
			});

		$('.sad').parent().css("background-color", "lightgray");
		$('.sad').parent().parent().css("background-color", "lightgray");
		$('.sad').parent().parent().parent().css("background-color", "black");


		$(".fancybox-media").each(function () {
			odkaz = $(this).attr('href');
			if (odkaz.indexOf("youtube") >= 0) {
				$(this).prepend("<img class='playbtn' alt='Play' src='http://um.mendelu.cz/maw-html/public/mathevents/play.png'/>");
			}
		});


	});


</script>


</body>
</html>
