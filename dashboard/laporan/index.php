<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/dataset.php');
  include('../../controllers/kriteria.php');
  include('../../controllers/ranking.php');
  include('../../controllers/nilai.php');
  include('../../controllers/smart.php');


  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $kriteria_id = $_GET['kriteria_id'];
  $kriteria = getKriteriaOne($conn, $kriteria_id);
  $list_dataset = getDataset($conn);

  $bobot = getKriteriaPenilaians($conn, $kriteria_id);
  // echo "<pre>";
  // print_r($bobot);
  // echo "</pre>";

  $smart = new Smart();
  $bobot_baru = $smart->normasilasi_bobot($bobot);
  // echo "<pre>";
  // print_r($bobot_baru);
  // echo "</pre>";

  $list_nilai_dataset = getListDatasetNilai($conn, $kriteria_id);
  // echo "<pre>";
  // print_r($list_nilai_dataset);
  // echo "</pre>";

  $list_nilai_dataset_baru = $smart->hitung_nilai_utility($list_nilai_dataset, $bobot_baru);
  // echo "<pre>";
  // print_r($list_nilai_dataset_baru);
  // echo "</pre>";

  $ranking = $smart->ranking($list_nilai_dataset_baru);
  // echo "<pre>";
  // print_r($ranking);
  // echo "</pre>";
?>
<html>
<head>
	<style type="text/css">
		.header
		{
		 height: auto;
		}
		.logo
		{
		 float: left;
		 padding-top: 20px;
		 padding-left: 100px;
		 width: 13%;
		 height: 80px;
		 /*background-color: blue;*/
		}
		.kop
		{

		float: left;
		 width: 70%;
		 height: 100px;
		 /*background-color: green;*/
		 text-align: center;
		}
		.tulisan
		{
		 float: left;
		 width:650px;
		 height: 600px;
		 /*background-color: yellow;*/
		}
		p{
			font-size: 18pt;
			font-weight: bold;
		}
		th {
			text-align: center;
		}
		td:first-child {
			text-align: center;
		}
		td:last-child {
			text-align: center;
		}
	</style>

</head>
<body>
	<div class="header">
		<br><br>
		<div class="table-responsive">
			<table class="" border="1" id="dataTableRank" width="100%" cellspacing="0">
				<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Hasil</th>
				</tr>
				</thead>
				<tbody>
				<?php $no=1; foreach ($ranking as $r): ?>
				<tr>
					<td><?= $no; ?></td>	
					<td><?= $r['nama'] ?></td>
					<td><?= $r['nilai_akhir'] ?></td>
				</tr>
				<?php $no++; endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	window.print();
</script>
<script>
    $('#dataTableRank').dataTable( {
      "order": [[ 3, 'desc' ]]
    });
    document.querySelector('#navKriteria').setAttribute('class', 'nav-item active');
  </script>