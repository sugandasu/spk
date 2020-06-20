<?php

class Smart {
    public function normasilasi_bobot($bobot=[])
    {
        $bobot_baru = [];

        $total_bobot = 0;
        foreach($bobot as $b) {
            $total_bobot += $b["bobot"];
        }

        foreach ($bobot as $b) {
            $b["bobot"] = round($b["bobot"] / $total_bobot, 3);
            $bobot_baru[] = $b;
        }

        return $bobot_baru;
    }

    public function hitung_nilai_utility($dataset=[], $bobot=[])
    {
        $max = array();
        $min = array();
        $dataset_baru = array();

        foreach($bobot as $b) {
            $nama = $b["nama"];
            $max[$nama] = 0;
            $min[$nama] = 99999;

            foreach ($dataset as $d) {
                $max[$nama] = $d[$nama] > $max[$nama] ? $d[$nama] : $max[$nama];
                $min[$nama] = $d[$nama] < $min[$nama] ? $d[$nama] : $min[$nama];
            }
        }

        foreach ($dataset as $d) {
            $d["nilai_akhir"] = 0;

            foreach($bobot as $b) {
                $nama = $b["nama"];
                if ($b["tipe_nilai"] == "max") {
                    $d[$nama] = ($d[$nama] - $min[$nama]) / ($max[$nama] - $min[$nama]);
                } else {
                    $d[$nama] = ($max[$nama] - $d[$nama]) / ($max[$nama] - $min[$nama]);
                }

                $d["nilai_akhir"] += $b["bobot"] * $d[$nama];
            }

            $dataset_baru[] = $d;
        }

        return $dataset_baru;
    }
};