<?php include VIEW . 'header.php'?>
  <?php include VIEW . 'menu.php'?>
  <!--***** USERS *****-->
  <?php
      $url = $_SERVER['REQUEST_URI'];
  ?>
  <div class="container is-fluid">
    <table id='users' class='table is-bordered' style='width:100%'>
    </table>
  </div>
  <div id="users_modal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Новый пользователь</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <form id="users_form">
          <input type="text" name="id" style="display:none">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Имя</label>
              <input class="input" id="name" name="name" type="text">
            </div>
            <div class="field">
              <label class="label">Логин</label>
              <input class="input" id="login" name="login" type="text">
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Пароль</label>
              <input class="input" id="password" name="password" type="text">
            </div>
            <div class="field">
              <label class="label">Telegram ID</label>
              <input class="input" id="telegram_id" name="telegram_id" type="text">
            </div>
          </div>
        </div>
        </form>
      </section>
      <footer class="modal-card-foot">
        <button id="save" class="button is-success"></button>
        <button class="button close" >Закрыть</button>
      </footer>
    </div>
  </div>

  <div class="success notification is-success is-fixed-bottom is-hidden">
  <button class="delete"></button>
    <strong class="notification_text">Пользователь успешно добавлен!</strong>
  </div>
  <?php include VIEW . 'footer.php'?>

  <script src="/app/asset/js/users.js"></script>