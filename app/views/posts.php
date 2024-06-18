<section>
  <nav>
  <table><tr>
  <td style="width: 33.3%;"></td>
  <td  style="width: 33.3%;">
    <a href="<?= base_url('/topics')?>">Lista tematów</a>
  </td>
  <td  style="width: 33.3%;"></td>
  </tr></table>
  </nav>

    <article class="topic">
        <header>Temat dyskusji: <b><?=htmlentities($topic['topic'])?></b></header>
        <div><?=nl2br(htmlentities($topic['topic_body']))?></div>
        <footer>
            ID: <?=$topic['topicid']?>, Autor: <?=htmlentities($this->forum_model->get_user($topic['userid'])['username'])?>, Data: <?=$topic['date']?>
        </footer>
    </article>
    <nav><a href="#" id="addpost">+ Dodaj wpis</a></nav>

    <?php if (!$posts) { ?>
        <p>To forum nie zawiera jeszcze żadnych głosów w dyskusji!</p>
    <?php } else {
        foreach ($posts as $k => $v) { ?>
            <article class="post">
                <div><?=nl2br(htmlentities($v['post']))?><br />
                    <?php
                    if ($images) {
                        foreach ($images as $imgid => $img) {
                            if ($img["postid"] != $v["postid"]) continue;
                            ?>
                            <div class="image">
                                <img src="<?= base_url('file/' . $img['id'] .$img['sufix']) ?>" alt="<?= htmlentities($img['title']) ?>" /><br />
                                <?= htmlentities($img["title"]) ?><br />
                                <?php if ($this->session->userdata('user')['level'] == 'admin' || $this->session->userdata('user')['userid'] == $v['userid']) { ?>
                                    <a href="#" imgid="<?=$img["id"]?>" class="imgedit">EDYTUJ</a>
                                    <a class="danger" href="?cmd=imgdelete&imgid=<?=$img["id"]?>">KASUJ</a>
                                <?php } ?>
                            </div>
                        <?php } } ?>
                </div>
                <footer>
                    <nav>
                        <?php if ($this->session->userdata('user')['level'] == 'admin' || $this->session->userdata('user')['userid'] == $v['userid']) { ?>
                            <a href="#" postid="<?=$v['postid']?>" class="postedit">EDYTUJ</a>
                            <a href="#" postid="<?=$v['postid']?>" class="uploadfile">+ OBRAZEK</a>
                            <a class="danger" href="?&id=<?=$v['postid']?>&cmd=delete">KASUJ</a>
                        <?php } ?>
                    </nav>
                    ID: <?=$v['postid']?>, Autor: <?=htmlentities($this->forum_model->get_user($v['userid'])['username'])?>, Utworzono dnia: <?=$v['date']?>
                    <div style="clear:both;"></div>
                </footer>
            </article>
        <?php } } ?>
  <div class="modal" id="modal_post">
  <form action="" method="post" enctype="multipart/form-data">
     <header><h2>Dodaj nową wypowiedź do dyskusji</h2></header>  
     <textarea name="post" autofocus cols="80" rows="10" placeholder="Wpisz tu swoją wypowiedź." ></textarea><br />
     <input type="hidden" name="postid" value="" />
     <button type="submit" >Zapisz</button>
  </form>
  </div>
  
  <div class="modal" id="modal_file">
  <form action="<?=site_url('posts/' . $topic['topicid'])."/upload_file" ?>" method="post" enctype="multipart/form-data">
  <header><h2>Dodaj ilustrację do wpisu ID: <span id="pid"></span></h2></header>
  <input type="file" name="image" required>
  <input type="text" name="imagetitle" value="" placeholder="Opis pliku" required/>
  <button type="submit" >Prześlij</button>
  <input type="hidden" name="postid" value="" />
  </form>
  </div>

  <div class="modal" id="modal_fileedit">
      <form action="<?=site_url('posts/' . $topic['topicid'])."/edit_img" ?>" method="post" enctype="multipart/form-data">
          <header><h2>Edytuj podpis</h2></header>
          <input type="text" name="imagetitle" value="" placeholder="Opis pliku" />
          <button type="submit" >Zapisz</button>
          <input type="hidden" name="imgid" value="" />
      </form>
  </div>
  
</section>
