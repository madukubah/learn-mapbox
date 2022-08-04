<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom"  >
        <tr>
            <th style="width:50px">No</th>
            <th >Nama</th>
            <th >Penawaran</th>
            <th >HPS(Rp)</th>
            <th >Administrasi</th>
            <th >Teknis</th>
            <th >Harga/Biaya</th>
            <th >Urutan</th>
        </tr>
        </thead>
        <tbody  >
        <?php 
            $no =  ( isset( $number ) && ( $number != NULL) )  ? $number : 1 ;
            foreach( $rows as $ind => $row ):
        ?>
        <tr >
            <td> <?php echo $no ++ ?> </td>
            <td> <?php echo '<a href="'.site_url("pt/company/detail/".$row->company_id).'">  '.$row->name.' </a>'; ?> </td>
            <td> 
                <?php 
                    if( $row->effering_file )
                        echo '<a href="'.base_url("uploads/tender/").$row->effering_file.'">  File Dokumen Penawaran </a>';
                    else
                        echo 'None';
                ?>
            </td>
            <td>
                <?= number_format($row->hps)?>
            </td>
            <?php 
                echo form_open_multipart(site_url('pt/tender/tender_penyedia/'.$row->tender_id)); 
                $form = array(
                    'name' => 'penyedia_id',
                    'id' => 'penyedia_id',
                    'type' => 'hidden',
                    'value' => $row->penyedia_id,
                    
                );
                echo form_input( $form );
            ?>
            <td>
                <input type="checkbox" name="administration" id="administration" <?= ( $row->administration ) ? 'checked': ''?> >
            </td>
            <td>
                <input type="checkbox" name="technical" id="technical" <?= ( $row->technical ) ? 'checked': ''?> >
            </td>
            <td>
                <input type="checkbox" name="budget" id="budget" <?= ( $row->budget ) ? 'checked': ''?> >
            </td>
            <td>
                <input type="number" name="position" id="position" value='<?= $row->position?>'>
            </td>
            <td>
                <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
                    Simpan
                </button>
            </td>
            <?php echo form_close()  ?>

        </tr>
        <?php 
            endforeach;
        ?>
        </tbody>
    </table>
</div>  