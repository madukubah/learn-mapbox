<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom"  >
        <tr>
            <th style="width:50px">No</th>
            <th >Nama</th>
            <!-- <th >HPS</th> -->
            <th >Penawaran</th>
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
            <td> <?php echo $row->name ?> </td>
            <!-- <td>
                 <?php 
                    $form = array(
                        'name' => 'tender_id',
                        'id' => 'tender_id',
                        'type' => 'number',
                        'value' => $row->tender_id,
                        
                    );
                    echo form_input( $form );
                ?> 
            </td> -->
            <td> 
                <?php 
                if($user_id == $row-> penyedia_id )
                {   
                    if( $row->effering_file )
                        echo '<a href="'.base_url("uploads/tender/").$row-> effering_file.'">  File </a>';
                    else
                        echo 'None';
                    echo form_open_multipart(site_url('penyedia/tender/effering_file/'.$row->id));
                    $form = array(
                        'name' => 'tender_id',
                        'id' => 'tender_id',
                        'type' => 'hidden',
                        'value' => $row->tender_id,
                        
                    );
                    echo form_input( $form );
                    $form = array(
                        'name' => 'effering_file',
                        'id' => 'effering_file',
                        'type' => 'file',
                        'placeholder' => 'Dokumen Penawaran' ,
                        
                    );
                    echo form_upload( $form );
                    ?>
                    <button class="btn btn-bold btn-success btn-xs " style="margin-left: 5px;" type="submit">
                      Simpan
                    </button>
                    <?php
                    echo form_close();
                }
            ?> </td>
            <td>
                <input disabled type="checkbox" name="administration" id="administration" <?= ( $row->administration ) ? 'checked': ''?> >
            </td>
            <td>
                <input disabled type="checkbox" name="technical" id="technical" <?= ( $row->technical ) ? 'checked': ''?> >
            </td>
            <td>
                <input disabled type="checkbox" name="budget" id="budget" <?= ( $row->budget ) ? 'checked': ''?> >
            </td>
            <td>
                <?= $row->position?>
            </td>
        </tr>
        <?php 
            endforeach;
        ?>
        </tbody>
    </table>
</div>  
