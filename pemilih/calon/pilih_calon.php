<?php
$data_id = $_SESSION["ses_id"];

if (isset($_GET['kode'])) {
	$id = $_GET['id'];

	$sql = $koneksi->query("select b.*, a.status_id from tb_votepemilih a 
	join tb_pengguna b on a.id_pemilih=b.id_pengguna 
	where id_pengguna=" . $data_id . " and daftarvote_id=" . $id);
	//$rowcount = mysqli_num_rows($sql);
	//echo $rowcount;
	$status = 0;
	$data = $sql->fetch_assoc();
	$status = $data['status_id'];


	if ($status == 2) {
?>

		<div class="alert alert-info alert-default-dark">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4>
				<i class="icon fas fa-info"></i>Info
			</h4>
			<h3>Anda sudah menggunakan Hak Suara dengan baik, Terimakasih.</h3>
		</div>
<?php
	} else {
		$sql_simpan = "INSERT INTO tb_vote (daftarvote_id, id_calon, id_pemilih, date) VALUES (
			" . $id . ",
            " . $_GET['kode'] . ",
            " . $data_id . ", now());";
		$sql_simpan .= "UPDATE tb_votepemilih set 
			status_id='2'
			WHERE id_pemilih=" . $data_id . " and daftarvote_id=" . $id;
		$query_simpan = mysqli_multi_query($koneksi, $sql_simpan);
		mysqli_close($koneksi);

		if ($query_simpan) {
			echo "<script>
			Swal.fire({title: 'Anda Berhasil Memilih',text: '',icon: 'success',confirmButtonText: 'OK'
			}).then((result) => {if (result.value){
				window.location = 'index.php?page=PsSQAdT';
				}
			})</script>";
		} else {
			echo "<script>
			Swal.fire({title: 'Anda Gagal Memilih',text: '',icon: 'error',confirmButtonText: 'OK'
			}).then((result) => {if (result.value){
				window.location = 'index.php?page=PsSQAdT';
				}
			})</script>";
		}
	}
}
		   //selesai proses simpan data
