<?php

$target_directory = "../../../IMAGES/ADMIN/profile-picture/";
$error_file = "";

if (!empty($_FILES['file'])) {
    $file_data = $_FILES['file'];
    $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
    $max_size = 5242880; // 5MB

    if (in_array($file_data['type'], $allowed_types) && $file_data['size'] <= $max_size) {
        $original_filename = basename($file_data['name']);
        $target_file = $target_directory . $original_filename;

        if (move_uploaded_file($file_data["tmp_name"], $target_file)) {
            echo "1"; // Successful upload
        } else {
            echo "File could not be moved.";
        }
    } else {
        echo "Invalid file type or file size exceeded.";
    }
} else {
    echo "No file selected.";
}
