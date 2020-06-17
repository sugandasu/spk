<?php

function getKriteriaPenilaian($conn, $kriteria_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  return $result;
}

function getNilaiSiswa($conn, $siswa_id, $kriteria_id)
{
  $sql = "SELECT * FROM siswa_nilais WHERE siswa_id=$siswa_id AND kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  return $result;
}

function getListSiswaNilai($conn, $kriteria_id)
{
  $siswaNilaiSQL = "SELECT DISTINCT siswa_id FROM siswa_nilais WHERE kriteria_id=$kriteria_id ORDER BY siswa_id ASC";;
  $siswaNilaiResult = $conn->query($siswaNilaiSQL);

  $siswaList = array();

  while($siswaNR = $siswaNilaiResult->fetch_object()) {
    $siswaNew = array();

    $siswaSQL = "SELECT id, nama, nis FROM siswas WHERE id='$siswaNR->siswa_id'";
    $siswaResult = $conn->query($siswaSQL);
    $siswa = $siswaResult->fetch_row();

    $siswaNew['nis'] = $siswa[1];
    $siswaNew['nama'] = $siswa[2];

    $penilaianResult = getListPenilaian($conn, $kriteria_id);

    while ($penilaian = $penilaianResult->fetch_object()) {
      $siswaP = getSiswaPenilaian($conn, $siswa[0], $penilaian->id)->fetch_row();
      $siswaNew[$penilaian->nama] = $siswaP[4];
    }

    $siswaList[] = $siswaNew;
  }

  return $siswaList;
}

function getListPenilaian($conn, $kriteria_id)
{
  $penilaianSQL = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $penilaianResult = $conn->query($penilaianSQL);

  return $penilaianResult;
}

function getSiswaPenilaian($conn, $siswa_id, $penilaian_id)
{
  $penilaianSQL = "SELECT * FROM siswa_nilais WHERE siswa_id=$siswa_id AND kriteria_penilaian_id=$penilaian_id";
  $penilaian = $conn->query($penilaianSQL);

  return $penilaian;
}

function getKriteriaPenilaians($conn, $kriteria_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);
  $penilaianList = array();

  while ($kriteriaP = $result->fetch_object()) {
    $penilaian = array();

    $penilaian['id'] = $kriteriaP->id;
    $penilaian['kriteria_id'] = $kriteriaP->kriteria_id;
    $penilaian['text'] = $kriteriaP->text;
    $penilaian['nama'] = $kriteriaP->nama;
    $penilaian['bobot'] = $kriteriaP->bobot;
    $penilaian['tipe_nilai'] = $kriteriaP->tipe_nilai;
    $penilaian['tipe_form'] = $kriteriaP->tipe_form;

    $penilaianList[] = $penilaian;
  }

  return $penilaianList;
}

function Topsis($conn, $kriteria_id)
{
  $siswaList = getListSiswaNilai($conn, $kriteria_id);
  $kriteriaPenilaian = getKriteriaPenilaians($conn, $kriteria_id);
  $kriteriaRumus = array();
  $siswaNormalisasi = $siswaList;
  $siswaNBobot = $siswaList;
  $siswaIdealPositif = $siswaList;
  $siswaIdealNegatif = $siswaList;
  $idealPositif = array();
  $idealNegatif = array();

  foreach ($kriteriaPenilaian as $kriteriaP) {
    $idealPositif[$kriteriaP['nama']] = 0;
    $idealNegatif[$kriteriaP['nama']] = 999;
  }
  
  foreach ($kriteriaPenilaian as $kriteriaP) {
    $kriteriaRumus[$kriteriaP['nama']] = 0;

    foreach ($siswaList as $siswa) {
      $kriteriaRumus[$kriteriaP['nama']] += pow($siswa[$kriteriaP['nama']], 2);
    }    
    $kriteriaRumus[$kriteriaP['nama']] = round(sqrt($kriteriaRumus[$kriteriaP['nama']]), 2);

    $siswaIndex = 0;
    foreach ($siswaList as $siswa) {
      // Nilai di normalisasi
      $sn = round($siswa[$kriteriaP['nama']] / $kriteriaRumus[$kriteriaP['nama']], 2);
      $siswaNormalisasi[$siswaIndex][$kriteriaP['nama']] = $sn;

      // Hasil normalisasi dikali bobot
      $snw = round($sn * $kriteriaP['bobot'], 2);
      $siswaNBobot[$siswaIndex][$kriteriaP['nama']] = $snw;

      // Ideal positif
      $ip = $idealPositif[$kriteriaP['nama']];
      $idealPositif[$kriteriaP['nama']] = $ip < $snw ? $snw : $ip;
      
      // Ideal negatif
      $in = $idealNegatif[$kriteriaP['nama']];
      $idealNegatif[$kriteriaP['nama']] = $in > $snw ? $snw : $in;

      $siswaIndex++;
    }

    // Total ideal
    $siswaIndex = 0;
    foreach ($siswaList as $siswa) {
      $sip = $idealPositif[$kriteriaP['nama']] - $siswaNBobot[$siswaIndex][$kriteriaP['nama']];
      $siswaIdealPositif[$siswaIndex][$kriteriaP['nama']] = pow($sip, 2);

      $sin = $idealNegatif[$kriteriaP['nama']] - $siswaNBobot[$siswaIndex][$kriteriaP['nama']];
      $siswaIdealNegatif[$siswaIndex][$kriteriaP['nama']] = pow($sin, 2);

      $siswaIndex++;
    }
  }

  // Jarak solusi ideal
  $siswaIndex = 0;
  foreach ($siswaList as $siswa) {
    $jarakSolusiIP = 0;
    $jarakSolusiIN = 0;
    foreach ($kriteriaPenilaian as $kriteriaP) {
      $jarakSolusiIP += $siswaIdealPositif[$siswaIndex][$kriteriaP['nama']];
      $jarakSolusiIN += $siswaIdealNegatif[$siswaIndex][$kriteriaP['nama']];
    }

    $siswaList[$siswaIndex]['jarak_sip'] = sqrt($jarakSolusiIP);
    $siswaList[$siswaIndex]['jarak_sin'] = sqrt($jarakSolusiIN);

    $siswaIndex++;
  }

  // Nilai preferensi
  $siswaIndex = 0;
  foreach ($siswaList as $siswa) {
    $jssip = $siswaList[$siswaIndex]['jarak_sip'];
    $jssin = $siswaList[$siswaIndex]['jarak_sin'];

    $np = ($jssin) / ($jssin + $jssip);
    $siswaList[$siswaIndex]['nilai_preferensi'] = $np;

    // echo $siswaList[$siswaIndex]['nis'] . '. ' . $np . '<br>';
    $siswaIndex++;
  }

  $data = array();

  $data['siswa_list'] = $siswaList;
  
  $data['kriteria_rumus'] = $kriteriaRumus;
  $data['siswa_normalisasi'] = $siswaNormalisasi;
  
  $data['siswa_bobot'] = $siswaNBobot;
  
  $data['ip'] = $idealPositif;
  $data['siswa_ip'] = $siswaIdealPositif;
  
  $data['in'] = $idealNegatif;
  $data['siswa_in'] = $siswaIdealNegatif;

  return $data;
}