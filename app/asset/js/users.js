var table;
var save_method ='';

function show_users(){
    table = $('#users').DataTable({
        "processing": true,
        "stateSave": true,
        "paging":   false,
        "order": [[ 0, "desc" ]],
        "ajax":{
            "url": "users/read",
            "type": "POST",
        },
        "buttons": [
            {
                text: '<i class="fa fa-plus"></i>',
                className: 'button is-primary modal-button',
                action: function () {
                    save_method = 'create';
                    $('#users_form').get(0).reset();
                    $("#users_modal").addClass("is-active");
                    $('.modal-card-title').text('Новый пользователь');
                    $('#save').text('Добавить');
                }
            },
            {
                text: '<i class="fa fa-refresh"></i>',
                className: 'button is-info reload',
            }
        ],
        "columns": [
            { "title": "ID", "className":'id', "data":null, "orderable": false},
            { "title": "Пользователь", "className":'user', "data":"user", "orderable": false},
            { "title": "Telegram ID", "className":'telegram_id', "data":"telegram_id", "orderable": false},

            {
                "className":'buttons',
                "orderable": false,
                "title":"Настройка",
                "data": null,
                "defaultContent": "<button class='edit button is-small is-rounded'>"+
                                        "<i class='fa fa-pencil'></i>"+
                                    "</button>"
            }
            
        ],
        "createdRow": function( row, data, dataIndex ) {       
            $(row).addClass("has-text-black-bis "+data.color);
        },
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.11.1/i18n/ru.json'
        },
        "initComplete": function () {
            
            //При скроле зарепить панель с кнопками
            var fixmeTop = $('.table_btn').offset().top;
            $(window).scroll(function() {
                var currentScroll = $(window).scrollTop();
                if (currentScroll >= fixmeTop) {
                    $('.table_btn').css({
                        'position': 'fixed',
                        'top': '0',
                        'left': '0',
                        'margin-top': '0',
                        'z-index': '4',
                        'max-width': 'none!important',
                        'padding-left': '32px',
                        'padding-right': '32px',
                        'width': '100%',
                        'background-color': '#efefef'
                    });
                    $('.table_btn>.column>.dt-buttons>.button').css({
                        'margin-bottom': '0rem',
                    });
                } else {
                    $('.table_btn').css({
                        'position': 'static',
                        'padding-left': '0px',
                        'padding-right': '0px',
                    });
                }
            });

        },
        "dom":'<"columns table_btn buttons"<"column"B>>rt',    
    });
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
}
show_users();


$(".reload").on('click', function(){
    table.ajax.reload( null, false ); 
});

//При нажатии на кнопку редактировать возле каждого заказа
$('#users').on('click','tbody .edit', function() {
    $('#users_form').get(0).reset();
    save_method = 'update';
    $("#users_modal").addClass("is-active");
    $('.modal-card-title').text('Редактирование Пользователя');
    $('#save').text('Редактировать');
    var data = table.row($(this).closest('tr')).data();
    console.log(data);
    for (key in data ){
        $('[name=' + key +']').val(data[key]);
    }
});

//Сохранение заказа
$("#save").on('click', function(){
    var url;
    if (save_method == 'create') {
      url = 'users/add';
      $('.notification_text').text('Пользователь успешно создан');
    }
    else {
      url = 'users/edit';
      $('.notification_text').text('Пользователь отредактирован');
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: $('#users_form').serialize(),
        success: function(data){
            if(data) {
                console.log(data);
                $(".modal").removeClass("is-active");
                $(".success").removeClass("is-hidden");
                setTimeout(() => { $(".success").addClass("is-hidden"); }, 3000);
                table.ajax.reload();  
            }
        }
    });
});

//При нажатии на кнопку закрыть в модальном окне
$(".delete").click(function() {
    $(".modal").removeClass("is-active");
    $(".notification").removeClass("is-active");
    $(".notification").addClass("is-hidden");
});
//При нажатии на крестик в модальном окне
$(".close").click(function() {
    $(".modal").removeClass("is-active");
});