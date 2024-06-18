<section class="user-info">
        <br/>
        <table>
            <tr>
                <th>Identyfikator</th>
                <th>Nazwa</th>
                <th>Poziom</th>
                <th></th>
            </tr>
            <?php foreach ($users as $k => $v) { ?>
                <tr>
                    <td><?= $v['userid'] ?></td>
                    <td><?= $v['username'] ?></td>
                    <td><?= ($v['level'] == 'admin') ? 'admin' : 'user'; ?></td>
                    <td><?php if ($v['userid'] != 'admin') { ?>
                            <a href="<?= site_url('changeuser/'.$v['userid']) ?>">Zmień</a>&nbsp;
                            <a class="danger" href="<?= site_url('deluser/'.$v['userid']) ?>">Kasuj</a>
                        <?php } ?></td>
                </tr>
            <?php } ?>
        </table>
</section>
