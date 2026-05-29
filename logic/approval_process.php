<?php

require_once __DIR__ . '/../helper/data/approval.php';
// mengolah data laporan approval 
function generateLaporan($conn) {
    $data_laporan = getLaporanApproval($conn);

    $total = count($data_laporan);
    $total_disetujui = 0;
    $total_ditolak = 0;

    foreach ($data_laporan as $row) {
        if ($row['status_approval'] === 'disetujui') {
            $total_disetujui++;
        } else if ($row['status_approval'] === 'ditolak') {
            $total_ditolak++;
        }
    }

    $hasil_laporan = [
        'total'           => $total,
        'total_disetujui' => $total_disetujui,
        'total_ditolak'   => $total_ditolak,
        'detail'          => $data_laporan
    ];

    return $hasil_laporan;
}