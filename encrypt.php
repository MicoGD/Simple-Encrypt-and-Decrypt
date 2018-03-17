<?php
	function Ciphercaesar($ch,$key1)
	{
		if (!ctype_alpha($ch))
			return $ch;

		$offset = ord(ctype_upper($ch) ? 'A' : 'a');
		return chr(fmod(((ord($ch) + $key1) - $offset), 26) + $offset);
	}

	function Enciphercaesar($input,$key1)
	{
		$output = "";

		$inputArr = str_split($input);
		foreach ($inputArr as $ch)
			$output .= Ciphercaesar($ch, $key1);

		return $output;
	}

	function Deciphercaesar($input,$key1)
	{
		return Encipher($input, 26 - $key1);
	}
	
										
class KeyValuePair
{
	public $Key;
	public $Value;
}

function compare($first, $second) {
	return strcmp($first->Value, $second->Value);
}

function GetShiftIndexes($key)
{
	$keyLength = strlen($key);
	$indexes = array();
	$sortedKey = array();
	$i;

	for ($i = 0; $i < $keyLength; ++$i) {
		$pair = new KeyValuePair();
		$pair->Key = $i;
		$pair->Value = $key[$i];
		$sortedKey[] = $pair;
	}

	usort($sortedKey, 'compare');
	$i = 0;

	for ($i = 0; $i < $keyLength; ++$i)
		$indexes[$sortedKey[$i]->Key] = $i;

	return $indexes;
}

function Enciphertrans($input, $key, $padChar)
{
	$output = "";
	$totalChars = strlen($input);
	$keyLength = strlen($key);
	$input = ($totalChars % $keyLength == 0) ? $input : str_pad($input, $totalChars - ($totalChars % $keyLength) + $keyLength, $padChar, STR_PAD_RIGHT);
	$totalChars = strlen($input);
	$totalColumns = $keyLength;
	$totalRows = ceil($totalChars / $totalColumns);
	$rowChars = array(array());
	$colChars = array(array());
	$sortedColChars = array(array());
	$currentRow = 0; $currentColumn = 0; $i = 0; $j = 0;
	$shiftIndexes = GetShiftIndexes($key);

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalColumns;
		$currentColumn = $i % $totalColumns;
		$rowChars[$currentRow][$currentColumn] = $input[$i];
	}

	for ($i = 0; $i < $totalRows; ++$i)
		for ($j = 0; $j < $totalColumns; ++$j)
			$colChars[$j][$i] = $rowChars[$i][$j];

	for ($i = 0; $i < $totalColumns; ++$i)
		for ($j = 0; $j < $totalRows; ++$j)
			$sortedColChars[$shiftIndexes[$i]][$j] = $colChars[$i][$j];

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalRows;
		$currentColumn = $i % $totalRows;
		$output .= $sortedColChars[$currentRow][$currentColumn];
	}

	return $output;
}

function Deciphertrans($input, $key)
{
	$output = "";
	$keyLength = strlen($key);
	$totalChars = strlen($input);
	$totalColumns = ceil($totalChars / $keyLength);
	$totalRows = $keyLength;
	$rowChars = array(array());
	$colChars = array(array());
	$unsortedColChars = array(array());
	$currentRow = 0; $currentColumn = 0; $i = 0; $j = 0;
	$shiftIndexes = GetShiftIndexes($key);

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalColumns;
		$currentColumn = $i % $totalColumns;
		$rowChars[$currentRow][$currentColumn] = $input[$i];
	}

	for ($i = 0; $i < $totalRows; ++$i)
		for ($j = 0; $j < $totalColumns; ++$j)
			$colChars[$j][$i] = $rowChars[$i][$j];

	for ($i = 0; $i < $totalColumns; ++$i)
		for ($j = 0; $j < $totalRows; ++$j)
			$unsortedColChars[$i][$j] = $colChars[$i][$shiftIndexes[$j]];

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalRows;
		$currentColumn = $i % $totalRows;
		$output .= $unsortedColChars[$currentRow][$currentColumn];
	}

	return $output;
}
		


	$pil=$_POST["pilihan"];
	$text=$_POST["inputt"];
	$med=$_POST["pilihan2"];

	if($med=='enk')
	{
		if($pil=="Caesar")
		{
			$enc=Enciphercaesar($text,5);
			echo $enc;
		}
		elseif($pil=="Mono")
		{
			
		}
		elseif($pil=="Playfair")
		{
			
		}
		elseif($pil=="Poly")
		{
			
		}
		elseif($pil=="Transpositioni")
		{
			$key="karimun";
			$enc = Enciphertrans($text, $key, '-');
			echo $enc;
		}
	}

	else
	{
		if($pil=="Caesar")
		{
			$dec=Deciphercaesar($text,5);
			echo $dec;
		}
		elseif($pil=="Mono")
		{
			
		}
		elseif($pil=="Playfair")
		{
			
		}
		elseif($pil=="Poly")
		{
			
		}
		elseif($pil=="Transpositioni")
		{
			$key="karimun";
			$dec = Deciphertrans($text, $key);
			echo $dec;
		}
	}
?>