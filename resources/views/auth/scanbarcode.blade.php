<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .scanner-container {
            text-align: center;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 500px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .scanner {
            border: 3px solid #3498db;
            border-radius: 10px;
            width: 100%;
            height: 300px;
            margin: 0 auto;
            position: relative;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .result {
            margin-top: 20px;
        }

        #result-text {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="scanner-container">
        <h1>QR Code Scanner</h1>
        <div id="scanner" class="scanner">
            <!-- QR Code Scanner will be initialized here -->
        </div>
        <div id="result" class="result">
            <p id="result-text">Scan a QR code to see the result here.</p>
        </div>
    </div>

    <!-- Use alternative script URL if needed -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the QR code scanner
            var html5QrCode = new Html5Qrcode("scanner");

            // Success callback
            function onScanSuccess(decodedText, decodedResult) {
                // Handle the result here
                document.getElementById('result-text').innerText = `Scanned QR Code: ${decodedText}`;
                // Optionally, stop the scanner
                html5QrCode.stop().then(() => {
                    console.log("QR Code scanning stopped.");
                }).catch((err) => {
                    console.log("Failed to stop scanning:", err);
                });
            }

            // Error callback
            function onScanError(error) {
                // Handle scanning error here
                console.warn(`QR Code scan error: ${error}`);
            }

            // Start scanning
            html5QrCode.start(
                { facingMode: "environment" }, // Choose the camera facing mode
                {
                    fps: 10,    // Frame rate
                    qrbox: 250  // Size of the scanning box
                },
                onScanSuccess,
                onScanError
            ).catch((err) => {
                console.error(`Failed to start QR code scanner: ${err}`);
            });
        });
    </script>
</body>
</html>
