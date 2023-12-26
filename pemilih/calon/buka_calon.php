<?php

if (isset($_GET['kode'])) {
	$id = $_GET['id'];
	$sql_cek = "SELECT * FROM tb_calon WHERE id_calon='" . $_GET['kode'] . "'";
	$query_cek = mysqli_query($koneksi, $sql_cek);
	$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

	$kode = $_GET['kode'];

	$data_id = $_SESSION["ses_id"];
	$sql = $koneksi->query("select b.*, a.status_id from tb_votepemilih a 
	join tb_pengguna b on a.id_pemilih=b.id_pengguna 
	where id_pengguna=" . $data_id . " and daftarvote_id=" . $id);
	//$rowcount = mysqli_num_rows($sql);
	//echo $rowcount;
	$status = 0;
	$data = $sql->fetch_assoc();
	$status = $data['status_id'];
}
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
?>

	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">
				<i class="fa fa-table"></i> Data Kandidat
			</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="table-responsive">
				<div>
					<a href="?page=PsSQAdT&kode=<?php echo $id ?>" class="btn btn-secondary btn-sm">
						< Kembali</a>
				</div>
				<br>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>
								<center>Kandidat Pilihan Anda</center>
							</th>
						</tr>
					</thead>
					<tbody>

						<?php
						$id = $_GET['id'];
						$query = "select a.*, b.no_urut from tb_calon a 
					join tb_votekandidat b on a.id_calon=b.id_calon
					where b.flag_id<>9 and daftarvote_id=" . $id . " and a.id_calon=" . $kode;
						$sql = $koneksi->query($query);
						while ($data = $sql->fetch_assoc()) {
						?>

							<tr>
								<td align="center">
									<h1>
										<?php echo $data['no_urut']; ?>
									</h1>
									<br>
									<img src="foto/<?php echo $data['foto_calon']; ?>" width="200px" />
									<br>
									<h2>
										<?php echo $data['nama_calon']; ?>
									</h2>
									<br>
									<a href="?page=PsSQBpL&kode=<?php echo $data['id_calon']; ?>&id=<?php echo $id ?>" class="btn btn-primary">
										<i class="fa fa-edit"></i> Tetapkan Pilihan
									</a>
								</td>
							</tr>

						<?php
						}
						?>
					</tbody>
					</tfoot>
				</table>
			</div>
		</div>
	<?php
}
	?>
	<!-- /.card-body -->