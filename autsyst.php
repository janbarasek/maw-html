<span class="nadpis">
<?php echo __("Singular points of autonomous systems");
$fcef = rawurldecode($_REQUEST["fcef"]);
$fceg = rawurldecode($_REQUEST["fceg"]);
$pointx = rawurldecode($_REQUEST["pointx"]);
$pointy = rawurldecode($_REQUEST["pointy"]);
$action = rawurldecode($_REQUEST["akce"]);

if ($fcef == "") {
	$fcef = "x*(4-x-y)";
	$fceg = "y*(9-2*x-3*y)";
	$pointx = "3";
	$pointy = "1";
	$action = 0;
}

if ($action == 0) {
	$check0 = "checked=\"checked\"";
	$check1 = "";
}

if ($action == 1) {
	$check1 = "checked=\"checked\"";
	$check0 = "";
}


?>
</span>

<span style="font-weight: bold;"></span>
<?php maw_before_form() ?>
<form <?php formmethod(); ?>
	<?php echo $onsubmit; ?>
		action="<?php echo($server); ?>/autsyst/autsyst.php"
		name="exampleform" id="exampleform">
	<?php polejazyka($lang); ?>

	<span style="font-style: italic;">x' =</span> <input name="funkcef" value="<?php echo $fcef; ?>" title=""
																											 id="in-funkcef">
	<input value="<?php echo(__("Editor")); ?>" onclick="edit('funkcef')" type="button" class="tlacitko editor">
	<input value="<?php echo(__("Preview")); ?>" title="<?php echo($previewmsg); ?>" onclick="previewb('funkcef')"
				 type="button" class="tlacitko">

	&nbsp; &nbsp; &nbsp; &nbsp; <span style="font-style: italic;"><br>

y' =</span> <input name="funkceg" value="<?php echo $fceg; ?>" title="" id="in-funkceg">
	<input value="<?php echo(__("Editor")); ?>" onclick="edit('funkceg')" type="button" class="tlacitko editor">
	<input value="<?php echo(__("Preview")); ?>" title="<?php echo($previewmsg); ?>" onclick="previewb('funkceg')"
				 type="button" class="tlacitko">

	<?php hint_preview(); ?>

	<fieldset class="vnitrni">
		<legend class="podnadpis">
		<?php echo(__("What to do")); ?>
		</legend>
		<input <?php echo $check0 ?> name="akce" value="0" type="radio">
	  <?php echo __("find Jacobi matrix at stationary point"); ?>
		&nbsp;&nbsp;&nbsp;
		<span style="display:inline-block"><span style="font-style: italic;">x</span>=&nbsp;<input name="xs"
																																															 value="<? echo $pointx; ?>"
																																															 size="5"></span>
		&nbsp;
		&nbsp;
		<span style="display:inline-block">
<span style="font-style: italic;">y</span>=&nbsp;
<input name="ys" value="<? echo $pointy; ?>" size="5">
</span>
		<br>
		<br>

		<input <?php echo $check1 ?> name="akce" value="1" type="radio">
	  <?php echo __('use computer to find stationary points first (this may fail to find all stationary points, however)'); ?>
		<br>
	</fieldset>
	<?php echo $submitbutton; ?>

</form><?php maw_after_form(); ?>
<?php history("autsyst", $server);


?>

<script>
	$(document).ready(function () {
		$("#in-funkcef").tooltip({content: '<img src="http://um.mendelu.cz/mathtex/mathtex.php?\\begin{cases} x^{\\prime}={\\color{red}f(x,y)}\\\\ y^\\prime=g(x,y)\\end{cases}">'});
		$("#in-funkceg").tooltip({content: '<img src="http://um.mendelu.cz/mathtex/mathtex.php?\\begin{cases} x^{\\prime}={f(x,y)}\\\\ y^\\prime={\\color{red}g(x,y)}\\end{cases}">'});
	});
</script>
