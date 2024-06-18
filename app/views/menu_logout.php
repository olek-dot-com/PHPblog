<nav class="menu" >
<div style="padding: 0 6px 6px 6px;">
    <span>Zalogowany jest: <b><?=$this->session->user['username']?></b></span>
    <a href="logout" style="float:right;padding: 3px 6px;">Wylogowanie</a>
    <a href="<?= site_url('image_list') ?>">Obrazki</a>
    <a href="<?= site_url('topics') ?>">Tematy</a>
    <a href="<?= site_url('user_list') ?>">Uczestnicy</a>
</div>
</nav>