<?php

function uploadFile($file, $title) {
    // Folder to upload
    $folderUpload = "../uploads";
    $filename = basename($file["name"]);
    $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $fileNameTarget = str_replace(" ", "_", $title);
    // File path for saving
    $fileDestination = $folderUpload . "/" . $fileNameTarget . "." . $filetype;

    // Allowed file types
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'pptx'];
    
    // Check if the file type is allowed
    if (!in_array($filetype, $allowedFileTypes)) {
        return false; // Invalid file type
    }
    
    // Limit file size to 10MB
    if ($file["size"] > (1000 * 1024 * 10)) { // Change 2MB to 10MB
        return false; // File too large
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $fileDestination)) {
        return true; // Successful upload
    } else {
        return false; // Upload failed
    }
}
?>
