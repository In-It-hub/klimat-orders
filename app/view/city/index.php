<?php include VIEW . 'header.php'?>
  <?php include VIEW . 'menu.php'?>
  <!--***** CITY *****-->
  <?php
      $url = $_SERVER['REQUEST_URI'];
  ?>
  <div class="container is-fluid">
    <table id='city' class='table is-bordered' style='width:100%'>
    </table>
  </div>
  <div id="city_modal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Новый город</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <form id="city_form">
          <input type="text" name="_id" style="display:none">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Название города</label>
              <input class="input" id="city_name" name="city_name" type="text">
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
    <strong class="notification_text">Город успешно создан!</strong>
  </div>
  <?php include VIEW . 'footer.php'?>

    <script src="/app/asset/js/city.js"></script>