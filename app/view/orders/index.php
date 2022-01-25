  <?php include VIEW . 'header.php'?>
  <?php include VIEW . 'menu.php'?>
  <!--***** ORDERS *****-->
  <?php
      $url = $_SERVER['REQUEST_URI'];
  ?>
  <div class="container is-fluid">
    <table id='orders' class='table is-bordered' style='width:100%'>
    </table>
  </div>
  <div id="order_modal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Новый заказ</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <form id="order_form">
          <input type="text" name="_id" style="display:none">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
                <label class="label">Дата</label>
                <input class="input date" name="date" type="date">
            </div>
            <div class="field">
              <label class="label">Статус</label>
              <div class="select is-fullwidth">
                <select id="status"  name="status"></select>
              </div>
            </div>
            <div class="field">
              <label class="label">Дата работ</label>
              <input class="input date"  name="work_start_date" type="date">
            </div>
            <div class="field">
            <label class="label">Время</label>
              <input class="input"  name="time" type="time">
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Город</label>
              <div class="select is-fullwidth">
                <select id="city" name="city">
                </select>
              </div>
            </div>
            <div class="field">
              <label class="label">Адрес</label>
              <input class="input" id="address" name="address" type="text" required>
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Работы</label>
              <textarea class="textarea"  name="working" placeholder="Какие работы нужно сделать"></textarea>
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Номер телефона</label>
              <input class="input" type="phone" name="phone" placeholder="Номер телефона" required>
            </div>
            <div class="field">
              <label class="label">ФИО клиента</label>
              <input class="input" type="text" name="client" placeholder="ФИО клиента">
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Примечание</label>
              <textarea class="textarea"  name="comment" placeholder="Применчание"></textarea>
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Отчет бригады</label>
              <input class="input" type="text" name="execution" placeholder="Выполнение">
            </div>
            <div class="field">
              <label class="label">Деньги</label>
              <input class="input" type="text" name="cash" placeholder="Деньги">
            </div>
          </div>
        </div>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <label class="label">Бригада</label>
              <div class="select is-fullwidth">
                <select id="users" name="user_id">
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

  <div id="filter" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title"></p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section id="orders_filter_modal" class="modal-card-body">

      </section>
      <footer class="modal-card-foot">
        <button class="button close succ" >Показать</button>
      </footer>
    </div>
  </div>

  <div class="success notification is-success is-fixed-bottom is-hidden">
  <button class="delete"></button>
    <strong class="notification_text">Заказ успешно создан!</strong>
  </div>
  <?php include VIEW . 'footer.php'?>
  <script src="/app/asset/js/dataTables.searchPanes.min.js"></script>
  <script src="/app/asset/js/orders.js"></script>
