var table;

function show_orders(){
    table = $('#orders').DataTable({
        "processing": true,
        "stateSave": true,
        "paging":   false,
        "order": [[ 0, "desc" ]],
        "searchPanes": {
            layout: 'columns-2',
            columns: [2, 5]
        },
        "ajax":{
            "url": "orders/read",
            "type": "POST",
        },
        "buttons": [
            {
                text: '<i class="fa fa-plus"></i>',
                className: 'button is-primary modal-button',
                action: function () {
                    $('#order_form').get(0).reset();
                    $("#order_modal").addClass("is-active");
                    $('.modal-card-title').text('Новый заказ');
                    $('#save').text('Добавить');
                    $('input[name="date"]').siblings().val(output);
                    $('input[name="date"]').val(output);
                }
            },
            {
                text: '<i class="fa fa-refresh"></i>',
                className: 'button is-info reload',
                action: function ( e, dt, node, config ) {
                    table.ajax.reload( null, false );        
                }
            },
            {
                text: '<i class="fa fa-filter"></i>',
                className: 'button is-warning',
                action: function ( e, dt, node, config ) {
                    $("#filter").addClass("is-active");
                    $('.modal-card-title').text('Фильтр');         
                }
            }
        ],
        "columns": [
            { "title": "ID", "data": null, "orderable": false},
            { "title": "Дата", "data":"date", "orderable": false},
            { "title": "Статус", "data": "status.display"  },
            { "title": "Предварит. дата", "data": "work_start_date"  },
            { "title": "Время", "data": "time"  },
            { "title": "Город", "data": "city.display"  },
            { "title": "Адрес", "data": "address", "orderable": false},
            { "title": "Работы", "data": "working", "orderable": false},
            { "title": "Телефон", "data": "phone", "orderable": false},
            { "title": "Деньги", "data": "cash", "orderable": false},
            { "visible": false, "searchable": false, "data": "user"},
            { "title": "Пользователь", "data": "user", "orderable": false},
            { "title": "Выполнение", "data": "execution", "orderable": false},
            {
                "className":'buttons ',
                "orderable": false,
                "title":"Настройка",
                "data": null,
                "defaultContent": "<button class='edit button is-small is-rounded'>"+
                                        "<i class='fa fa-pencil'></i>"+
                                    "</button>"+
                                    "<button class='button detail is-link is-small is-rounded'>"+
                                        "<i class='fa fa-arrow-down'></i>"+
                                    "</button>"
            }
            
        ],
        "columnDefs": [
            { "searchPanes": {"show": true} }
        ],
        "createdRow": function( row, data, dataIndex ) {   
            console.log(data);    
            $(row).addClass("has-text-black-bis "+data.status.color);
        },
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.11.1/i18n/ru.json'
        },
        "initComplete": function () {

            //table.searchPanes.container().prependTo(table.table().container());
            //table.searchPanes.container().hide();
            table.searchPanes.container().appendTo('#orders_filter_modal');
            $('.dataTables_info').appendTo('#info');
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
        "dom":'<"columns table_btn buttons"<"column"B><"column"f>>Prt',    
    });
    //ПРи нажатии на кноку детали на каждой строчке таблицы
    $('#orders').on('click', 'tbody .detail', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
        }
    } );
    //таблица подробной информаци на каждой строчке заказа
    function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
                '<td>Клиент</td>'+
                '<td>'+d.client+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Примечание:</td>'+
                '<td>'+d.comment+'</td>'+
            '</tr>'+
        '</table>';
    }
    //????
    $('#orders').on('requestChild.dt', function(e, row) {
        row.child(format(row.data())).show();
    });
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
}
show_orders();

//заполняеться select данными из соответственнх таблиц
function read_city_status_users() {
    $.ajax({
        url: 'orders/read_city_status_users',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            for(var i = 0; i < Object.keys(data.city).length; i++) {
                $("#city").append("<option value='"+data.city[i]._id+"'>"+data.city[i].city_name+"</option>");
            }
            for(var i = 0; i < Object.keys(data.status).length; i++) {
                $("#status").append("<option value='"+data.status[i]._id+"'>"+data.status[i].status_name+"</option>");
            }
            status_users = data.status;
            /*for(var i = 0; i < Object.keys(data.users).length; i++) {
                $("#users").append("<option value='"+data.users[i]._id+"'>"+data.users[i].display+"</option>");
            }*/
        }
    });
}
read_city_status_users();

$(".reload").on('click', function(){
    table.ajax.reload( null, false ); 
});

//При нажатии на кнопку редактировать возле каждого заказа
$('#orders').on('click','tbody .edit', function() {
    $('#order_form').get(0).reset();
    $("#order_modal").addClass("is-active");
    $('.modal-card-title').text('Редактирование заказа');
    $('#save').text('Редактировать');
    var data = table.row($(this).closest('tr')).data();
    
    for (key in data ){
        $('[name=' + key +']').val(data[key]);
        if(typeof data[key] === 'object' && data[key]) {
            $('[name=' + key +']').val(data[key]._id);
        }
        $('[name=' + key +']').siblings().val(data[key]); 
    }
});

//input data
var date = new bulmaCalendar('input[name="date"]', {
    dateFormat: 'dd.MM.yyyy', // 01.01.2021
    showHeader: false,
    showFooter: false
});
var work_start_date = new bulmaCalendar('input[name="work_start_date"]', {
    dateFormat: 'dd.MM.yyyy', // 01.01.2021
    showHeader: false,
    showFooter: false
});
var d = new Date();
var month = d.getMonth()+1;
var day = d.getDate();
var output = ((''+day).length<2 ? '0' : '') + day + '.' +
    ((''+month).length<2 ? '0' : '') + month + '.' +
    d.getFullYear();
//Сохранение заказа
$("#save").on('click', function(){
    if(date.value() !== '') {
        $('input[name="date"]').val(date.value());
    }
    if(work_start_date.value() !== '') {
        $('input[name="work_start_date"]').val(work_start_date.value());
    }
    $.ajax({
        url: 'orders/save',
        method: 'POST',
        data: $('#order_form').serialize(),
        success: function(data){
            if(data) {
                $('.notification_text').text('Данные сохранены');
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