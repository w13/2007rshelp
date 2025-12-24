<?php

	// Global functions file. Most of these are only used by compare.php,
	// but they may prove useful for other parts of Zybez. In any case,
	// here they are.

	// Quick-find: qf_qf
	/*
	 * Table of quick-find comment codes (search for these to
	 * find the code for whatever is listed).
	 * First one is numeric code, second is descriptive code, third is
	 * the description :)
	 *	qf_qf			This quick-find table.
	 *	qf_negf			The `negf' function.
	 *	qf_neutf		The `neutf' function.
	 *	qf_posf			The `posf' function.
	 *	qf_boolf		The `boolf' function.
	 *	qf_negboolf		The `negboolf' function.
	 *	qf_posboolf		The `posboolf' function.
	 *	qf_percentf		The `percentf' function.
	 *	qf_difff		The `difff' function.
	 *	qf_gpf			The `gpf' function.
	 *	qf_gpdifff		The `gpdifff' function.
	 *	qf_kgf			The `kgf' function.
	 *	qf_kgdifff		The `kgdifff' function.
	 */

	// Quick-find: qf_negf

	// string negf (mixed $d)
	//
	// Wraps a span with class `negative' around the string value of $d.
	function negf ($d)
	{
		return "<span class=\"negative\">" . strval ($d) . "</span>";
	}

	// Quick-find: qf_neutf

	// string neutf (mixed $d)
	//
	// Wraps a span with class `neutral' around the string value of $d.
	function neutf ($d)
	{
		return "<span class=\"neutral\">" . strval ($d) . "</span>";
	}

	// Quick-find: qf_posf

	// string posf (mixed $d)
	//
	// Wraps a span with class `positive' around the string value of $d.
	function posf ($d)
	{
		return "<span class=\"positive\">" . strval ($d) . "</span>";
	}

	// Quick-find: qf_boolf

	// string boolf (bool $b)
	//
	// Returns "Yes" if $b is a bool and true, "No" if it is a bool and
	// false, or $b if it is not a bool.
	function boolf ($b)
	{
		if ($b === true)
		{
			return "Yes";
		}
		elseif ($b === false)
		{
			return "No";
		}
		else
		{
			return $b;
		}
	}

	// Quick-find: qf_negboolf

	// string negboolf (bool $b)
	//
	// Returns negf("Yes") if $b is a bool and true, posf("No") if it is
	// a bool and false, or $b if it is not a bool.
	function negboolf ($b)
	{
		if ($b === true)
		{
			return negf ("Yes");
		}
		elseif ($b === false)
		{
			return posf ("No");
		}
		else
		{
			return $b;
		}
	}

	// Quick-find: qf_posboolf

	// string posboolf (bool $b)
	//
	// Returns posf("Yes") if $b is a bool and true, negf("No") if it is
	// a bool and false, or $b if it is not a bool.
	function posboolf ($b)
	{
		if ($b === true)
		{
			return posf ("Yes");
		}
		elseif ($b === false)
		{
			return negf ("No");
		}
		else
		{
			return $b;
		}
	}

	// Quick-find: qf_percentf

	// string percentf (float $n1, float $n2, bool $inv = false)
	//
	// Calculates the percentage that $n1 is of $n2 (unless $n2 is 0, in
	// which case "N/A" is returned), formats it with two decimals, inserts
	// thousands-separators, appends a %-sign and colour-codes it as follows
	// if $inv is false:
	//	* if $n1 and $n2 are equal, neutf is used.
	//	* if $n1 is greater than $n2, posf is used.
	//	* if $n1 is lower than $n2, negf is used.
	// ..And as follows if $inv is true:
	//	* if $n1 and $n2 are equal, neutf is used.
	//	* if $n1 is greater than $n2, negf is used.
	//	* if $n1 is lower than $n2, posf is used.
	function percentf ($n1, $n2, $inv = false)
	{
		if ($n2 == 0)
		{
			return "<span title=\"Division by zero.\" style=\"font-style:italic;\">N/A</span>";
		}

		if ($n1 < 0 || $n2 < 0)
		{
			return "<span title=\"Percentage based on negative values does not make sense.\" style=\"font-style:italic;\">N/A</span>";
		}

		$per = number_format (round ($n1 / $n2 * 100, 2), 2) . "%";

		if ($n1 == $n2)
		{
			return neutf ($per);
		}
		elseif ($n1 > $n2)
		{
			return (($inv !== true) ? (posf ($per)) : (negf ($per)));
		}
		else
		{
			return (($inv !== true) ? (negf ($per)) : (posf ($per)));
		}
	}

	// Quick-find: qf_difff

	// string difff (int $n1, int $n2 = 0, bool $omitplus = false,
	//               bool $inv = false)
	//
	// Calculates difference between $n1 and $n2, prepends a "+" if it is
	// positive and $omitplus isn't true, and colour-codes it as follows
	// if $inv is false:
	//	* if the difference is 0, neutf is used.
	//	* if the difference is greater than 0, posf is used.
	//	* if the difference is lower than 0 (i.e. $n2 > $n1),
	//	  negf is used.
	// ...And as follows if $inv is true:
	//	* if the difference is 0, neutf is used.
	//	* if the difference is greater than 0, negf is used.
	//	* if the difference is lower than 0 (i.e. $n2 > $n1),
	//	  posf is used.
	function difff ($n1, $n2 = 0, $omitplus = false, $inv = false)
	{
		$diff = strval ($n1 - $n2);
		if ($n1 == $n2)
		{
			return neutf ($diff);
		}
		elseif ($n1 > $n2)
		{
			if ($omitplus !== true)
			{
				$diff = "+" . $diff;
			}

			return (($inv !== true) ? (posf ($diff)) : (negf ($diff)));
		}
		else
		{
			return (($inv !== true) ? (negf ($diff)) : (posf ($diff)));
		}
	}

	// Quick-find: qf_gpf

	// string gpf (int $g)
	//
	// Inserts thousands-separators and appends "gp" to $g.
	function gpf ($g)
	{
		return number_format ($g) . "gp";
	}

	// Quick-find: qf_gpdifff

	// string gpdifff (int $g1, int $g2 = 0, bool $omitplus = false,
	//                 bool $inv = false)
	//
	// Like difff, but applies gpf before colour-coding the output.
	function gpdifff ($g1, $g2 = 0, $omitplus = false, $inv = false)
	{
		$diff = gpf ($g1 - $g2);
		if ($g1 == $g2)
		{
			return neutf ($diff);
		}
		elseif ($g1 > $g2)
		{
			if ($omitplus !== true)
			{
				$diff = "+" . $diff;
			}

			return (($inv !== true) ? (posf ($diff)) : (negf ($diff)));
		}
		else
		{
			return (($inv !== true) ? (negf ($diff)) : (posf ($diff)));
		}
	}

	// Quick-find: qf_kgf

	// string kgf (float $k)
	//
	// Inserts thousands-separators and appends " kg" to $k.
	function kgf ($k)
	{
		return number_format ($k, 3) . "kg";
	}

	// Quick-find: qf_kgdifff

	// string kgdifff (float $k1, float $k2 = 0, bool $inv = false)
	//
	// Like difff, but applies kgf before colour-coding the output.
	function kgdifff ($k1, $k2 = 0, $omitplus = false, $inv = false)
	{
		$diff = kgf ($k1 - $k2);
		if ($k1 == $k2)
		{
			return neutf ($diff);
		}
		elseif ($k1 > $k2)
		{
			if ($omitplus !== true)
			{
				$diff = "+" . $diff;
			}

			return (($inv !== true) ? (posf ($diff)): (negf ($diff)));
		}
		else
		{
			return (($inv !== true) ? (negf ($diff)): (posf ($diff)));
		}
	}

?>
