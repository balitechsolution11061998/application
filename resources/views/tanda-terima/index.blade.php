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
                            textContent = textContent.replace(/\s+/g, " ").trim();
                            document.getElementById('output').textContent = textContent;

                            // Cari angka setelah teks tertentu
                            const match = textContent.match(/Kode dan Nomor Seri Faktur Pajak:\s*(\d+)/);
                            if (match) {
                                const fakturNumber = match[1]; // Ambil angka setelah teks
                                document.getElementById('onlyNumbers').textContent = 
                                    "Nomor Faktur Pajak: " + fakturNumber;

                                // Simpan ke variabel JavaScript untuk dikirim ke database
                                console.log("Nomor Faktur Pajak yang akan disimpan:", fakturNumber);

                                // Kirim ke server menggunakan AJAX
                                sendToDatabase(fakturNumber);
                            } else {
                                document.getElementById('onlyNumbers').textContent = 
                                    "Tidak ditemukan Nomor Seri Faktur Pajak.";
                            }
                        });
                    }).catch(error => {
                        document.getElementById('output').textContent = "Gagal membaca PDF: " + error.message;
                        document.getElementById('onlyNumbers').textContent = "Error.";
                    });
                };
                reader.readAsArrayBuffer(file);
            }
        });

        // Fungsi untuk mengirim data ke database (AJAX)
        function sendToDatabase(fakturNumber) {
            fetch('/tanda-terima/faktur-pajaks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan menggunakan CSRF token di Laravel
                },
                body: JSON.stringify({ nomor_faktur: fakturNumber })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response dari server:", data);
                alert("Nomor Faktur berhasil disimpan ke database!");
            })
            .catch(error => {
                console.error("Error saat mengirim data:", error);
            });
        }
    </script>
    @endpush
</x-default-layout>
