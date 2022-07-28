
<br>

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<table >
    <tr style="background-color: blue; color: white" >
        <td style="margin: 80px" colspan="3" >Informasi Tender</td>
    </tr>

    <?php foreach( $form_data as $key => $value ):?>
        <tr>
            <td width="40%" ><?=$key?></td>
            <td width="3%" >:</td>
            <td width="60%" ><?=$value?></td>
        </tr>
    <?php endforeach;?>
</table>