<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom"  >
        <tr>
            <th style="width:50px">No</th>
            <th >Nama</th>
            <!-- <th >HPS</th> -->
            <th >HPS(Rp)</th>
        </tr>
        </thead>
        <tbody  >
        <?php 
            $no =  ( isset( $number ) && ( $number != NULL) )  ? $number : 1 ;
            foreach( $rows as $ind => $row ):
                if($row->position != 1) continue;
        ?>
        <tr >
            <td> <?php echo $no ++ ?> </td>
            <td> <?php 
                    echo $row->name ;
            ?> </td>
            <td>
                <?= number_format($row->hps)?>
            </td>
        </tr>
        <?php 
            endforeach;
        ?>
        </tbody>
    </table>
</div>  
