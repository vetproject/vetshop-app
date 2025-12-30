<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 | Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,.2);
        }
        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card p-5 text-center col-md-6">

        <div class="error-code">404</div>
        <h2 class="mb-3">Page Not Found</h2>

        <p class="text-muted">
            Sorry, the page you are looking for doesn’t exist or has been moved.
        </p>

        <div class="mt-4">
            <a href="/" class="btn btn-primary btn-lg me-2">
                Go Home
            </a>
        </div>

    </div>
</div>

</body>
</html>
