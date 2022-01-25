<?php include VIEW . 'header.php'?>
  <?php include VIEW . 'menu.php'?>
  <!--***** STATUS *****-->
  <?php
      $url = $_SERVER['REQUEST_URI'];
  ?>
  <div class="container is-fluid">
    <table id='status' class='table is-bordered' style='width:100%'>
    </table>
  </div>
  <div id="status_modal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Новый статус</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <form id="status_form">
          <input type="text" name="_id" style="display:none">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Название статуса</label>
              <input class="input" id="status_name" name="status_name" type="text">
            </div>
            <div class="field">
              <label class="label">Цвет</label>
              <div class="select is-fullwidth">
                <select id="color"  name="color">
                  <option value="">Белый</option>
                  <option value="has-background-primary" class="has-background-primary">Бирюзовый</option>
                  <option value="has-background-link" class="has-background-link">Синий</option>
                  <option value="has-background-info" class="has-background-info">Голубой</option>
                  <option value="has-background-success" class="has-background-success">Зелёный</option>
                  <option value="has-background-warning" class="has-background-warning">Желтый</option>
                  <option value="has-background-danger" class="has-background-danger">Крассный</option>
                </select>
              </div>
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
    <strong class="notification_text">Статус успешно создан!</strong>
  </div>
  <?php include VIEW . 'footer.php'?>

  <script src="/app/asset/js/status.js"></script>