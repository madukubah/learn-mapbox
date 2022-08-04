<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom"  >
        <tr>
            <th style="width:50px">No</th>
            <th >Nama</th>
            <!-- <th >HPS</th> -->
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
            <td> <?php 
                if($user_id == $row-> penyedia_id )
                    echo $row->name ;
                else
                    echo "Perusahaan XXX";
            ?> </td>
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
                if($user_id == $row->penyedia_id )
                {   
                    if( $row->effering_file )
                        echo '<a href="'.base_url("uploads/tender/").$row-> effering_file.'">  '.$row-> effering_file.' </a>';
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
            <td><?php
                if($user_id == $row->penyedia_id )
                {   
                    echo form_open_multipart(site_url('penyedia/tender/hps/'.$row->id));
                    $form = array(
                        'name' => 'tender_id',
                        'id' => 'tender_id',
                        'type' => 'hidden',
                        'value' => $row->tender_id,
                        
                    );
                    echo form_input( $form );
                    ?>
                    <div class="input-group input-group-sm">
                        <input value="<?=$row->hps?>" name="hps" id="hps" type="text" class="form-control currency"  data-mask="" inputmode="decimal" >
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                            <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                }
            ?></td>
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
