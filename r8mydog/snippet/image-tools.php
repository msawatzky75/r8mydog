<?php
include "../lib/image-resize.php";

function file_upload_path($original_filename, $upload_subfolder_name = '../image/post')
{
	$current_folder = dirname(__FILE__);
	$path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
	return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path)
{
	$allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
	$allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

	$actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
	$actual_mime_type        = getimagesize($temporary_path)['mime'];

	$file_extension_is_valid = in_array(strtolower($actual_file_extension), $allowed_file_extensions);
	$mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

	return $file_extension_is_valid && $mime_type_is_valid;
}
?>
