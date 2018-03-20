<?php

////////////////////////////////////////////////////Get Value//////////////////////////////////////////////////////////////////

	$pil=$_POST["pilihan"];
	$text=$_POST["inputt"];
	$med=$_POST["pilihan2"];
	$kunci=$_POST["inputttt"];

////////////////////////////////////////////////Caesar Chiper//////////////////////////////////////////////////////////////////

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
	return Enciphercaesar($input, 26 - $key1);
}

////////////////////////////////////////////////////poly chiper////////////////////////////////////////////////////////////////

									
function Modpoly($a, $b)
{
	return ($a % $b + $b) % $b;
}

function Cipherpoly($input, $key, $encipher)
{
	$keyLen = strlen($key);

	for ($i = 0; $i < $keyLen; ++$i)
		if (!ctype_alpha($key[$i]))
			return ""; // Error

	$output = "";
	$nonAlphaCharCount = 0;
	$inputLen = strlen($input);

	for ($i = 0; $i < $inputLen; ++$i)
	{
		if (ctype_alpha($input[$i]))
		{
			$cIsUpper = ctype_upper($input[$i]);
			$offset = ord($cIsUpper ? 'A' : 'a');
			$keyIndex = ($i - $nonAlphaCharCount) % $keyLen;
			$k = ord($cIsUpper ? strtoupper($key[$keyIndex]) : strtolower($key[$keyIndex])) - $offset;
			$k = $encipher ? $k : -$k;
			$ch = chr((Modpoly(((ord($input[$i]) + $k) - $offset), 26)) + $offset);
			$output .= $ch;
		}
		else
		{
			$output .= $input[$i];
			++$nonAlphaCharCount;
		}
	}

	return $output;
}

function Encipherpoly($input, $key)
{
	return Cipherpoly($input, $key, true);
}

function Decipherpoly($input, $key)
{
	return Cipherpoly($input, $key, false);
}

////////////////////////////////////////////////playfair chiper////////////////////////////////////////////////////////////////




////////////////////////////////////////////////transpositon Chiper///////////////////////////////////////////////////////////
	
										
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

////////////////////////////////////////////////////Mono Chiper////////////////////////////////////////////////////////////////
									
function Ciphermono($input, $oldAlphabet, $newAlphabet, &$output)
{
	$output = "";
	$inputLen = strlen($input);

	if (strlen($oldAlphabet) != strlen($newAlphabet))
		return false;

	for ($i = 0; $i < $inputLen; ++$i)
	{
		$oldCharIndex = strpos($oldAlphabet, strtolower($input[$i]));

		if ($oldCharIndex !== false)
			$output .= ctype_upper($input[$i]) ? strtoupper($newAlphabet[$oldCharIndex]) : $newAlphabet[$oldCharIndex];
		else
			$output .= $input[$i];
	}
	return $output;
	//return true;
}

function Enciphermono($input, $cipherAlphabet, &$output)
{
	$plainAlphabet = "abcdefghijklmnopqrstuvwxyz";
	//echo $input;
	//echo $cipherAlphabet;
	return Ciphermono($input, $plainAlphabet, $cipherAlphabet, $output);
}

function Deciphermono($input, $cipherAlphabet, &$output)
{
	$plainAlphabet = "abcdefghijklmnopqrstuvwxyz";
	return Ciphermono($input, $cipherAlphabet, $plainAlphabet, $output);
}
		


///////////////////////////////////////////////////////logic///////////////////////////////////////////////////////////////////

if($med=='enk')
{
	if($pil=="Caesar")
	{
		$enc=Enciphercaesar($text,$kunci);
		echo $enc;
	}
	elseif($pil=="Mono")
	{
		//$key="cyaezndfvpghjmbxoqsukwirtl";
		$chipertext;
		Enciphermono($text, $kunci, $chipertext);
		echo $chipertext;

		//echo $enc;
	}
	elseif($pil=="Playfair")
	{
		/*$key=masuk;
		$enc=Encipher($text,$key);
		echo $enc;*/
	}
	elseif($pil=="Poly")
	{
		$enc = Encipherpoly($text, $kunci);
		echo $enc;
	}
	elseif($pil=="Transpositioni")
	{
		//$key="karimun";
		$enc = Enciphertrans($text, $kunci, '-');
		echo $enc;
	}
}

elseif($med=='dek')
{
	if($pil=="Caesar")
	{
		$dec=Deciphercaesar($text,$kunci);
		echo $dec;
	}
	elseif($pil=="Mono")
	{
		//$key="cyaezndfvpghjmbxoqsukwirtl";
		$plaintext;
		Deciphermono($text, $kunci, $plaintext);
		echo $plaintext;
	}
	elseif($pil=="Playfair")
	{
		
	}
	elseif($pil=="Poly")
	{
		$dec = Decipherpoly($text, $kunci);
		echo $dec;
	}
	elseif($pil=="Transpositioni")
	{
		//$key="karimun";
		$dec = Deciphertrans($text, $kunci);
		echo $dec;
	}
}

elseif($med=='enk_file')
{
	if($pil=="Caesar")
	{
		$myfile = fopen($text, "r") or die("Unable to open file!");
		//echo fread($myfile,filesize("plaintext.txt"));
		$enk=Enciphercaesar(fread($myfile,filesize($text)),$kunci);
		echo $enk;
		fclose($myfile);
	}
	elseif($pil=="Mono")
	{
		//$key="cyaezndfvpghjmbxoqsukwirtl";
		$myfile = fopen($text, "r") or die("Unable to open file!");
		$plaintext;
		$plaintext=Enciphermono(fread($myfile,filesize($text)), $kunci, $plaintext);
		echo $plaintext;
		fclose($myfile);
	}
	elseif($pil=="Playfair")
	{
		
	}
	elseif($pil=="Poly")
	{
		$myfile = fopen($text, "r") or die("Unable to open file!");
		$enk=Encipherpoly(fread($myfile,filesize($text)),$kunci);
		echo $enk;
		fclose($myfile);
	}
	elseif($pil=="Transpositioni")
	{
		//$key="karimun";
		$myfile = fopen($text, "r") or die("Unable to open file!");
		$enk = Enciphertrans(fread($myfile,filesize($text)),$kunci);
		echo $enk;
		fclose($myfile);
	}
}
else
{
	if($pil=="Caesar")
	{
		$myfile = fopen($text, "r") or die("Unable to open file!");
		//echo fread($myfile,filesize("plaintext.txt"));
		$dec=Deciphercaesar(fread($myfile,filesize($text)),$kunci);
		echo $dec;
		fclose($myfile);
	}
	elseif($pil=="Mono")
	{
		//$key="cyaezndfvpghjmbxoqsukwirtl";
		$$myfile = fopen($text, "r") or die("Unable to open file!");
		$plaintext;
		$plaintext=Deciphermono(fread($myfile,filesize($text)), $kunci, $plaintext);
		echo $plaintext;
		fclose($myfile);
	}
	elseif($pil=="Playfair")
	{
		
	}
	elseif($pil=="Poly")
	{
		$myfile = fopen($text, "r") or die("Unable to open file!");
		$dec=Decipherpoly(fread($myfile,filesize($text)),$kunci);
		echo $dec;
		fclose($myfile);
	}
	elseif($pil=="Transpositioni")
	{
		//$key="karimun";
		$myfile = fopen($text, "r") or die("Unable to open file!");
		$dec = Deciphertrans(fread($myfile,filesize($text)),$kunci);
		echo $dec;
		fclose($myfile);
	}
}
?>