<section  class="modal" id="register">
  <form action="register" method="post">
     <a name="newuser_form"></a>
     <header><h2>Jesli nie jesteś zarejestrowany, to możesz zapisać się do forum.</h2></header>  
     <input type="text" name="userid" placeholder="Nazwa logowania (dozwolone są tylko: litery, cyfry i znak '-')" pattern="[A-Za-z0-9\-]*" autofocus \><br />
     <input type="text" name="username" placeholder="Imię autora" \><br />
     <input type="password" name="pass1" placeholder="Hasło" \><br />
     <input type="password" name="pass2" placeholder="Powtórz hasło" \><br />
     <?=$captcha_html?>
     <br />
     <?=(isset($registererror))?"<div id=\"registererror\" class=\"error\">$registererror</div>":"";?>
     <button type="submit" >Zapisz się do forum</button>
  </form>
</section>    
