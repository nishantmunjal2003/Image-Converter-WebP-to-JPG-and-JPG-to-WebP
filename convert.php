<?php
// Function to convert image to WebP, JPG, or PNG based on the specified format
function convertImage($inputImagePath, $outputImagePath, $outputFormat) {
    $image = null;

    $ext[]=explode(".",$inputImagePath);

    // Load the image based on the format
    if ($outputFormat === 'webp') {
        if($ext[0][1]=='jpg' || $ext[0][1]=='jpeg'){
            $image = imagecreatefromjpeg($inputImagePath);
            imagewebp($image, $outputImagePath);
        }
        elseif($ext[0][1]=='png'){
            $image = imagecreatefrompng($inputImagePath);
            imagewebp($image, $outputImagePath);
        }
    } elseif ($outputFormat == 'jpg') {
        if($ext[0][1]=='png'){
            $image = imagecreatefrompng($inputImagePath);
            imagejpeg($image, $outputImagePath);
        }
        elseif($ext[0][1]=='webp') {
            $image = imagecreatefromwebp($inputImagePath);
            imagejpeg($image, $outputImagePath);
        }
    }

    // Free up memory
    if ($image) {
        imagedestroy($image);
    }
}

// Function to delete uploaded files from the server
function deleteFiles($files) {
    foreach ($files as $file) {
        unlink($file);
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if files are uploaded
    if (!empty($_FILES["fileToConvert"]["name"][0])) {
        $targetDir = "uploads/";
        $uploadedFiles = array();
        
        // Iterate through each uploaded file
        for ($i = 0; $i < count($_FILES["fileToConvert"]["name"]); $i++) {
            $inputFileName = $targetDir . basename($_FILES["fileToConvert"]["name"][$i]);
            array_push($uploadedFiles, $inputFileName);

            // Get the selected output format (webp, jpg, or png)
            $outputFormat = strtolower($_POST['outputFormat']);
            $outputFileName = $targetDir . pathinfo($_FILES["fileToConvert"]["name"][$i], PATHINFO_FILENAME) . "." . $outputFormat;

            // Check if the file is a valid image
            $imageFileType = strtolower(pathinfo($inputFileName, PATHINFO_EXTENSION));
            $validExtensions = array("jpg", "jpeg", "png", "gif", "webp");

            if (in_array($imageFileType, $validExtensions)) {
                // Move the uploaded file to the target directory
                move_uploaded_file($_FILES["fileToConvert"]["tmp_name"][$i], $inputFileName);

                // Convert image based on the selected format
                convertImage($inputFileName, $outputFileName, $outputFormat);

                // Display success message and a large download button for each file
                echo '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Image Format Converter</title>
                        <link rel="stylesheet" href="style.css">
                    </head>
                    <body>
                    ';
                echo "<div class='container'>";
                echo "<h2>Conversion Complete!</h2>";

                // Display download button for each file based on the selected option
                echo '<a href="' . $outputFileName . '" download><button class="download-button">Download Converted Image ' . ($i + 1) . '</button></a>';

                echo "</div>";
            } else {
                echo "Invalid file format. Please upload a JPG, JPEG, PNG, GIF, or WebP file.";
            }
        }

        // Add a button to delete uploaded files
        echo "<div class='container'>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='filesToDelete' value='" . implode(",", $uploadedFiles) . "'>";
        echo "<button type='submit' name='deleteFilesButton' class='delete-button'>Delete Uploaded Files</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "Error uploading files.";
    }
}
echo '<a href="index.php"><button class="convertmore-button">Convert More</button></a>';
echo "</div>";

// Handle file deletion when the delete button is clicked
if (isset($_POST['deleteFilesButton'])) {
    $filesToDelete = explode(",", $_POST['filesToDelete']);
    deleteFiles($filesToDelete);
    echo "<div class='container'>";
    echo "<p>Uploaded files deleted successfully.</p>";
    echo "</div>";
    header("Location: index.php");
}
?>