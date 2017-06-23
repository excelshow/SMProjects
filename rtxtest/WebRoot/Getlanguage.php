<?php

function IsChLanguage()
{

	$file_language="..\language.txt";
	$fp=fopen($file_language,'r');

	$buffer=fgets($fp,4096);
	if ($buffer=="zh-cn")
	{
		fclose($fp);
			
		return 1;
	}
	
	fclose($fp);
	return 0;
}

?>