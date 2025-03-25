<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- ✅ Success Message Toast -->
            @if(session('success'))
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="container mt-4">
                @yield('content')  <!-- Supports Blade template views -->
                {{ $slot ?? '' }}  <!-- Supports Laravel components -->
            </main>
        </div>

        <!-- Global Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><i class="fas fa-question-circle"></i> Are you sure you want to delete this item? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery, Bootstrap JS & DataTables -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                // ✅ Initialize DataTable
                $('.datatable').DataTable({
                    "paging": true,          
                    "lengthChange": true,    
                    "searching": true,       
                    "ordering": true,        
                    "info": true,            
                    "autoWidth": false,      
                    "responsive": true       
                });

                // ✅ Show success toast notification
                let successToast = $('#successToast');
                if (successToast.length) {
                    let toast = new bootstrap.Toast(successToast[0]);
                    toast.show();

                    // Auto-hide after 3 seconds
                    setTimeout(() => {
                        toast.hide();
                    }, 3000);
                }

                // ✅ Delete Confirmation Modal
                $(document).on('click', '.delete-btn', function() {
                    let deleteUrl = $(this).data('url');
                    $('#deleteForm').attr('action', deleteUrl);
                    $('#deleteModal').modal('show');
                });
            });
        </script>
    </body>
</html>