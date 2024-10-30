<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container mt-5">
        <!-- Card utama -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Daftar Item</h3>
            </div>
            <div class="card-body">
                <!-- Tampilkan alert jika ada pesan sukses -->
                @if(session('success'))
                    <script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: '{{ session('success') }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                    </script>
                @endif

                <!-- Tampilkan alert jika ada pesan error -->
                @if(session('error'))
                    <script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '{{ session('error') }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                    </script>
                @endif

                <!-- Tabel untuk menampilkan item -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>Rp {{ number_format((int)($item['price'] ?? 0), 0, ',', '.') }}</td>
                                    <td>
                                        <button onclick="showUpdateModal({{ $item['id'] }}, '{{ $item['name'] }}', {{ $item['price'] }})" class="btn btn-warning btn-sm">Edit</button>
                                        <button onclick="confirmDelete({{ $item['id'] }})" class="btn btn-danger btn-sm">Hapus</button>
                                        <form id="delete-form-{{ $item['id'] }}" action="{{ route('items.destroy', $item['id']) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Button to Open the Add Item Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addItemModal">
                    Tambah Item Baru
                </button>
            </div>
        </div>

        <!-- Modal for Adding New Item -->
        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addItemModalLabel">Tambah Item Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('items.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Item</label>
                                <input type="text" name="name" class="form-control" id="addName" placeholder="Nama Item" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Harga Item</label>
                                <input type="number" name="price" class="form-control" id="addPrice" placeholder="Harga Item" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambahkan Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Updating Item -->
        <div class="modal fade" id="updateItemModal" tabindex="-1" role="dialog" aria-labelledby="updateItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateItemModalLabel">Edit Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="updateId">
                            <div class="form-group">
                                <label for="updateName">Nama Item</label>
                                <input type="text" name="name" class="form-control" id="updateName" placeholder="Nama Item" required>
                            </div>
                            <div class="form-group">
                                <label for="updatePrice">Harga Item</label>
                                <input type="number" name="price" class="form-control" id="updatePrice" placeholder="Harga Item" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- SweetAlert2 konfirmasi hapus -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Item ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function showUpdateModal(id, name, price) {
            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updatePrice').val(price);
            $('#updateForm').attr('action', '{{ url('items') }}/' + id); // Set the update action
            $('#updateItemModal').modal('show');
        }
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
