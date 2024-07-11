function showLoginModal() {
    $('#loginModal').modal('show');
}

function login() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    
    if (username === 'admin' && password === 'password') {
        alert('Login successful!');
        $('#loginModal').modal('hide');
    } else {
        alert('Incorrect username or password. Please try again.');
    }
}
