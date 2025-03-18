<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Ensure CSRF security -->
    
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS (Bootstrap 5 version) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa; /* Light grey background */
        }
        .alert {
            margin-top: 10px;
        }
    </style>

    @stack('styles') <!-- Allows adding custom styles from child views -->
</head>

<body>
    <div class="container mt-4">
        <!-- Display success and error messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (Required for DataTables & Validation) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS (Bootstrap 5 version) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- JavaScript for Delete Confirmation Modal -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
            var deleteForm = document.getElementById("deleteForm");

            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function () {
                    var deleteUrl = this.getAttribute("data-url");
                    deleteForm.setAttribute("action", deleteUrl);
                    deleteModal.show();
                });
            });
        });
    </script>

    <!-- Auto-hide success and error messages -->
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                $('.alert-success, .alert-danger').fadeOut('slow');
            }, 3000);
        });
    </script>

    @stack('scripts') <!-- Allows adding custom scripts from child views -->
</body>
</html>
