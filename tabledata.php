<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="#">Data Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">หน้าหลัก</a>
                </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tabledata.php">ข้อมูล</a>
            </li>                
            <li class="nav-item">
                <a class="nav-link" href="https://github.com/FLoppakerr" target="_blank">ติดต่อ</a>
            </li>
                <li class="nav-item dropdown">
                    <a id="loginLink" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span id="loginText">Profile</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="showLoginModal()">Login</a>
                        <a class="dropdown-item" href="edit_profile.html">Edit Profile</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <button type="button" class="btn btn-primary" onclick="showModal()">
            เพิ่มข้อมูลลูกค้า
        </button>

        <!-- Container for modal content -->
        <div id="modalContainer"></div>
    </div>

    <div class="container mt-5">
        <h2>Table Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Column 3</th>
                    <th>Column 4</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Data 1</td>
                    <td>Data 2</td>
                    <td>Data 3</td>
                    <td>Data 4</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
    <footer class="bg-dark text-white text-center py-2">
        <p>&copy; 2024 Data Management System. ขอฉัน.</p>
    </footer>

    <!-- Login Modal -->
    <div id="loginModalContainer"></div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="login.js"></script>
    <script src="modal.js"></script>
    <script>
        // Load the login modal content from login.html
        $(document).ready(function() {
            $('#loginModalContainer').load('login.html', function() {
                console.log('Login modal loaded');
            });
        });
    </script>
</body>

</html>
