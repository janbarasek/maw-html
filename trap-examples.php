<?php

examples("1,2,3,4,5");

function bind_examples($id, $tex, $math, $a, $b, $n)
{
	echo '$("#e-' . $id . '").tooltip({ content: \'<img src="http://um.mendelu.cz/mathtex/mathtex.php?' . $tex . '">\' });';
	echo '$("#e-' . $id . '").bind("click", function() {';
	echo '$("#exampleform")[0].reset();';


	echo '$("#in-funkce").val("' . $math . '");';
	echo '$("#in-a").val("' . $a . '");';
	echo '$("#in-b").val("' . $b . '");';
	echo '$("#in-n").val("' . $n . '");';
	echo '$("#exampleform").submit();});';
	echo "\n";
}

?>

<script>

	window.onload = function () {
		<?php
		bind_examples(1, '\\\\int_0^{\\\\pi} \\\\sin^2(x) \\\\,\\\\mathrm{d}x', "sin(x)^2", 0, "pi", 4);
		bind_examples(2, '\\\\int_0^{1} 2\\\\sqrt {x} \\\\,\\\\mathrm{d}x', "2*sqrt(x)", 0, 1, 4);
		bind_examples(3, '\\\\int_1^{3} 2x^2+1 \\\\,\\\\mathrm{d}x', "2*x^2+1", 1, 3, 4);
		bind_examples(4, '\\\\int_1^{e} x\\\\ln(x) \\\\,\\\\mathrm{d}x', "x*ln(x)", 1, "e", 4);
		bind_examples(5, '\\\\int_0^{1} e^{-\\\\frac 12 x^2} \\\\,\\\\mathrm{d}x', "exp(-1/2 * x^2)", 0, 1, 4);
		?>
	};

</script>

