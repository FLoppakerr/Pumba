// login.js

function toggleLogin() {
    $('#loginModal').modal('show');
}

function login() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Perform login logic (you can replace this with your own authentication logic)
    // For demonstration, let's assume correct credentials are 'admin' and 'password'
    if (username === 'admin' && password === 'password') {
        alert('Login successful!');
        $('#loginModal').modal('hide'); // Close the modal after login
        // Redirect to another page or perform actions after successful login
        // Example: window.location.href = 'dashboard.html';
    } else {
        alert('Incorrect username or password. Please try again.');
    }
}
