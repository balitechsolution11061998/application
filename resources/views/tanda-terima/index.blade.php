<x-default-layout>
    <style>
        .container {
            margin-top: 50px;
        }
        #result, #xmlOutput {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
    </style>

    <div class="container">
        <h2>Upload PDF and Extract QR Codes</h2>
        <form id="uploadForm" class="mt-4">
            <div class="form-group">
                <label for="pdfFile">Upload PDF File:</label>
                <input type="file" id="pdfFile" name="pdf" accept="application/pdf" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <div id="result"></div>
        <div id="xmlOutput"></div>

        <h2 class="mt-5">Uploaded Tax Invoices</h2>
        <table id="invoicesTable" class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th>No Faktur</th>
                    <th>Nama Penjual</th>
                    <th>Tanggal Faktur</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by DataTables -->
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.min.js"></script>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const fileInput = document.getElementById('pdfFile');
            const file = fileInput.files[0];
            if (file) {
                readPDF(file);
            } else {
                toastr.error('Please select a PDF file.');
            }
        });

        function readPDF(file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const typedArray = new Uint8Array(event.target.result);
                pdfjsLib.getDocument(typedArray).promise.then(function(pdf) {
                    processPages(pdf, 1);
                });
            };
            reader.readAsArrayBuffer(file);
        }

        function processPages(pdf, pageNumber) {
            if (pageNumber > pdf.numPages) {
                return;
            }
            pdf.getPage(pageNumber).then(function(page) {
                const viewport = page.getViewport({
                    scale: 2.0
                });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(function() {
                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height);
                    if (code) {
                        document.getElementById('result').innerText = 'QR Code Link: ' + code.data;
                        fetchDataFromLink(code.data);
                    }
                    processPages(pdf, pageNumber + 1);
                });
            });
        }

        function fetchDataFromLink(url) {
            const proxyUrl = 'https://api.allorigins.win/get?url=';

            fetch(proxyUrl + url)
                .then(response => response.json())
                .then(data => {
                    const xml = convertToXML(data);
                    document.getElementById('xmlOutput').textContent = xml;
                    sendXMLToDatabase(data.contents);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('xmlOutput').textContent = 'Error fetching data: ' + error;
                    toastr.error('Error fetching data: ' + error);
                });
        }

        function convertToXML(obj, rootElement = 'root') {
            let xml = `<${rootElement}>`;

            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    const value = obj[key];
                    if (typeof value === 'object' && value !== null) {
                        xml += convertToXML(value, key);
                    } else {
                        xml += `<${key}>${value}</${key}>`;
                    }
                }
            }

            xml += `</${rootElement}>`;
            return xml;
        }

        function sendXMLToDatabase(xmlData) {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlData, "application/xml");

            // Convert XML to JSON
            const jsonData = xmlToJson(xmlDoc);

            // Ensure the endpoint uses HTTPS
            const endpoint = '/tanda-terima/faktur-pajaks'; // Ensure this endpoint uses HTTPS
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenMeta) {
                console.error('CSRF token not found in the document.');
                document.getElementById('result').innerText += '\nCSRF token not found in the document.';
                return;
            }
            const csrfToken = csrfTokenMeta.getAttribute('content');

            fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok: ${response.statusText} (${response.status})`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('JSON data stored in database successfully:', data);
                    document.getElementById('result').innerText += '\nJSON data stored in database successfully!';
                    toastr.success('JSON data stored in database successfully!');
                    // Refresh the DataTable after successful upload
                    $('#invoicesTable').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error('Error sending data to database:', error);
                    document.getElementById('result').innerText += '\nError sending data to database: ' + error;
                    toastr.error('Error sending data to database: ' + error);
                });
        }

        // Simple XML to JSON converter
        function xmlToJson(xml) {
            // Create the return object
            let obj = {};

            if (xml.nodeType === 1) { // element
                // Do attributes
                if (xml.attributes.length > 0) {
                    obj["@attributes"] = {};
                    for (let j = 0; j < xml.attributes.length; j++) {
                        const attribute = xml.attributes.item(j);
                        obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
                    }
                }
            } else if (xml.nodeType === 3) { // text
                obj = xml.nodeValue;
            }

            // Do children
            if (xml.hasChildNodes()) {
                for (let i = 0; i < xml.childNodes.length; i++) {
                    const item = xmlToJson(xml.childNodes.item(i));
                    const nodeName = xml.childNodes.item(i).nodeName;
                    if (typeof(obj[nodeName]) === "undefined") {
                        obj[nodeName] = item;
                    } else {
                        if (typeof(obj[nodeName].push) === "undefined") {
                            const old = obj[nodeName];
                            obj[nodeName] = [];
                            obj[nodeName].push(old);
                        }
                        obj[nodeName].push(item);
                    }
                }
            }
            return obj;
        }

        // Initialize DataTable
        $(document).ready(function() {
            $('#invoicesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/tanda-terima/faktur-pajaks/data', // Endpoint to fetch data
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nomorFaktur', name: 'nomorFaktur' },
                    { data: 'namaPenjual', name: 'namaPenjual' },
                    { data: 'tanggalFaktur', name: 'tanggalFaktur' },

                    // Add more columns as needed
                ]
            });
        });
    </script>
    @endpush
</x-default-layout>
