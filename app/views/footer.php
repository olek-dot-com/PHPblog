<!--  footer  -->
<footer>
Ostatni wpis na formu powstal dnia: <?= $date = $this->forum_model->get_last_post_date()['date'] != ''?$this->forum_model->get_last_post_date()['date']:'--brak wpisów--'?>

</footer>
</body>
</html>