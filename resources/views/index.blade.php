<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Logout - Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Container -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- Login Form -->
                <div id="login-form" class="card shadow p-4">
                    <h2 class="text-center mb-4">Login</h2>
                    <form id="login">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                <!-- Logout Section -->
                <div id="logout-section" class="card shadow p-4 d-none">
                    <h2 class="text-center mb-4">Welcome!</h2>
                    <p class="text-center">Hello, <span id="user-name" class="fw-bold"></span></p>
                    <div class="d-grid">
                        <button id="logout" class="btn btn-danger">Logout</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script>
        const apiUrl = 'http://127.0.0.1:8000/api'; // Laravel API URL

        // Login Functionality
        document.getElementById('login').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch(${apiUrl}/login, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                alert('Login successful');
                localStorage.setItem('token', data.access_token);
                document.getElementById('user-name').innerText = data.user.name;
                document.getElementById('login-form').classList.add('d-none');
                document.getElementById('logout-section').classList.remove('d-none');
            } else {
                alert(data.message);
            }
        });

        // Logout Functionality
        document.getElementById('logout').addEventListener('click', async () => {
            const token = localStorage.getItem('token');

            const response = await fetch(${apiUrl}/logout, {
                method: 'POST',
                headers: {
                    'Authorization': Bearer ${token},
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                alert('Logout successful');
                localStorage.removeItem('token');
                document.getElementById('login-form').classList.remove('d-none');
                document.getElementById('logout-section').classList.add('d-none');
            } else {
                alert('Logout failed');
            }
        });
    </script>
</body>
</html>
