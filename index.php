<?php

/*
Mathematical Assistant on Web - web interface for mathematical
coputations including step by step solutions
Copyright 2007-2010 Robert Marik, Miroslava Tihlarikova           
Copyright 2011-2014 Robert Marik

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

function fixit($text)
{
	return str_replace("'", "\'", $text);
}

if ((preg_match("/[^3_2a-z]/", $form)) || ($form == "")) {
	header('Location:menu.php');
	die();
}

$group2 = ["graf", "df", "df3d", "lagrange", "mnc"];
$group3 = ["derivace", "prubeh", "taylor", "minmax3d"];
$group4 = ["integral", "definite", "integral2", "geom", "trap", "lineintegral"];
$group5 = ["ode", "lde2", "autsyst"];
$group6 = ["banach", "newton", "regula_falsi", "bisection", "ineq2d"];
$group7 = ["map"];

$submenu = 1;
if (in_array($form, $group2)) {
	$submenu = 2;
}
if (in_array($form, $group3)) {
	$submenu = 3;
}
if (in_array($form, $group4)) {
	$submenu = 4;
}
if (in_array($form, $group5)) {
	$submenu = 5;
}
if (in_array($form, $group6)) {
	$submenu = 6;
}
if (in_array($form, $group7)) {
	$submenu = 7;
}
if ($submenu == 1) {
	$form = "main";
}


$deviceType = "tablet";

if (($deviceType != 'computer') && ($form == "main")) {
	header('Location:menu.php?lang=' . $reqlang);
	die();
}


function hint_preview($a = "")
{
	if ($a != "") {
		echo("\n" . '<div class="hint_preview">');

		echo($a);
		echo('</div>');
	}
	echo('<br>');
}

$previewmsg = __("Clicking this button you get how formconv renders your expression and how you can enter this expression in Maxima notation (you can use copy and paste to transfer to the form.)");

function maw_before_form()
{
	global $maw_before_form_custom_string;
	echo $maw_before_form_custom_string . "\n<div id='form' style='display:block;'>";
}

function maw_after_form()
{
	echo "</div>\n<div id='after-form' style='display:none;'>" . sprintf(__("Your input is being processed. Wait few seconds to see the output. Click %shere%s to reopen the form which has been submited."), "<a href=\"#\" onclick=\"document.getElementById('after-form').style.display='none';document.getElementById('form').style.visibility='visible';\">", "</a>") . "</div>";
	echo "<script type=\"text/javascript\">document.getElementById('after-form').style.display='none';</script>";
}

function history($adresar, $server)
{
	global $form;
	if (file_exists("./$form-examples.php")) {
		echo "<div id=examples><span id=examples-header>" . __("Examples") . ": </span>";
		include("$form-examples.php");
		echo "</div>";
	}
	echo("\n<div id=\"history\"><a rel=\"facebox\" href=\"$server/common/tail.php?dir=$adresar\">");
	echo __("History");
	echo("</a></div>\n<div id=\"comments\">");
}

function polejazyka($ret)
{
	echo '<input type="hidden" name="lang" value="' . $ret . '">';

	echo '<input type="hidden" name="ip" value="">';
	$ref = $_SERVER['HTTP_REFERER'];
	echo '<input type="hidden" name="referer" value="' . str_replace("&", "&amp;", $ref) . '">';
}

function formmethod()
{
	echo 'method="post"';
}

function examples($ids)
{
	$idsArray = split(",", $ids);
	foreach ($idsArray as $value) {
		echo "<a href=\"#\" id=\"e-$value\" class=\"example\" title=\"\">" . __("Example") . " $value</a>, ";
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta name="verify-v1" content="x3d1tCrhI9DFDDtCOx3kjZETBlj6CmnFT1YHhe3HBC8=">
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">

	<link rel="stylesheet" href="css/normalize.min.css"/>
	<!-- Stylesheet required to power RRSSB. Copy this css file to your header -->
	<link rel="stylesheet" href="css/rrssb.css"/>
	<script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>

	<link rel="stylesheet" type="text/css" href="styl.css">

	<?php
	if (file_exists('./custom.css')) {
		echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"custom.css\" >");
	}


	if ($deviceType != 'computer') {
		if (file_exists('./mobile_custom.css')) {
			echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"mobile_custom.css\" >");
		}
	}

	?>


	<title><?php echo __("Mathematical Assistant on Web"); ?></title>


	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css"
				type="text/css" media="all"/>
	<link rel="stylesheet" href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all"/>

	<style>
		.blink {
			color: red;
			margin-right: 0px;
			border-left: solid 5px red;
		}

	</style>

	<link href="js/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<!---  <link href="css/example.css" media="screen" rel="stylesheet" type="text/css" /> -->
	<script src="js/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
	  jQuery(document).ready(function ($) {
		  $('a[rel*=facebox]').facebox({
			  loadingImage: 'js/loading.gif',
			  closeImage: 'js/closelabel.png'
		  })
	  })

	  $(document).bind('reveal.facebox', function () {
		  MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
		  <?php if ($deviceType != "computer")  : ?>
		  $("#maw_calculator").css("min-width", "95%");
		  $("#maw_calculator").css("margin-left", "3px");
		  <?php endif; ?>
	  })


	  <?php if ($deviceType != "computer")  : ?>


	  jQuery(window).load(function () {
		  jQuery(':text').each(function () {
			  jQuery(this).after('<span class="open"><img src="icons/keyboard.png"></span>');
		  })

		  jQuery(".open").bind("click", function () {
				  jQuery("#calc").show();
				  jQuery("#facebox_overlay").show();
				  cilovePole = jQuery(this).prevAll("input").first();
				  puvodni = cilovePole.val();
				  vyraz = puvodni + "?";
				  aktualizovat(vyraz);
			  }
		  );

		  jQuery("#calc .tlacitko").bind("click", function () {


			  vstup = vyraz;
			  pos = vstup.indexOf("?");
			  pred = vstup.substring(0, pos);
			  za = vstup.substring(pos + 1);
			  pridat = "" + jQuery(this).data("text");
			  if (pridat == "->") {
				  text = pred + za.substring(0, 1) + "?" + za.substring(1);
			  } else if (pridat == "<-") {
				  text = pred.substring(0, pred.length - 1) + "?" + pred.substring(pred.length - 1) + za;

			  } else if (pridat == "BackSpace") {
				  text = pred.substring(0, pred.length - 1) + "?" + za;
			  } else if (pridat == "Enter") {
				  text = pred + za;
			  } else if (pridat == "Close") {
				  text = puvodni;
			  } else if (pridat == "Clear") {
				  text = "";
			  } else {
				  posledni = pred.substring(pred.length - 1);
				  if (posledni >= "0" && posledni <= "9" && ((pridat.substring(0, 1) < "0") || (pridat.substring(0, 1) > "9")) && (pridat != "*") && (pridat != "+") && (pridat != "-") && (pridat != "/") && (pridat != "^") && (pridat != "*")) {
					  pridat = "*" + pridat;
				  }
				  if (pridat.substring(pridat.length - 2) == "()") {
					  pridat = pridat.substring(0, pridat.length - 1) + "?)";
				  } else {
					  pridat = pridat + "?";
				  }
				  text = pred + pridat + za;
			  }


			  if (pridat == "Enter") {
				  jQuery("#vystup").text("");
				  cilovePole.val(text);
				  jQuery("#calc").toggle();
			  } else if (pridat == "Close") {
				  jQuery("#vystup").text("");
				  cilovePole.val(text);
				  vyraz = text;
				  jQuery("#calc").toggle();
				  jQuery("#facebox_overlay").hide();
			  } else {
				  aktualizovat(text);
				  vyraz = text;
			  }
		  });


	  });


	  function aktualizovat(text) {
		  jQuery("#vystup").text("");
		  for (var i = 0; i < text.length; i++) {
			  pismeno = text.charAt(i);
			  if (pismeno == "?") {
				  pismeno = "<span class=blink></span>";
			  }
			  jQuery("#vystup").append("<span id='letter" + i + "' data-poradi='" + i + "'>" + pismeno + "</span>");
			  jQuery("#letter" + i).bind("click", function () {
				  nastavit(jQuery(this).data("poradi"));
			  });
		  }
	  };

	  function nastavit(cislo) {
		  pos = vyraz.indexOf("?");
		  novy = vyraz.replace("?", "")
		  pred = novy.substring(0, cislo);
		  za = novy.substring(cislo);
		  vyraz = pred + "?" + za;
		  text = vyraz;
		  aktualizovat(text);
	  }

	  <?php endif; ?>

	</script>

	<style>
		.lupa {
			background: url("icons/glass.png") no-repeat 0 0;
			background-size: auto 100%;
			width: 30px;
			height: 30px;
		}

		#calc .lupa {
			background: none;
			border: solid 1px;
			background-color: #AAA;
		}

		.go {
			background: url("icons/done.png") no-repeat 0 0;
			background-size: 100% 100%;
		}

		.open img {
			width: 30px;
		}
	</style>

	<script type="text/x-mathjax-config">
 
     MathJax.Hub.Register.StartupHook("TeX Jax Ready",function () {
          var TEX = MathJax.InputJax.TeX;
          var PREFILTER = TEX.prefilterMath;
          TEX.Augment({
            prefilterMath: function (math,displaymode,script) {
              math = "\\displaystyle{"+math+"}";
              return PREFILTER.call(TEX,math,displaymode,script);
            }
          });
        });


	</script>


	<script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    extensions: ["tex2jax.js"],
    jax: ["input/TeX", "output/HTML-CSS"],
    tex2jax: {
      inlineMath: [ ['$','$'], ["\\(","\\)"] ],
      displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
      skipTags: ["script","noscript","style","textarea","code"],
      processEscapes: true
    },
    "HTML-CSS": { availableFonts: ["TeX"] }
  });


	</script>

	<!--

  <script type="text/javascript"
	 src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>

  -->

	<script type="text/javascript"
					src="http://um.mendelu.cz/mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>

	<script type="text/javascript">
	  var thedata;
	  var newwin;
	  var thenumber;

	  function edit(textarea) {
		  thenumber = textarea;
		  thedata = document.forms['exampleform'].elements[textarea].value
		  newwin =
			  window.open("MAW_dragmath.html", "", "width=600,height=450,resizable=1,menubar=1,scrollbars=1")
	  }

	  function previewb(textarea) {
		  <?php
		  echo 'server="', $server, '";';
		  ?>
		  thenumber = textarea;
		  thedata = document.forms['exampleform'].elements[textarea].value;
		  jQuery.facebox({
			  ajax: server + "/common/formconv.php?lang=<?php echo $lang;?>&expr=" + encodeURIComponent(document.forms['exampleform'].elements[textarea].value)
		  });
	  }

	  function previewb_int2(textarea) {
		  <?php
		  echo 'server="', $server, '";';
		  ?>
		  thedata = server + "/common/formconv.php?lang=<?php echo $lang;?>&expr=" + encodeURIComponent(document.forms['exampleform'].elements[textarea].value) + "&a=" + encodeURIComponent(document.forms['exampleform'].elements['a'].value) + "&b=" + encodeURIComponent(document.forms['exampleform'].elements['b'].value) + "&c=" + encodeURIComponent(document.forms['exampleform'].elements['c'].value) + "&d=" + encodeURIComponent(document.forms['exampleform'].elements['d'].value) + "&vars=" + encodeURIComponent(document.forms['exampleform'].elements['vars'].value);
		  jQuery.facebox({ajax: thedata});
	  }

	  function preview_region(textarea) {
		  <?php
		  echo 'server="', $server, '";';
		  ?>
		  thedata = server + "/common/formconv.php?lang=<?php echo $lang;?>&expr=" + encodeURIComponent(document.forms['exampleform'].elements['funkce'].value) + "&xmin=" + encodeURIComponent(document.forms['exampleform'].elements['xmin'].value) + "&xmax=" + encodeURIComponent(document.forms['exampleform'].elements['xmax'].value) + "&ymin=" + encodeURIComponent(document.forms['exampleform'].elements['ymin'].value) + "&ymax=" + encodeURIComponent(document.forms['exampleform'].elements['ymax'].value) + "&a=" + encodeURIComponent(document.forms['exampleform'].elements['a'].value) + "&b=" + encodeURIComponent(document.forms['exampleform'].elements['b'].value) + "&c=" + encodeURIComponent(document.forms['exampleform'].elements['c'].value) + "&d=" + encodeURIComponent(document.forms['exampleform'].elements['d'].value) + "&vars=" + encodeURIComponent(document.forms['exampleform'].elements['vars'].value) + "&region=1";
		  jQuery.facebox({ajax: thedata});
	  }

	  function preview_function(textarea) {
		  <?php
		  echo 'server="', $server, '";';
		  ?>
		  thedata = server + "/prubeh/zpracuj.php?lang=<?php echo $lang;?>&funkce=" + encodeURIComponent(document.forms['exampleform'].elements['funkce'].value) + "&xmin=" + encodeURIComponent(document.forms['exampleform'].elements['xmin'].value) + "&xmax=" + encodeURIComponent(document.forms['exampleform'].elements['xmax'].value) + "&ymin=" + encodeURIComponent(document.forms['exampleform'].elements['ymin'].value) + "&ymax=" + encodeURIComponent(document.forms['exampleform'].elements['ymax'].value) + "&output=png";
		  jQuery.facebox("<img alt='Processing image ...' src='" + thedata + "'>");
	  }

	  function preview_curve(textarea) {
		  <?php
		  echo 'server="', $server, '";';
		  ?>
		  thedata = server + "/gnuplot/curve.php?lang=<?php echo $lang;?>&x=" + encodeURIComponent(document.forms['exampleform'].elements['x'].value) + "&y=" + encodeURIComponent(document.forms['exampleform'].elements['y'].value) + "&z=" + encodeURIComponent(document.forms['exampleform'].elements['z'].value) + "&tmin=" + encodeURIComponent(document.forms['exampleform'].elements['tmin'].value) + "&tmax=" + encodeURIComponent(document.forms['exampleform'].elements['tmax'].value);
		  jQuery.facebox({ajax: thedata});
	  }

	  function allow_preview(text) {
		  if ((text == 'dx dy') || (text == 'dy dx') || (text == 'r dr dphi') || (text == 'r dphi dr')) {
			  document.getElementById('preview_region').style.display = "inline";
		  } else {
			  document.getElementById('preview_region').style.display = "none";
		  }
	  }
	</script>


	<style>
		#calc .tlacitko {
			padding: 3px;
			border: solid 1pt;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-right: 10px;
			display: inline-block;
			min-width: 2em;
			text-align: center;
			background-color: #DDD;
			min-height: 8px;
		}

		.open {
			color: #080;
			padding-left: 3px;
			padding-right: 3px;
			font-size: 160%;
		}

		#calc {
			background-color: #EEE;
			padding: 10px;
			position: fixed;
			top: 5px;
			z-index: 100;
			display: none;
			box-shadow: black 4px 6px 20px;
			-webkit-box-shadow: black 4px 6px 20px;
			-moz-box-shadow: black 4px 6px 20px;
			width: 95%;
			min-height: 90%;
		}

		#enter .tlacitko, .tlacitko img, #prompt img {
			border: none;
			background-color: transparent;
			width: 40px;
			vertical-align: middle;
		}

		#calc .tlacitko {
			height: 25px;
			vertical-align: top;
		}

		.editor {
			display: none;
		}

		#vystup {
			color: green;
			font-size: 125%;
			background-color: #CCC;
			padding: 5px;
			margin-bottom: 10px;
			padding-bottom: 5px;
			border: solid 1px;
		}
	</style>

	<?php
	echo $maw_header;
	?>
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<noscript><b style="color: rgb(255, 0, 0);">
		<?php
		echo __("You should turn JavaScript on to see popup informations.");
		?>
	</b></noscript>

<div id="calc">
	<div style="text-align:right;">
		<span class="tlacitko" data-text="Close"
					style="margin-right:0px; margin-left:auto; border:none; background-color:transparent; color:red;">&#x2718;</span>
	</div>
	<span id="prompt"><img src="icons/prompt.png"></span> <span id="vystup"></span>

	<br>
	<br>
	<span class="tlacitko" data-text="0">0</span>
	<span class="tlacitko" data-text="1">1</span>
	<span class="tlacitko" data-text="2">2</span>
	<span class="tlacitko" data-text="3">3</span>
	<span class="tlacitko" data-text="4">4</span>
	<span class="tlacitko" data-text="5">5</span>
	<span class="tlacitko" data-text="6">6</span>
	<span class="tlacitko" data-text="7">7</span>
	<span class="tlacitko" data-text="8">8</span>
	<span class="tlacitko" data-text="9">9</span>
	<span class="tlacitko" data-text=".">.</span>

	<br>

	<span class="tlacitko" data-text="+">+</span>
	<span class="tlacitko" data-text="-">-</span>
	<span class="tlacitko" data-text="*">*</span>
	<span class="tlacitko" data-text="/">/</span>
	<span class="tlacitko" data-text="^">^</span>

	<br>


	<span class="tlacitko" data-text="()">( )</span>
	<span class="tlacitko" data-text='['>[</span>
	<span class="tlacitko" data-text=']'>]</span>
	<span class="tlacitko" data-text="=">=</span>


	<span class="tlacitko" data-text="x">x</span>
	<span class="tlacitko" data-text="y">y</span>
	<span class="tlacitko" data-text="pi">$\pi$</span>
	<span class="tlacitko" data-text="e">e</span>

	<br>
	<span class="tlacitko" data-text="sqrt()">$\sqrt{}$</span>
	<span class="tlacitko" data-text="sin()">sin</span>
	<span class="tlacitko" data-text="cos()">cos</span>
	<span class="tlacitko" data-text="tan()">tan</span>
	<span class="tlacitko" data-text="cot()">cot</span>
	<span class="tlacitko" data-text="ln()">ln</span>
	<span class="tlacitko" data-text="exp()">exp</span>
	<span class="tlacitko" data-text="asin()">asin</span>
	<span class="tlacitko" data-text="acos()">acos</span>
	<span class="tlacitko" data-text="atan()">atan</span>

	<br>
	<span class="tlacitko" data-text="<-">&larr;</span>
	<span class="tlacitko" data-text="BackSpace">BckSp</span>
	<span class="tlacitko" data-text="->">&rarr;</span>
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;
	<span class="tlacitko" data-text="Clear">Clear</span>
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;
	<div id="enter" style="text-align:right; display:inline">
		<span class="tlacitko" data-text="Enter"><img src="icons/done.png" alt="OK"></span>
	</div>


</div>


<div id="main">
	<div id="head">
		<div id="flags" class="no-print">
			<div id="flags-left">
<?php 
function lang_links()
{
global $form,$lang_array;
foreach ($lang_array as $i => $value)
  {
    echo '<a href="index.php?lang='.$value.'&amp;form='.$form.'" ><img src="'.$value.'.png" alt="'.$value.'" style="border: 0px solid ;" ></a>';
    if ($i<(count($lang_array)-1)) {echo ("&nbsp;");}
  }
}
lang_links();
echo ("&nbsp;<a rel=\"facebox\" href=\"translators.html\">".__("More languages")."</a>");
?>
</div>


			<div id="flags-right">
<?php lang_links(); ?>
</div>

		<?php echo($custom_between_flags); ?>

		</div>
		<div class="support">
		<?php
		if (__("http://sourceforge.net/apps/phpbb/mathassistant") != "http://sourceforge.net/apps/phpbb/mathassistant") {
			echo '<a href="' . __("http://sourceforge.net/apps/phpbb/mathassistant") . '">' . __("Support from MAW forum") . '</a><br>';
		}
		?>
			<a rel="facebox" href="news<?php if ($lang == "cs") {
		  echo "_cs";
	  } ?>.html"><?php echo __("Changelog"); ?></a>
			<br>
			<a rel="facebox" href="bugs.html"><?php echo __("Known bugs"); ?></a>
		</div>

	  <?php

	  if (file_exists('./mawcustom_top.php')) {
		  echo("\n<div id=\"mawcustom\">");
		  require('./mawcustom_top.php');
		  echo("</div>");
	  }

	  echo "\n" . '<div id="title">' . "\n" . '<div id="main-title">';
	  echo '<a href="menu.php">' . __('Mathematical Assistant on Web') . '</a>';
	  echo '</div></div></div>';

	  ?>

		<div style="margin-top:5px;" class="no-print">


		</div>

	  <?php
	  if (file_exists('./mawcustom_aftertitle.php')) {
		  echo("\n<div id=\"mawcustom2\">");
		  require('./mawcustom_aftertitle.php');
		  echo("</div>");
	  }

	  ?>

		<div id="main_body">
			<div id="odkaz_hlavicka">

				<div class="mainmenu">
<!-- <div style="position:absolute;text-align:right;margin-right:10px; margin-left:150px;"><img src=xmas.png width=70></div> -->
<?php 


$onsubmitA=<<<STR
onsubmit="aa=document.getElementById('myButton');
aa.disabled=true;
aa.value='%s';
bb='%s';
setTimeout('aa.disabled=false;aa.value=bb', 5000);"
STR;

$onsubmitA=<<<STR
onsubmit="aa=document.getElementById('myButton');
aa.disabled=true;
aa.value='%s';
bb='%s';"
STR;







$onsubmit=" onSubmit=\"document.getElementById('form').style.visibility='hidden';document.getElementById('after-form').style.display='block';\" ";


$submitbuttont=<<<SUB
<input value="%s" name="tlacitko" type="submit" class="tlacitko" id="myButton">
<span class="submit_comment">(%s)</span>
SUB;

$submitbutton=sprintf($submitbuttont,__('Submit'),__('Click only once and wait few seconds for the answer!'));
$submitbutton=$submitbutton."<div class=pdforhtml><fieldset class=pdforhtml>".__('Output').":<input type=\"radio\" value=\"html\" checked=\"checked\" name=\"output\">html<input type=\"radio\" value=\"pdf\" name=\"output\">PDF</fieldset></div>";
$submitbutton=$submitbutton."<div class=pdfnohtmlyes><fieldset class=pdfnohtmlyes>".__('Output').":<input type=\"radio\" value=\"html\" checked=\"checked\" name=\"output2\" >html<input type=\"radio\" value=\"pdf\" name=\"output2\" disabled>PDF</fieldset></div>";
$submitbutton=$submitbutton."<div class=pdfyeshtmlno><fieldset class=pdfyeshtmlno>".__('Output').":<input type=\"radio\" value=\"html\" disabled name=\"output3\">html<input type=\"radio\" value=\"pdf\" name=\"output3\" checked=\"checked\" >PDF</fieldset></div>";

function aktivni_konec($cislo)
{
global $submenu_inside,$submenu,$submenu_all;
if ( ($submenu_inside) && (("$cislo"==$submenu) || ($submenu_all)) )
   {
   printsubmenu($cislo);
   }
echo ("</li>");
}

function aktivni($cislo){
    global $submenu;
    echo ("\n".'<li');
    if ($submenu==$cislo) echo ' class="maw_active">'; else echo ' class="maw_nonactive">';
  }

function aktivni_form($identifikace){
    global $form;
    $t="";
    if ($identifikace==$form) {$t="class=\"maw_active\"";}
    return($t);
  }

function nospaces ($a)
{
   global $submenu_inside;
   if (!($submenu_inside)) {return (str_replace(" ","&nbsp;",$a));}
   else {return ($a);}
}

function maw_submenu ($a,$b,$c,$d)
{
return "\n".'<li '.aktivni_form($a).'><a href="index.php?lang='.$b.'&amp;form='.$c.'">'.nospaces($d).'</a></li>';
}

function printsubmenu($i)
{
  global $lang;
  $proceed=false;
  if (in_array($i,["2","3","4","5","6"]))
    {
      echo ("\n<div class=\"submenu_container\">\n<ul class=\"submenu\">");
      $proceed=true;
    }
  if ($i=="2") {
    echo maw_submenu('graf',$lang,'graf', __("Function grapher"));
    echo maw_submenu('df',$lang,'df', __("Domain of functions (one variable)"));
    echo maw_submenu('df3d',$lang,'df3d', __("Domain of functions (two variables)"));
    echo maw_submenu('lagrange',$lang,'lagrange',__('Lagrange polynomial'));
    echo maw_submenu('mnc',$lang,'mnc',__('Least squares method'));
  }
  elseif ($i=="3")
  {
    echo maw_submenu('derivace',$lang,'derivace',__('Derivative and partial derivative'));
    echo maw_submenu("prubeh",$lang,'prubeh',__('Investigating functions'));
    echo maw_submenu("taylor",$lang,'taylor', __('Taylor polynomial'));
    echo maw_submenu("minmax3d",$lang,"minmax3d", __('Local maxima and minima in two variables'));
  } 
  elseif ($i=="4")
  {
    echo maw_submenu('integral',$lang,'integral',__('Antiderivative'));
    echo maw_submenu('definite',$lang,'definite',__('Definite integral and mean value'));
    echo maw_submenu('geom',$lang,'geom',__('Geometrical applications of definite integral'));
    echo maw_submenu('trap',$lang,'trap',__('Trapezoidal rule'));
    echo maw_submenu('integral2',$lang,'integral2',__('Double integral'));
    echo maw_submenu('lineintegral',$lang,'lineintegral',__('Line integral'));
  } 
  elseif ($i=="5")
  {
    echo maw_submenu('ode',$lang,'ode',__('First order ODE'));
    echo maw_submenu('lde2',$lang,'lde2',__('Second order LDE'));
    echo maw_submenu('autsyst',$lang,'autsyst',__('Autonomous system'));
  } 
  elseif ($i=="6")
  {
    echo maw_submenu('bisection',$lang,'bisection',__('Bisection'));
    echo maw_submenu('newton',$lang,'newton',__('Newton-Raphson method'));
    echo maw_submenu('regula_falsi',$lang,'regula_falsi',__('Regula falsi'));
    echo maw_submenu('banach',$lang,'banach',__('Method of iterations'));
    echo maw_submenu('ineq2d',$lang,'ineq2d',__('System of inequalities (in one or two variables)'));
  }
  if ($proceed) {echo ("\n</ul>\n</div>\n");}
}

printf("\n<ul class=\"maw_menu\">");
aktivni(1);
echo('<a href="index.php?lang='.$lang.'">');
echo __('Introduction'); 
echo '</a>';
aktivni_konec(1);

aktivni(2);
echo('<a href="index.php?lang='.$lang.'&amp;form=graf">');
echo __("Precalculus"); echo '</a>';
aktivni_konec(2);

aktivni(3);
echo('<a href="index.php?lang='.$lang.'&amp;form=derivace">');
echo __("Calculus");
echo '</a>';	  
aktivni_konec(3);

aktivni(4);
echo('<a href="index.php?lang='.$lang.'&amp;form=integral" >');
echo __("Integral calculus");
echo '</a>';
  aktivni_konec(4);

  aktivni(5);
echo('<a href="index.php?lang='.$lang.'&amp;form=ode" >');
echo __("Differential equations");
echo '</a>';
  aktivni_konec(5);

  aktivni(6);
echo ('<a href="index.php?lang='.$lang.'&amp;form=bisection" >');
echo __("Equations and inequalities");
echo '</a>';
aktivni_konec(6);








echo("\n</ul>");

if (!$submenu_inside)
{
  printsubmenu($submenu);
}

echo '</div>';












echo "\n".'<div id="aftermenu">';
if (($submenu!="7")&&($submenu!="1")) {
echo __("Enter your data into the calculator and click Submit. You can also change the type of the calculator in the second row of the menu. <br>The calculators are divided into several groups, the description is available if you move your mouse on the name of each group (the first row of the menu).");
}
else
  {echo __("Choose the field of your interest in the menu and then choose the particular calculator depending on the problem you wish to solve.<br>These calculators are able to solve the problems including step by step solution.<br>The calculators are divided into several groups, the description is available if you move your mouse on the name of each group (the first row of the menu).");}


?>
</div>
			</div>
		<?php if ($deviceType != "computer")  : ?>
					<span class="menuicon no-print"><a href="menu.php?lang=<?php echo $reqlang; ?>"><img src="icons/home.png"
																																															 alt="Home" width=30></a></span>
		<?php endif; ?>

			<div id="maw_calculator" class="no-print">

		  <?php
		  include($form . ".php");

		  ?>


				<script>
			$('#after-form').append("<center><br><img src=\"working.gif\"></center>");
			div1 = $('#form');
			div2 = $('#after-form');

			tdiv1 = div1.clone();
			tdiv2 = div2.clone();

			div1.replaceWith(tdiv2);
			div2.replaceWith(tdiv1);

			if (navigator.userAgent.match(/msie/i)) {
				alert("Microsoft Internet Explorer gives poor resutls when using this site. This will be fixed in next months. Now you can try Firefox or Chrome instead. Thanks. \n\n\n Zdá se, že používáte Microsoft Internet Explorer. Tento prohlížeč nepracuje správně s webem MAW. Než bude problém opraven, zkuste prosím Firefox nebo Chrome.");
			}


				</script>


				<script>

			$(document).ready(function () {
				$("#myButton").focus();
			});


			$("#exampleform").submit(function (e) {
				$("#mawoutput").slideUp();
				$("#maw_calculator").css("background-color", "#CCC");
				var postData = $(this).serializeArray();
				var formURL = $(this).attr("action");
				$.ajax(
					{
						url: formURL,
						cache: true,
						type: "POST",
						data: postData,
						success: function (data, textStatus, jqXHR) {
							var ct = jqXHR.getResponseHeader("content-type");
							if (ct != "application/json") {//jQuery.facebox(data);
								if (data.match(/MAWerror/i)) {
									$("#mawoutput").html("<div class=outputdata><span id=go-top class='no-print'><img src=arrow_up_red.png width=30></span>" + data + "</div>");
									$(".outputdata").css("border-color", "#F00");

								} else {
									$("#mawoutput").html("<div class=outputdata><span id=go-top class=no-print><img src=arrow_up.png width=30></span>" + data + "</div>");
									$(".outputdata").css("border-color", "#5FCC06");
								}
								MathJax.Hub.Queue(["Typeset", MathJax.Hub]); //,function () {velikost();},function () {velikost();});
								$("#mawoutput").fadeIn(1000);
								var position = $("#mawoutput").position();

								$("body").animate({scrollTop: position.top, duration: 1000});
								$("#go-top").click(function () {
									$("body").animate({scrollTop: 0});
								});
							} else {

								url = "http://um.mendelu.cz/dev-maw/common/maw_download.php?file=" + data.file + "&filename=" + data.data;

								jQuery('<form action="http://um.mendelu.cz/dev-maw/common/maw_download.php" method="post"><input type="hidden" name="file" value="' + data.file + '"/><input type="hidden" name="filename" value="' + data.data + '"/>submit<input type="submit" value="odeslat"></form>').appendTo('body').submit().remove();


							}
							setTimeout(function () {
								$("#after-form").css("display", "none");
								$("#form").css("display", "block");
								$("#form").css("visibility", "visible");
								$("#maw_calculator").css("background-color", "#5FCC06");
								<?php if ($deviceType != "computer")  : ?>
								$("#maw_calculator").css("min-width", "95%");
								$("#maw_calculator").css("margin-left", "3px");
								<?php endif; ?>
							}, 1500);
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert("There seem to be some technical problems. Please, report to marik@mendelu.cz. Thanks.");//if fails
						}
					});

				e.preventDefault(); //STOP default action
			});

			MathJax.Hub.Queue(function () {
				velikost();
			});


			function velikost() {
				/* 8.11.2013 Robert Marik: nastaveni stejne vysky pro class "blok" pokud jsou ve stejne vysce*/
				bloky = $(".inlinediv .logickyBlok");
				for (var i = 0; i < bloky.length; i++) {


					bloky.eq(i).parent().css({marginLeft: "auto", marginRight: "auto"})
				}
				for (var i = 0; i < bloky.length - 1; i++) {
					ted = bloky.eq(i).position().top;
					dalsi = bloky.eq(i + 1).position().top;

					if ((Math.abs(ted - dalsi) < 5) && ($('img').closest(bloky.eq(i)).length == 0) && ($('img').closest(bloky.eq(i + 1)).length == 0)) {
						max1 = bloky.eq(i).height();
						max2 = bloky.eq(i + 1).height();
						max = Math.max(max1, max2);
						bloky.eq(i).height(max);
						bloky.eq(i + 1).height(max);
					}
				}

			}
				</script>


		  <?php
		  include("tail.php");
		  if (($_REQUEST["auto"] == 1) && ($_REQUEST["output"] != "pdf") && false):

			  ?>

						<script>
				if ($("#autosend").length) {
					alert('has been sent already');
				} else {


					var action = true;
					if (action) {
						$("#exampleform").submit();

					}

				}
				$('<div id=autosend>sent automatically</div>').prependTo('form')
						</script>

		  <?php endif; ?>


		  <?php if (in_array($form, ["derivace", "bisection", "regula_falsi", "banach", "newton", "lineintegral", "prubeh", "integral2", "taylor", "ode", "lde2", "autsyst", "minmax3d", "geom", "mnc", "lagrange", "trap"]))  : ?>
						<script>
				$(".pdforhtml").css("display", "inline-block");
						</script>
		  <?php elseif (in_array($form, ["ineq2d", "graf", "df", "df3d", "integral", "ineq2d", "definite"])): ?>
						<script>
				$(".pdfnohtmlyes").css("display", "inline-block");
						</script>
		  <?php else: ?>
						<script>
				$(".pdfyeshtmlno").css("display", "inline-block");
						</script>
		  <?php endif; ?>


		  <?php if ($deviceType != "computer")  : ?>
						<script>
				$(".pdforhtml").css("display", "none");
				$(".pdfyeshtmlno").css("display", "none");
				$(".pdfnohtmlyes").css("display", "none");
						</script>
		  <?php endif; ?>


				<div style="clear:both;"></div>
				<div class="share-container">
<?php require("social.php"); echo $social; ?>
</div>
				<div style="clear:both;"></div>

				<script src="js/rrssb.min.js"></script>

