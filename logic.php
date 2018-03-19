<?php

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

////////////////////////////////////////////////playfair chiper////////////////////////////////////////////////////////////////

/*function Mod($a, $b)
{
	return ($a % $b + $b) % $b;
}

function Create2DArray($rowCount, $colCount) {
	$arr = new $char[rowCount];

	for ($i = 0; $i < $rowCount; ++$i)
		$arr[$i] = new $char[colCount];

	return $arr;
}

function ToUpper($str) {
	$output = $str;
	$strLen = str.size();

	for ($i = 0; $i < strLen; ++$i)
		$output[$i] = strtoupper($output[$i]);

	return $output;
}

function RemoveChar($str, $ch) {
	$output = $str;

	for ($i = 0; $i < $output.size(); ++$i)
		if ($output[$i] == $ch)
			$output = $output.erase($i, 1);

	return $output;
}

function vector(int) FindAllOccurrences($str, $value)
{
	vector(int) $indexes;

	$index = 0;
	while (($index = $str.find($value, $index)) != -1)
		$indexes.push_back($index++);

	return $indexes;
}

function RemoveAllDuplicates($str, vector<int> $indexes)
{
	$retVal = $str;

	for ($i = $indexes.size() - 1; $i >= 1; $i--)
		$retVal = $retVal.erase($indexes[$i], 1);

	return $retVal;
}

function GenerateKeySquare($key)
{
	&&$keySquare = Create2DArray(5, 5);
	$defaultKeySquare = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
	$tempKey = $key.empty() ? "CIPHER" : ToUpper(key);

	tempKey = RemoveChar(tempKey, 'J');
	tempKey += defaultKeySquare;

	for (int i = 0; i < 25; ++i)
	{
		vector<int> indexes = FindAllOccurrences(tempKey, defaultKeySquare[i]);
		tempKey = RemoveAllDuplicates(tempKey, indexes);
	}

	tempKey = tempKey.substr(0, 25);

	for (int i = 0; i < 25; ++i)
		keySquare[(i / 5)][(i % 5)] = tempKey[i];

	return keySquare;
}

function GetPosition(char** keySquare, char ch, int* row, int* col)
{
	if (ch == 'J')
		GetPosition(keySquare, 'I', row, col);

	for (int i = 0; i < 5; ++i)
		for (int j = 0; j < 5; ++j)
			if (keySquare[i][j] == ch)
			{
				*row = i;
				*col = j;
				return;
			}
}

function SameRow(char** keySquare, int row, int col1, int col2, int encipher)
{
	return new char[2] { keySquare[row][Mod((col1 + encipher), 5)], keySquare[row][Mod((col2 + encipher), 5)] };
}

function SameColumn(char** keySquare, int col, int row1, int row2, int encipher)
{
	return new char[2] { keySquare[Mod((row1 + encipher), 5)][col], keySquare[Mod((row2 + encipher), 5)][col] };
}

function SameRowColumn(char** keySquare, int row, int col, int encipher)
{
	return new char[2] { keySquare[Mod((row + encipher), 5)][Mod((col + encipher), 5)], keySquare[Mod((row + encipher), 5)][Mod((col + encipher), 5)] };
}

function DifferentRowColumn(char** keySquare, int row1, int col1, int row2, int col2)
{
	return new char[2] { keySquare[row1][col2], keySquare[row2][col1] };
}

function RemoveOtherChars(string input)
{
	string output = input;
	int strLen = input.size();

	for (int i = 0; i < strLen; ++i)
		if (!isalpha(output[i]))
			output = output.erase(i, 1);

	return output;
}

function AdjustOutput(string input, string output)
{
	string retVal = output;
	int strLen = input.size();

	for (int i = 0; i < strLen; ++i)
	{
		if (!isalpha(input[i]))
			retVal = retVal.insert(i, 1, input[i]);

		if (islower(input[i]))
			retVal[i] = strtolower(retVal[i]);
	}

	return $retVal;
}

function Cipher($input, $key, bool encipher)
{
	$retVal = "";
	&&$keySquare = GenerateKeySquare($key);
	$tempInput = RemoveOtherChars($input);
	$e = $encipher ? 1 : -1;
	$tempInputLen = $tempInput.size();

	if (($tempInputLen % 2) != 0)
		$tempInput += "X";

	for ($i = 0; $i < $tempInputLen; $i += 2)
	{
		$row1 = 0;
		$col1 = 0;
		$row2 = 0;
		$col2 = 0;

		GetPosition($keySquare, strtoupper($tempInput[$i]), &row1, &col1);
		GetPosition($keySquare, strtoupper($tempInput[$i + 1]), &row2, &col2);

		if ($row1 == $row2 && $col1 == $col2)
		{
			$retVal += string(SameRowColumn($keySquare, $row1, $col1, $e), 2);
		}
		else if ($row1 == $row2)
		{
			$retVal += string(SameRow($keySquare, $row1, $col1, $col2, $e), 2);
		}
		else if ($col1 == $col2)
		{
			$retVal += string(SameColumn($keySquare, $col1, $row1, $row2, $e), 2);
		}
		else
		{
			$retVal += string(DifferentRowColumn($keySquare, $row1, $col1, $row2, $col2), 2);
		}
	}

	$retVal = AdjustOutput($input, $retVal);

	return $retVal;
}

function Encipher($input, $key)
{
	return Cipher($input, $key, true);
}

function Decipher($input, $key)
{
	return Cipher($input, $key, false);
}*/


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

	return true;
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
		
////////////////////////////////////////////////////Get Value//////////////////////////////////////////////////////////////////

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
			$key="cyaezndfvpghjmbxoqsukwirtl";
			$chipertext;
			Enciphermono($text, $key, $chipertext);
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
			$key="cyaezndfvpghjmbxoqsukwirtl";
			$plaintext;
			Deciphermono($text, $key, $plaintext);
			echo $plaintext;
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