<?php 

class ZipHelper
{
	public static function decompress($filename, $destination)
	{
		$zip = new ZipArchive; 
		$res = $zip->open($filename);
		if ($res === true) {
			if (is_dir($destination)) {
				$zip->extractTo($destination);
		    $zip->close();
		    
		    return true;
			}
		}

		return false;
	}

	public static function exDecompress($filename, $destination)
	{ 
		$info = pathinfo($filename);
		$newDir = $destination.'/'.$info['filename'];

		$zip = zip_open($filename); //var_dump($filename); exit;
		if ($zip) {
		  if( !is_dir($newDir) ) mkdir($newDir);
		  
		  while ($entry = zip_read($zip)) {                  
	      $fp = fopen($newDir."/".zip_entry_name($entry), "w");                
	      if (zip_entry_open($zip, $entry, "r")) {
	         $buf = zip_entry_read($entry, zip_entry_filesize($entry));
	         fwrite($fp,"$buf");
	         zip_entry_close($entry);
	         fclose($fp);
	         break;
	      }
		  }
		  zip_close($zip);
		}
	}
}