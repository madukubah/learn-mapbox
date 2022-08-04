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
                    echo $row->name ;
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
                    if( $row->effering_file )
                        echo '<a href="'.base_url("uploads/tender/").$row-> effering_file.'">  '.$row-> effering_file.' </a>';
                    else
                        echo 'None';
            ?> </td>
            <td>
                <?= number_format($row->hps)?>
            </td>
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
