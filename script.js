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