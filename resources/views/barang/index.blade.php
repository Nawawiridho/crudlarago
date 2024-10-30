<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container mt-5">
        <!-- Card utama -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Daftar Barang</h3>
            </div>
            <div class="card-body">
                <!-- Tampilkan alert jika ada pesan sukses -->
                @if(session('success'))
                    <script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: '{{ session("success") }}',
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
                                text: '{{ session("error") }}',
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
                                <th>Nama barang</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $brg)
                                <tr>
                                    <td>{{ $brg['id_barang'] }}</td>
                                    <td>{{ $brg['nama_barang'] }}</td>
                                    <td>{{ $brg['stok'] }}</td>
                                    <td>
                                        <button onclick="showUpdateModal({{ $brg['id_barang'] }}, '{{ $brg['nama_barang'] }}', {{ $brg['stok'] }})" class="btn btn-warning btn-sm">Edit</button>
                                        <button onclick="confirmDelete({{ $brg['id_barang'] }})" class="btn btn-danger btn-sm">Hapus</button>
                                        <form id="delete-form-{{ $brg['id_barang'] }}" action="{{ route('barang.destroy', $brg['id_barang']) }}" method="POST" style="display: none;">
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
                    Tambah Barang Baru
                </button>
            </div>
        </div>

        <!-- Modal for Adding New Item -->
        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addItemModalLabel">Tambah barang Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('barang.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Barang</label>
                                <input type="text" name="name" class="form-control" id="addName" placeholder="Nama barang" required>
                            </div>
                            <div class="form-group">
                                <label for="price">stok</label>
                                <input type="number" name="price" class="form-control" id="addPrice" placeholder="stok" required>
                            </div>
                            <div class="form-group">
                            <label for="jenis">Jenis Barang</label>
                            <select name="jenisbarang" class="form-control" id="jenisbarang" required>
                                <option value="" disabled selected>Pilih jenis barang</option>
                                <option value="1">konsumsi</option>
                                <option value="2">pembersih</option>
                            </select>
                        </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambahkan Barang</button>
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
                        <h5 class="modal-title" id="updateItemModalLabel">Edit Barang</h5>
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
                                <label for="updateName">Nama barang</label>
                                <input type="text" name="namabarang" class="form-control" id="updateName" placeholder="Nama barang" required>
                            </div>
                            <div class="form-group">
                                <label for="updatePrice">Stok</label>
                                <input type="number" name="stok" class="form-control" id="updatePrice" placeholder="stok" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Barang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- SweetAlert2 konfirmasi hapus -->
    <script>
        function confirmDelete(id_barang) {
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
                    document.getElementById('delete-form-' + id_barang).submit();
                }
            });
        }

        function showUpdateModal(id_barang, nama_barang, stok) {
            $('#updateId').val(id_barang);
            $('#updateName').val(nama_barang);
            $('#updatePrice').val(stok);
            $('#updateForm').attr('action', '{{ url('barang') }}/' + id_barang); // Set the update action
            $('#updateItemModal').modal('show');
        }
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
