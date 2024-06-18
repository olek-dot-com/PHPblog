<section class="images-table">
    <table>
        <caption>Lista plików graficznych</caption>
        <tr><th>Id</th><th>Obrazek</th><th>Uczestnik</th><th>Post</th><th>Nazwa</th><th>Data</th><th></th></tr>
        <?php if($images) foreach( $images as $k=>$img ){ ?>
            <tr>
                <td><?=$img["id"]?></td>
                <td><img style="max-width: 150px; max-height: 150px; width: auto; height: auto" src="<?= base_url('file/' . $img["id"] . $img["sufix"]) ?>" alt="Image" /><br /><?=($img["title"]!=""?$img["title"]:"- brak -")?></td>
                <td><?=$img["userid"]?><br />[<?= htmlentities($this->forum_model->get_user($img['userid'])['username']) ?>]</td>
                <td><?=$img["postid"]?></td>
                <td><?=$img["name"].$img["sufix"]?></td>
                <td><?=$img["date"]?></td>
                <td><nav><a class="danger" href="<?= site_url('del_img?imgid='.$img["id"]) ?>" >KASUJ</a></nav></td>
            </tr>
        <?php } ?>
    </table>
</section>
