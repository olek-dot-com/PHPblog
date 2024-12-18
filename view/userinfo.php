<section class="user-info"><?php if ($this->u['userlevel'] == 10) { ?>
        <div>
            <a href="?cmd=topics">Tematy</a>
            <a href="?cmd=images">Obrazki</a>
            <?php if ($this->context == "topics") { ?><a href="?cmd=userlist">Lista uczestników</a><?php } ?>
        </div>
    <?php } ?>

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
                    <td><?= ($v['userlevel'] == 10) ? 'admin' : 'user'; ?></td>
                    <td><?php if ($v['userid'] != 'admin') { ?>
                            <a href="?cmd=changeuser&userid=<?= $v['userid'] ?>">Zmień</a>&nbsp;
                            <a class="danger" href="?cmd=deluser&userid=<?= $v['userid'] ?>">Kasuj</a>
                        <?php } ?></td>
                </tr>
            <?php } ?>
        </table>
</section>
