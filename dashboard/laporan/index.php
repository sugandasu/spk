<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/siswa.php');
  include('../../controllers/kriteria.php');
  include('../../controllers/ranking.php');
  include('../../controllers/nilai.php');


  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $kriteria_id = $_GET['kriteria_id'];
  $kriteria = getKriteriaOne($conn, $kriteria_id);
  $list_siswa = getSiswa($conn);
  $data = Topsis($conn, $kriteria_id);


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
	</style>

</head>
<body>
	<div class="header">
		<div class="tulisan">
			<div class="logo">
				<img height="70px" width="70px" src="../../img/logo.png"> </img>
			</div>
		<div class="kop">
		<p>PEMERINTAH KOTA PALU <br> DINAS PENDIDIKAN DAN KEBUDAYAAN</p>
		</div>
		<br><br>
			      <div class="table-responsive">
                <table class="" border="1" id="dataTableRank" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Hasil</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($data['siswa_list'] as $siswa): ?>
                    <tr>
                      <!-- <td><?= $no; ?></td> -->	
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <td><?= $siswa['nilai_preferensi'] ?></td>
                    </tr>
                    <?php $no++; endforeach ?>
                  </tbody>
                </table>
              </div>
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