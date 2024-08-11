<x-default-layout>
    @section('title')
        User
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target=".tambah-user">
                        <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data User
                    </button>
                </h3>
            </div>
            <div class="card-body">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr>
                            <th>Level User</th>
                            <th>Jumlah User</th>
                            <th>Lihat User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usersGroupedByRole as $role => $data)
                          <tr>
                            <td>{{ $role }}</td>
                            <td>{{ $data->count() }}</td>
                            <td>
                              <a href="{{ route('users.cbt.show', Crypt::encrypt($role)) }}" class="btn btn-info btn-sm">
                                <i class="nav-icon fas fa-search-plus"></i> &nbsp; Ditails
                              </a>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade tambah-user" tabindex="-1" role="dialog" aria-labelledby="tambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tambahUserLabel">Tambah Data User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.cbt.storecbt') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" type="text" placeholder="{{ __('Name') }}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input id="username" type="text" placeholder="{{ __('Username') }}" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-Mail Address</label>
                                    <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Level User</label>
                                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" autocomplete="role">
                                        <option value="">-- Select {{ __('Level User') }} --</option>
                                        <option value="admin_cbt">Admin</option>
                                        <option value="guru">Guru</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3" id="noId">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>

            document.addEventListener('DOMContentLoaded', function() {

                $('#role').change(function(){
            var kel = $('#role option:selected').val();
            console.log("kel",kel);
            if (kel == "guru") {
              $("#noId").html('<label for="nomer">Nomer Id Card</label><input id="nomer" type="text" maxlength="5" onkeypress="return inputAngka(event)" placeholder="No Id Card" class="form-control" name="nomer" autocomplete="off">');
            } else if(kel == "siswa") {
              $("#noId").html(`<label for="nomer">Nomer Induk Siswa</label><input id="nomer" type="text" placeholder="No Induk Siswa" class="form-control" name="nomer" autocomplete="off">`);
            } else if(kel == "Admin" || kel == "Operator") {
              $("#noId").html(`<label for="name">Username</label><input id="name" type="text" placeholder="Username" class="form-control" name="name" autocomplete="off">`);
            } else {
              $("#noId").html("")
            }
        });
    // Get the form and submit button elements
    const form = document.getElementById('userForm');
    const submitButton = form.querySelector('button[type="submit"]');



    // Add event listener to the form's submit event
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Validate form fields or process data here
        const email = form.querySelector('#email').value;
        const role = form.querySelector('#role').value;
        const password = form.querySelector('#password').value;
        const passwordConfirm = form.querySelector('#password-confirm').value;

        if (!email || !role || !password || password !== passwordConfirm) {
            // Show an error message or handle invalid form data
            alert('Please fill in all fields correctly.');
            return;
        }

        // Form is valid, proceed with submission (e.g., via AJAX)
        // Example using fetch API
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User added successfully.');
                // Close the modal
                const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                modal.hide();
                // Optionally, refresh the page or update the table
            } else {
                alert('Error adding user: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
});

        </script>

    @endpush
</x-default-layout>
