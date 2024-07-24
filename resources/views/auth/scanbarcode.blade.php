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

    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
