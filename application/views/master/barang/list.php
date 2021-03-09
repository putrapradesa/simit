<?php
    $no=1; foreach($databarang as $row) {
?>
<tr>
    <td style="width:5%"><?php echo $row->Id;?></td>
    <td style="width:20%"><?php echo $row->Nama;?></td>
    <td style="width:20%"><?php echo $row->Kategori;?></td>
    <td style="width:20%"><?php echo $row->Uom;?></td>
    <td style="width:10%">
    <button type="button" class="btn btn-warning waves-effect btn-sm update-dataBarang" data-id="<?php echo $row->Id; ?>"><i class="material-icons">edit</i><span>Edit</span></button>
    <button class="btn btn-danger waves-effect btn-sm konfirmasiHapus-barang" data-id="<?php echo $row->Id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="material-icons">close</i><span>Hapus</span></button>
    </td>
</tr>
<?php
    }
?>