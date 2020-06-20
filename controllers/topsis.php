<?php

function Topsis($conn, $kriteria_id)
{
  $datasetList = getListDatasetNilai($conn, $kriteria_id);
  $kriteriaPenilaian = getKriteriaPenilaians($conn, $kriteria_id);
  $kriteriaRumus = array();
  $datasetNormalisasi = $datasetList;
  $datasetNBobot = $datasetList;
  $datasetIdealPositif = $datasetList;
  $datasetIdealNegatif = $datasetList;
  $idealPositif = array();
  $idealNegatif = array();

  foreach ($kriteriaPenilaian as $kriteriaP) {
    $idealPositif[$kriteriaP['nama']] = 0;
    $idealNegatif[$kriteriaP['nama']] = 999;
  }
  
  foreach ($kriteriaPenilaian as $kriteriaP) {
    $kriteriaRumus[$kriteriaP['nama']] = 0;

    foreach ($datasetList as $dataset) {
      $kriteriaRumus[$kriteriaP['nama']] += pow($dataset[$kriteriaP['nama']], 2);
    }    
    $kriteriaRumus[$kriteriaP['nama']] = round(sqrt($kriteriaRumus[$kriteriaP['nama']]), 2);

    $datasetIndex = 0;
    foreach ($datasetList as $dataset) {
      // Nilai di normalisasi
      $sn = round($dataset[$kriteriaP['nama']] / $kriteriaRumus[$kriteriaP['nama']], 2);
      $datasetNormalisasi[$datasetIndex][$kriteriaP['nama']] = $sn;

      // Hasil normalisasi dikali bobot
      $snw = round($sn * $kriteriaP['bobot'], 2);
      $datasetNBobot[$datasetIndex][$kriteriaP['nama']] = $snw;

      // Ideal positif
      $ip = $idealPositif[$kriteriaP['nama']];
      $idealPositif[$kriteriaP['nama']] = $ip < $snw ? $snw : $ip;
      
      // Ideal negatif
      $in = $idealNegatif[$kriteriaP['nama']];
      $idealNegatif[$kriteriaP['nama']] = $in > $snw ? $snw : $in;

      $datasetIndex++;
    }

    // Total ideal
    $datasetIndex = 0;
    foreach ($datasetList as $dataset) {
      $sip = $idealPositif[$kriteriaP['nama']] - $datasetNBobot[$datasetIndex][$kriteriaP['nama']];
      $datasetIdealPositif[$datasetIndex][$kriteriaP['nama']] = pow($sip, 2);

      $sin = $idealNegatif[$kriteriaP['nama']] - $datasetNBobot[$datasetIndex][$kriteriaP['nama']];
      $datasetIdealNegatif[$datasetIndex][$kriteriaP['nama']] = pow($sin, 2);

      $datasetIndex++;
    }
  }

  // Jarak solusi ideal
  $datasetIndex = 0;
  foreach ($datasetList as $dataset) {
    $jarakSolusiIP = 0;
    $jarakSolusiIN = 0;
    foreach ($kriteriaPenilaian as $kriteriaP) {
      $jarakSolusiIP += $datasetIdealPositif[$datasetIndex][$kriteriaP['nama']];
      $jarakSolusiIN += $datasetIdealNegatif[$datasetIndex][$kriteriaP['nama']];
    }

    $datasetList[$datasetIndex]['jarak_sip'] = sqrt($jarakSolusiIP);
    $datasetList[$datasetIndex]['jarak_sin'] = sqrt($jarakSolusiIN);

    $datasetIndex++;
  }

  // Nilai preferensi
  $datasetIndex = 0;
  foreach ($datasetList as $dataset) {
    $jssip = $datasetList[$datasetIndex]['jarak_sip'];
    $jssin = $datasetList[$datasetIndex]['jarak_sin'];

    $np = ($jssin) / ($jssin + $jssip);
    $datasetList[$datasetIndex]['nilai_preferensi'] = $np;

    // echo $datasetList[$datasetIndex]['nis'] . '. ' . $np . '<br>';
    $datasetIndex++;
  }

  $data = array();

  $data['dataset_list'] = $datasetList;
  
  $data['kriteria_rumus'] = $kriteriaRumus;
  $data['dataset_normalisasi'] = $datasetNormalisasi;
  
  $data['dataset_bobot'] = $datasetNBobot;
  
  $data['ip'] = $idealPositif;
  $data['dataset_ip'] = $datasetIdealPositif;
  
  $data['in'] = $idealNegatif;
  $data['dataset_in'] = $datasetIdealNegatif;

  return $data;
}