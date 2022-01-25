<?php include VIEW . 'header.php'?>
<!--***** LOGIN FORM *****-->
<section class="hero is-primary is-fullheight">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-5-tablet is-4-desktop is-3-widescreen">
          <form action="" method="POST" class="box">
		  <?php echo ($this->view_data['message']); ?>
            <div class="field">
              <label for="login" class="label">Логин</label>
              <div class="control has-icons-left">
                <input type="text" name="login" placeholder="Введите логин" class="input" required>
                <span class="icon is-small is-left">
                  <i class="fa fa-user"></i>
                </span>
              </div>
            </div>
            <div class="field">
              <label for="" class="label">Пароль</label>
              <div class="control has-icons-left">
                <input type="password"  name="password" placeholder="*******" class="input" required>
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
              </div>
            </div>
            <div class="field">
				<input type="submit" name="submit" class="button is-success is-fullwidth" value="Войти">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
 