<?php
function upload_file($file, $userid){   
	// Configuration - Your Options
	$allowed_filetypes = array('.jpg','.gif','.bmp','.png'); // These will be the types of file that will pass the validation.
	$max_filesize = 2024288; // Maximum filesize in BYTES (currently 0.5MB).
	$upload_path = './profile_pics/'; // The place the files will be uploaded to (currently a 'files' directory).
	
	$filename = $file['userfile']['name']; // Get the name of the file (including file extension).
	
	$ext = substr($filename, strlen($filename)-4, strlen($filename)-1); // Get the extension from the filename.
	
	// Check if the filetype is allowed, if not DIE and inform the user.
	if(!in_array($ext,$allowed_filetypes))
	echo '<div class = "error">The file you attempted to upload is not allowed. Use .jpg, .gif, .bmp, .png</div>';
	
	// Now check the filesize, if it is too large then DIE and inform the user.
	if(filesize($file['userfile']['tmp_name']) > $max_filesize)
	echo '<div class = "error">The file you attempted to upload is too large.</div>';
	
	// Check if we can upload to the specified path, if not DIE and inform the user.
	if(!is_writable($upload_path))
	echo '<div class = "error">You cannot upload to the specified directory.</div>';
	
	// Upload the file to your specified path.
	if(move_uploaded_file($file['userfile']['tmp_name'],$upload_path . $userid))
	echo '<div class = "notice">Your profile picture was uploaded</div>'; // It worked.
	else
	echo '<div class = "error">There was an error during the file upload.  Please try again.</div>'; // It failed :(.
	}
	?>
