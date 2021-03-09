<?php
    $no=1; foreach($datakeluar as $row) {
?>
<tr>
    <td style="width:5%"><?php echo $no++;?></td>
    <td style="width:20%"><?php echo dateFormat($row->TglKeluar);?></td>
    <td style="width:20%"><?php echo $row->Divisi;?></td>
    <td style="width:20%"><?php echo $row->Bagian;?></td>
    <td style="width:20%"><?php echo $row->NamaBarang;?></td>
    <td style="width:20%"><?php echo $row->Qty;?></td>
    <td style="width:20%"><?php echo $row->Uom;?></td>
    <td style="width:10%">
    <!-- <button type="button" class="btn btn-warning waves-effect btn-sm update-dataBagian" data-id="<?php echo $row->Id; ?>"><i class="material-icons">edit</i><span>Edit</span></button> -->
    <button class="btn btn-danger waves-effect btn-sm konfirmasiHapus-daftarkeluar" data-id="<?php echo $row->Id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="material-icons">close</i><span>Hapus</span></button>
    </td>
</tr>
<?php
    }
?>