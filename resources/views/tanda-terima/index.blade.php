<x-default-layout>
    <input type="file" id="pdfFile" />
    <pre id="output">Teks akan muncul di sini...</pre>
    <pre id="onlyNumbers">Angka akan muncul di sini...</pre>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        document.getElementById('pdfFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const typedarray = new Uint8Array(this.result);
                    document.getElementById('output').textContent = "Sedang memproses PDF...";
                    document.getElementById('onlyNumbers').textContent = "Sedang mengekstrak angka...";

                    pdfjsLib.getDocument(typedarray).promise.then(pdf => {
                        let textContent = "";
                        let promises = [];
                        for (let i = 1; i <= pdf.numPages; i++) {
                            promises.push(pdf.getPage(i).then(page => {
                                return page.getTextContent().then(text => {
                                    text.items.forEach(item => {
                                        textContent += item.str + " ";
                                    });
                                });
                            }));
                        }
                        Promise.all(promises).then(() => {
                            // Membersihkan spasi berlebih
                            textContent = textContent.replace(/\s+/g, " ").trim();
                            document.getElementById('output').textContent = textContent;

                            // Ekstrak hanya angka
                            const numbersOnly = textContent.match(/\d+/g);
                            document.getElementById('onlyNumbers').textContent = numbersOnly 
                                ? "Angka yang ditemukan: " + numbersOnly.join(" ") 
                                : "Tidak ditemukan angka dalam PDF.";
                        });
                    }).catch(error => {
                        document.getElementById('output').textContent = "Gagal membaca PDF: " + error.message;
                        document.getElementById('onlyNumbers').textContent = "Error.";
                    });
                };
                reader.readAsArrayBuffer(file);
            }
        });
    </script>
    @endpush
</x-default-layout>
