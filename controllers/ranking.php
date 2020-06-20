<?php

function getKriteriaPenilaian($conn, $kriteria_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  return $result;
}

function getNilaiDataset($conn, $dataset_id, $kriteria_id)
{
  $sql = "SELECT * FROM dataset_nilais WHERE dataset_id=$dataset_id AND kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  return $result;
}

function getListDatasetNilai($conn, $kriteria_id)
{
  $datasetNilaiSQL = "SELECT DISTINCT dataset_id FROM dataset_nilais WHERE kriteria_id=$kriteria_id ORDER BY dataset_id ASC";;
  $datasetNilaiResult = $conn->query($datasetNilaiSQL);

  $datasetList = array();

  while($datasetNR = $datasetNilaiResult->fetch_object()) {
    $datasetNew = array();

    $datasetSQL = "SELECT id, nama FROM datasets WHERE id='$datasetNR->dataset_id'";
    $datasetResult = $conn->query($datasetSQL);
    $dataset = $datasetResult->fetch_row();

    $datasetNew['id'] = $dataset[0];
    $datasetNew['nama'] = $dataset[1];

    $penilaianResult = getListPenilaian($conn, $kriteria_id);

    while ($penilaian = $penilaianResult->fetch_object()) {
      $datasetP = getDatasetPenilaian($conn, $dataset[0], $penilaian->id)->fetch_row();
      $datasetNew[$penilaian->nama] = $datasetP[4];
    }

    $datasetList[] = $datasetNew;
  }

  return $datasetList;
}

function getListPenilaian($conn, $kriteria_id)
{
  $penilaianSQL = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $penilaianResult = $conn->query($penilaianSQL);

  return $penilaianResult;
}

function getDatasetPenilaian($conn, $dataset_id, $penilaian_id)
{
  $penilaianSQL = "SELECT * FROM dataset_nilais WHERE dataset_id=$dataset_id AND kriteria_penilaian_id=$penilaian_id";
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