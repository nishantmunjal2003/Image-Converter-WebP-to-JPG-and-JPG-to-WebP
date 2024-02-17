<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Format Converter</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function disableOptions() {
            var fileInput = document.getElementById("fileToConvert");
            var webpOption = document.getElementById("webpOption");
            var jpgOption = document.getElementById("jpgOption");
            var convertButton = document.getElementById("convertButton");

            // Check if any file is selected
            if (fileInput.files.length > 0) {
                // Check the extension of the first file
                var extension = fileInput.files[0].name.split('.').pop().toLowerCase();

                // If the file extension is 'webp', disable the WebP option
                if (extension === 'webp') {
                    webpOption.disabled = true;
                    jpgOption.disabled = false;
                }
                // If the file extension is 'jpg' or 'jpeg', disable the JPG option
                else if (extension === 'jpg' || extension === 'jpeg') {
                    jpgOption.disabled = true;
                    webpOption.disabled = false;
                } else {
                    // If the file has a different extension, enable both options
                    webpOption.disabled = false;
                    jpgOption.disabled = false;
                }

                // Enable the "Convert" button
                convertButton.disabled = false;
            } else {
                // If no file is selected, disable both options and the "Convert" button
                webpOption.disabled = true;
                jpgOption.disabled = true;
                convertButton.disabled = true;
            }
        }
    </script>
</head>
<body>

<h1 align='center'>Convert JPG to WebP or WebP to JPG</h1>

<div class="container">
    <h2>Image Format Converter</h2>

    <form action="convert.php" method="post" enctype="multipart/form-data">
        <label for="fileToConvert">Choose an image file to convert:</label>
        <input type="file" name="fileToConvert[]" id="fileToConvert" accept="image/jpeg, image/png, image/gif, image/webp" multiple onchange="disableOptions()">
        <br>
        <label>Choose the output format:</label>
        <input type="radio" name="outputFormat" value="webp" id="webpOption" checked> WebP
        <input type="radio" name="outputFormat" value="jpg" id="jpgOption"> JPG
        <br>
        <button type="submit" id="convertButton" disabled>Convert</button>
    </form>


</div>

<br>

<div align="center">Continue to the <a href="https://nishantmunjal.com">Nishant Munjal</a>
</div>

</body>
</html>
