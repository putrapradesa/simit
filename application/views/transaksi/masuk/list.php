<?php
    $no=1; foreach($datamasuk as $row) {
?>
<tr>
    <td style="width:5%"><?php echo $no++;?></td>
    <td style="width:20%"><?php echo $row->NoSJ;?></td>
    <td style="width:20%"><?php echo dateFormat($row->TglSJ);?></td>
    <td style="width:20%"><?php echo $row->NamaSupplier;?></td>
    <td style="width:20%"><?php echo $row->SP;?></td>
    <td style="width:20%"><?php echo $row->NamaBarang;?></td>
    <td style="width:20%"><?php echo $row->Quantity;?></td>
    <td style="width:20%"><?php echo $row->Uom;?></td>
    <td style="width:20%"><?php echo $row->CreateBy;?></td>
    <td style="width:10%">
    <!-- <button type="button" class="btn btn-warning waves-effect btn-sm update-dataBarangMasuk" data-id="<?php echo $row->Id; ?>"><i class="material-icons">edit</i><span>Edit</span></button> -->
    <button class="btn btn-danger waves-effect btn-sm konfirmasiHapus-daftarmasuk" data-id="<?php echo $row->Id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="material-icons">close</i><span>Hapus</span></button>
    </td>
</tr>
<?php
    }
?>