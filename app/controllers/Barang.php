<?php
class Barang extends Controller
{
     public function index()
     {
          $data['page'] = 'Daftar Barang';
          $data['barang'] = $this->model('BarangModel')->getAllBarang();
          $this->view('templates/header', $data);
          $this->view('barang/index', $data);
          $this->view('templates/footer');
     }

     public function tambah($msg = NULL)
     {
          $data['page'] = 'Tambah Barang';

          // Inisialisasi nilai awal input fields
          $data['nama_peminjam_value'] = isset($_POST['nama_peminjam']) ? $_POST['nama_peminjam'] : '';
          $data['jenis_barang_value'] = isset($_POST['jenis_barang']) ? $_POST['jenis_barang'] : '';
          $data['no_barang_value'] = isset($_POST['no_barang']) ? $_POST['no_barang'] : '';
          $data['tgl_pinjam_value'] = isset($_POST['tgl_pinjam']) ? $_POST['tgl_pinjam'] : '';
          $this->view('templates/header', $data);
          $this->view('barang/tambah', $data);
          $this->view('templates/footer');
     }

     public function simpanBarang()
     {

          $tgl_pinjam = $_POST['tgl_pinjam'];

          // Ubah tanggal dengan menambahkan 2 hari
          $_POST['tgl_kembali'] = date('Y-m-d H:i:s', strtotime($tgl_pinjam . ' +2 days'));

          // Sekarang, $tgl_kembali berisi tanggal yang sudah diubah


          if (empty($_POST['nama_peminjam']) || empty($_POST['jenis_barang']) || empty($_POST['no_barang']) || empty($_POST['tgl_pinjam'])) {
               $msg = "Silahkan isi";

               if (empty($_POST['nama_peminjam'])) {
                    $msg .= " Nama";
               }
               if (empty($_POST['jenis_barang'])) {
                    $msg .= " Jenis";
               }
               if (empty($_POST['no_barang'])) {
                    $msg .= " No barang";
               }
               if (empty($_POST['tgl_pinjam'])) {
                    $msg .= " Tanggal Peminjam";
               }

               echo "<script>alert('$msg');</script>";
               $this->tambah($msg);
               return;
          } else {

               if ($this->model('BarangModel')->tambahBarang($_POST) > 0) {
                    header('Location: ' . BASE_URL . '/barang/index');
                    exit;
               } else {
                    header('Location: ' . BASE_URL . '/barang/index');
                    exit;
               }
          }
     }

     public function edit($id)
     {
          $data['page'] = 'Edit Barang';
          $data['barang'] = $this->model('BarangModel')->getBarangById($id);
          $this->view('templates/header', $data);
          $this->view('barang/edit', $data);
          $this->view('templates/footer');
     }

     public function updateBarang()
     {
          if ($this->model('BarangModel')->updateBarang($_POST) > 0) {
               header('Location: ' . BASE_URL . '/barang/index');
               exit;
          } else {
               header('Location: ' . BASE_URL . '/barang/index');
               exit;
          }
     }

     public function hapus($id)
     {
          if ($this->model('BarangModel')->deleteBarang($id) > 0) {
               header('Location: ' . BASE_URL . '/barang/index');
               exit;
          } else {
               header('Location: ' . BASE_URL . '/barang/index');
               exit;
          }
     }

     public function cari()
     {
          $data['page'] = 'Data Barang';

          // Periksa apakah $_POST['search'] telah diinisialisasi
          if (isset($_POST['search'])) {
               $data['barang'] = $this->model('BarangModel')->cariBarang($_POST['search']);
          } else {
               // Tangani ketika $_POST['search'] tidak ada
               $data['barang'] = [];
          }

          $this->view('templates/header', $data);
          $this->view('barang/index', $data);
          $this->view('templates/footer');
     }
}
