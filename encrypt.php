<?php
	function Cipher($ch,$key1)
	{
		if (!ctype_alpha($ch))
			return $ch;

		$offset = ord(ctype_upper($ch) ? 'A' : 'a');
		return chr(fmod(((ord($ch) + $key1) - $offset), 26) + $offset);
	}

	function Encipher($input,$key1)
	{
		$output = "";

		$inputArr = str_split($input);
		foreach ($inputArr as $ch)
			$output .= Cipher($ch, $key1);

		return $output;
	}

	function Decipher($input,$key1)
	{
		return Encipher($input, 26 - $key1);
	}

	$pil=$_POST["pilihan"];
	$text=$_POST["inputt"];
	$med=$_POST["pilihan2"];

	if($med=='enk')
	{
		if($pil=="Caesar")
		{
			$enc=Encipher($text,5);
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
			
		}
	}

	else
	{
		if($pil=="Caesar")
		{
			$dec=Decipher($text,5);
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
			
		}
	}
?>