


function createUser() {
    // Show a loading indicator using SweetAlert2
    Swal.fire({
        title: 'Loading...',
        text: 'Please wait while we redirect you.',
        didOpen: () => {
            Swal.showLoading()
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    });

    // Simulate the process of opening the link to create a user
    setTimeout(function() {
        // Redirect to the create user link
        window.location.href = '/users/create';
    }, 2000); // Simulated delay for demonstration
}





