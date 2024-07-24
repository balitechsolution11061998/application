<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }
        #scanner {
            width: 300px;
            height: 300px;
            border: 4px solid #3498db;
            border-radius: 10px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        #result {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
        input[type="file"] {
            margin-top: 20px;
            padding: 10px;
            border: 2px solid #3498db;
            border-radius: 5px;
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="file"]:hover {
            background-color: #2980b9;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>
    <div id="scanner"></div>
    <div id="result">Upload a QR code image to scan.</div>
    <input type="file" id="file-input" accept="image/*">

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showToast(message, type = 'info') {
                Toastify({
                    text: message,
                    duration: 3000, // 3 seconds
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: type === 'success' ? "#4caf50" : "#f44336",
                }).showToast();
            }

            function scanQRCodeFromFile(file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = new Image();
                    img.onload = function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, img.width, img.height);

                        var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        var decoded = jsQR(imageData.data, canvas.width, canvas.height);

                        if (decoded) {
                            var qrCodeData = decoded.data;
                            document.getElementById('result').innerText = `Scanned QR Code: ${qrCodeData}`;

                            // Get CSRF token
                            var csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                            var csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                            // AJAX request to login the user
                            fetch('/login-with-qr', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    qr_code_data: qrCodeData
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showToast('Login successful!', 'success');
                                    setTimeout(() => {
                                        window.location.href = '/dashboard';
                                    }, 3000); // 3 seconds delay
                                } else {
                                    showToast(data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('An error occurred. Please try again.', 'error');
                            });
                        } else {
                            showToast('No QR code found.', 'error');
                        }
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }

            document.getElementById('file-input').addEventListener('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    scanQRCodeFromFile(file);
                }
            });

            // Optionally start the camera QR code scanner
            var html5QrCode = new Html5Qrcode("scanner");

            function onScanSuccess(decodedText, decodedResult) {
                document.getElementById('result').innerText = `Scanned QR Code: ${decodedText}`;
            }

            function onScanError(error) {
                console.warn(`QR Code scan error: ${error}`);
                document.getElementById('result').innerText = `Error scanning QR Code: ${error}`;
            }

            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 250 },
                onScanSuccess,
                onScanError
            ).catch((err) => {
                console.error(`Failed to start QR code scanner: ${err}`);
            });
        });
    </script>
</body>
</html>
