<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 						    Download_zip - Page 					    //
//																		//
//////////////////////////////////////////////////////////////////////////

	//creation de deux variable avec l'emplacement du fichier a zipper et emplacement du fichier avec le nom du zip
	$folder = 'document/photo_balade/'.$_GET['id'];  
	$dest = 'document/photo_balade/Balade_n_'.$_GET['id'].'.zip';
	// fonction creat_zip avec comme parametre la viable comptenant l'emplacement du fichier a zipper et un autre avec emplacement du fichier avec le nom du zip
	function create_zip($folder, $destination) {
		$valid_files = get_files($folder);
		if(count($valid_files)) {       
			$zip = new ZipArchive(); // on cree un variable zip qui comptient la class Zip archive
			if($zip->open($destination, ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			//ajout les fichier 
			foreach($valid_files as $file) {
				if (file_exists($file) && is_file($file)){
					$zip->addFile($file,$file);
				}
			}
			// on ferme la varible zip
			$zip->close();
			return file_exists($destination);
		}
		else
		{
			return false;
		}
	}
	
	function get_files($folder){
		$valid_files = array();
		$files = scandir($folder);
		foreach($files as $file) {
			if(substr($file, 0, 1) == "." || !is_readable($folder . '/' . $file)) {
				continue;
			}
			if(is_dir($file)){
				array_merge($valid_files, get_files($folder . '/' . $file));
			} else {
				$valid_files[] = $folder . '/' . $file;
			}
		}
		return $valid_files;
	}

	if(file_exists($dest)){
		if(is_dir($dest)) {
			rmdir($dest);
		} else {
			unlink($dest);  
		}
	}
	create_zip($folder, $dest);
	header("location: ".$dest);
?> 