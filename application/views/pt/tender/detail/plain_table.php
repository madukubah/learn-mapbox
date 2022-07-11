<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom"  >
        <tr>
            <th style="width:50px">No</th>
            <th >Nama</th>
            <th >Penawaran</th>
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
                echo '<a href="'.base_url("uploads/tender/").$row-> effering_file.'">  File Penawaran </a>';
            ?> </td>
        </tr>
        <?php 
            endforeach;
        ?>
        </tbody>
    </table>
</div>  