<?php
    $datas = array(
        array(
            'label' => 'Pengumuman Pascakualifikasi',
            'id_start_date' => 'announcement_start_date',
            'id_start_time' => 'announcement_start_time',
            'id_end_date' => 'announcement_end_date',
            'id_end_time' => 'announcement_end_time',
            'value_start' => isset($schedule)? $schedule->announcement_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->announcement_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Download Dokumen Pemilihan',
            'id_start_date' => 'file_download_start_date',
            'id_start_time' => 'file_download_start_time',
            'id_end_date' => 'file_download_end_date',
            'id_end_time' => 'file_download_end_date',
            'value_start' => isset($schedule)? $schedule->file_download_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->file_download_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Pemberian Penjelasan',
            'id_start_date' => 'explanation_start_date',
            'id_start_time' => 'explanation_start_time',
            'id_end_date' => 'explanation_end_date',
            'id_end_time' => 'explanation_end_time',
            'value_start' => isset($schedule)? $schedule->explanation_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->explanation_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Upload Dokumen Penawaran',
            'id_start_date' => 'effering_file_upload_start_date',
            'id_start_time' => 'effering_file_upload_start_time',
            'id_end_date' => 'effering_file_upload_end_date',
            'id_end_time' => 'effering_file_upload_end_time',
            'value_start' => isset($schedule)? $schedule->effering_file_upload_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->effering_file_upload_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Pembukaan Dokumen Penawaran',
            'id_start_date' => 'proof_offering_start_date',
            'id_start_time' => 'proof_offering_start_time',
            'id_end_date' => 'proof_offering_end_date',
            'id_end_time' => 'proof_offering_end_time',
            'value_start' => isset($schedule)? $schedule->proof_offering_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->proof_offering_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Evaluasi Administrasi, Kualifikasi, Teknis dan Harga',
            'id_start_date' => 'evaluation_start_date',
            'id_start_time' => 'evaluation_start_time',
            'id_end_date' => 'evaluation_end_date',
            'id_end_time' => 'evaluation_end_time',
            'value_start' => isset($schedule)? $schedule->evaluation_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->evaluation_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Pembuktian Kualifikasi, Pembuatan BAHT dan Usulan Penetapan Pemenang Tender',
            'id_start_date' => 'proof_qualification_start_date',
            'id_start_time' => 'proof_qualification_start_time',
            'id_end_date' => 'proof_qualification_end_date',
            'id_end_time' => 'proof_qualification_end_time',
            'value_start' => isset($schedule)? $schedule->proof_qualification_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->proof_qualification_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Penetapan Pemenang Oleh Direksi dan Reviu Hasil Kegiatan',
            'id_start_date' => 'winner_settle_start_date',
            'id_start_time' => 'winner_settle_start_time',
            'id_end_date' => 'winner_settle_end_date',
            'id_end_time' => 'winner_settle_end_time',
            'value_start' => isset($schedule)? $schedule->winner_settle_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->winner_settle_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Pengumuman Pemenang',
            'id_start_date' => 'winner_announcement_start_date',
            'id_start_time' => 'winner_announcement_start_time',
            'id_end_date' => 'winner_announcement_end_date',
            'id_end_time' => 'winner_announcement_end_time',
            'value_start' => isset($schedule)? $schedule->winner_announcement_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->winner_announcement_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Masa Sanggah',
            'id_start_date' => 'interuption_start_date',
            'id_start_time' => 'interuption_start_time',
            'id_end_date' => 'interuption_end_date',
            'id_end_time' => 'interuption_end_time',
            'value_start' => isset($schedule)? $schedule->interuption_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->interuption_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Surat Penunjukan Penyedia Barang/Jasa',
            'id_start_date' => 'choose_letter_start_date',
            'id_start_time' => 'choose_letter_start_time',
            'id_end_date' => 'choose_letter_end_date',
            'id_end_time' => 'choose_letter_end_time',
            'value_start' => isset($schedule)? $schedule->choose_letter_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->choose_letter_end_date: '0000-00-00 00:00:00',
        ),
        array(
            'label' => 'Penandatanganan Kontrak',
            'id_start_date' => 'signing_start_date',
            'id_start_time' => 'signing_start_time',
            'id_end_date' => 'signing_end_date',
            'id_end_time' => 'signing_end_time',
            'value_start' => isset($schedule)? $schedule->signing_start_date: '0000-00-00 00:00:00',
            'value_end' => isset($schedule)? $schedule->signing_end_date: '0000-00-00 00:00:00',
        ),
    );
?>
<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom"  >
        <tr>
            <th style="width:50px">No</th>
            <th >Tahap</th>
            <th >Tanggal Mulai</th>
            <th >Tanggal Selesai</th>
        </tr>
        </thead>
        <tbody  >
        <?php
            $no= 1;
            foreach($datas as $data):
        ?>
        <tr >
            <td><?php echo $no++; ?></td>
            <td><?= $data['label']?></td>
            <td>
                <?php
                    echo ($data['value_start'] != '0000-00-00 00:00:00' )?$data['value_start']:'';
                ?>
            </td>
            <td>
                <?php
                    echo ($data['value_end'] != '0000-00-00 00:00:00' )?$data['value_end']:'';
                ?>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
        </tbody>
    </table>
</div>  