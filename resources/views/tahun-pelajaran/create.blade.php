<x-default-layout>
    @section('title')
        Add Tahun Pelajaran
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('tahun-pelajaran.create') }}
    @endsection
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <style>
            .toastify-progress {
                position: relative;
                overflow: hidden;
            }

            .toastify-progress::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.2);
                animation: progress 5s linear forwards;
            }

            @keyframes progress {
                0% {
                    width: 100%;
                }

                100% {
                    width: 0;
                }
            }
        </style>
    @endpush

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add New Tahun Pelajaran</h5>
        </div>
        <div class="card-body">
            <form id="tahunPelajaranForm" action="{{ route('tahun-pelajaran.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" required>
                </div>
                <button type="button" id="saveButton" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>



    @push('scripts')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            document.getElementById('saveButton').addEventListener('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to add a new Tahun Pelajaran.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData(document.getElementById('tahunPelajaranForm'));

                        fetch("{{ route('tahun-pelajaran.store') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Success case
                                if (data.success) {
                                    Toastify({
                                        html: `<div style="display: flex; align-items: center;">
                                    <i class="fas fa-check-circle" style="font-size: 20px; color: #28a745; margin-right: 10px;"></i>
                                    <span>${data.message}</span>
                                </div>`,
                                        duration: 5000,
                                        gravity: "top", // Top positioning
                                        position: "right", // Right positioning
                                        backgroundColor: "#28a745",
                                        close: true,
                                        stopOnFocus: true,
                                        className: "toastify-progress"
                                    }).showToast();

                                    setTimeout(() => {
                                        window.location.href =
                                            "{{ route('tahun-pelajaran.index') }}";
                                    }, 2000);
                                } else {
                                    // Handling validation errors
                                    if (data.errors) {
                                        for (let field in data.errors) {
                                            data.errors[field].forEach(error => {
                                                Toastify({
                                                    html: `<div style="display: flex; align-items: center;">
                                                <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #dc3545; margin-right: 10px;"></i>
                                                <span>Validation Error: ${error}</span>
                                            </div>`,
                                                    duration: 7000,
                                                    gravity: "top", // Top positioning
                                                    position: "right", // Right positioning
                                                    backgroundColor: "#dc3545",
                                                    close: true,
                                                    stopOnFocus: true,
                                                    className: "toastify-progress"
                                                }).showToast();
                                            });
                                        }
                                    } else {
                                        // General failure message
                                        Toastify({
                                            html: `<div style="display: flex; align-items: center;">
                                        <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #dc3545; margin-right: 10px;"></i>
                                        <span>Failed to Create Tahun Pelajaran: ${data.message || 'An unexpected error occurred. Please try again.'}</span>
                                    </div>`,
                                            duration: 7000,
                                            gravity: "top", // Top positioning
                                            position: "right", // Right positioning
                                            backgroundColor: "#dc3545",
                                            close: true,
                                            stopOnFocus: true,
                                            className: "toastify-progress"
                                        }).showToast();
                                    }
                                }
                            })
                            .catch(error => {
                                // Catching unexpected errors during the fetch call
                                Toastify({
                                    html: `<div style="display: flex; align-items: center;">
                                <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #dc3545; margin-right: 10px;"></i>
                                <span>Toastify is awesome!✖ An error occurred while saving the data.</span>
                            </div>`,
                                    duration: 7000,
                                    gravity: "top", // Top positioning
                                    position: "right", // Right positioning
                                    backgroundColor: "#dc3545",
                                    close: true,
                                    stopOnFocus: true,
                                    className: "toastify-progress"
                                }).showToast();
                                console.error('Error:', error);
                            });
                    }
                });
            });
        </script>
    @endpush
</x-default-layout>
