$(document).ready(function() {
//$("#main_login").hide().fadeIn(500);
//$("#div_new").hide().fadeIn(500);
function get_lang_param(par) {
var result="";
	$.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_lang_param"+
                "&param="+par,
                async: false,
                success: function(html){
                	//alert(html);
                	
                	result=html;
                }
                });
                //alert (res);
                return (result);
                
};


    $('textarea').autosize({append: "\n"});

    //$('#mc').prettyCheckable();


    $('#my-select').multiSelect({
    });

    $("#spinner").hide();
    $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});

    var settingsShow = function() {
        var showPanel = $(".chosen-select").find('option:selected').attr('id');
        //$("#settings-tabs .tab").hide();
        //$("#" + showPanel).fadeIn("fast");
        //alert(showPanel);
    }
    $(".chosen-select").chosen({
        no_results_text: "Не знайдено...",
        allow_single_deselect: true,
    });
    $(".chosen-select").chosen().change(settingsShow);
    //$.fn.editable.defaults.url = 'admin/edit_order.php';
    $.fn.editable.defaults.mode = 'inline';
    $("#user_info").hide();
    $("#alert_add").hide();

    $("#refer_to").hide();



        $("#fio").autocomplete({
        max: 10,
        minLength: 2,
        source: "json.php?fio",
        focus: function(event, ui) {
            $("#fio").val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            $("#fio").val(ui.item.label);
            //$("#user_login").val(ui.item.label2);
            $("#client_id_param").val(ui.item.value);
			$('#fio').popover('hide');
            $('#for_fio').removeClass('has-error').addClass('has-success');
            $("#user_info").hide().fadeIn(500);
            $("#alert_add").hide();
            //alert('ok');
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_client_from_new_t&get_client_info=" + ui.item.value,
                success: function(html) {
                    $("#user_info").hide().html(html).fadeIn(500);
                    $('#edit_login').editable({
                        inputclass: 'input-sm',
                        emptytext: 'пусто'
                    });
                    $('#edit_posada').editable({
                        inputclass: 'input-sm',
                        emptytext: 'пусто',
                        mode: 'popup',
                        showbuttons: false
                    });				$('#edit_unit').editable({
                        inputclass: 'input-sm',
                        emptytext: 'пусто',
                        mode: 'popup',
                        showbuttons: false
                    });				$('#edit_tel').editable({
                        inputclass: 'input-sm',
                        emptytext: 'пусто'
                    });				$('#edit_adr').editable({
                        inputclass: 'input-sm',
                        emptytext: 'пусто'
                    });				$('#edit_mail').editable({
                        inputclass: 'input-sm',
                        emptytext: 'пусто'
                    });
                    $('#for_fio').addClass('has-success');
                    $("#status_action").val('edit');

                }
            });
            //$("#city_id").val(ui.item.value);
            return false;
        },
        change: function(event, ui) {
            console.log(this.value);

            if ($('input#fio').val().length != 0){


                if (ui.item == null) {
                    //$("#user_login").val('');
                    $("#user_info").hide();
                    $("#status_action").val('add');
                    $('#fio').popover('hide');
                    $('#for_fio').removeClass('has-error');
                    $('#for_fio').addClass('has-success');
                    //$("#alert_add").hide().fadeIn(500);
                    $.ajax({
                        type: "POST",
                        url: "actions.php",
                        data: "mode=get_client_from_new_t&new_client_info="+$("#fio").val(),
                        success: function(html) {
                            $("#alert_add").hide().html(html).fadeIn(500);
                            $('#username').editable({
                                inputclass: 'input-sm',
                                emptytext: 'пусто'
                            });
                            $('#new_login').editable({
                                inputclass: 'input-sm',
                                emptytext: 'пусто'
                            });$('#new_posada').editable({
                                inputclass: 'input-sm posada_class',
                                emptytext: 'пусто',
                                mode: 'popup',
                                showbuttons: false
                            });
                            $('#new_unit').editable({
                                inputclass: 'input-sm',
                                emptytext: 'пусто',
                                mode: 'popup',
                                showbuttons: false
                            });
                            $('#new_tel').editable({
                                inputclass: 'input-sm',
                                emptytext: 'пусто'
                            });
                            $('#new_adr').editable({
                                inputclass: 'input-sm',
                                emptytext: 'пусто'
                            });
                            $('#new_mail').editable({
                                inputclass: 'input-sm',
                                emptytext: 'пусто'
                            });
                        }
                    });
                } else {
                    //alert("selected item: " + ui.item.value);
                }

            }



        }









    });
        $("select#to").blur(function() {

        if ( $('select#to').val() != 0 ){

            $('#for_to').popover('hide');
            $('#for_to').removeClass('has-error');
            $('#for_to').addClass('has-success');
        }
        else {

            $('#for_to').popover('show');
            $('#for_to').addClass('has-error');

        }

    });

function createuserslist(unit_id) {
	//ajax 
	//alert(unit_id);
	
	$.ajax({
                            type: "POST",
                            url: "actions.php",
                            data: "mode=get_users_list"+
                                "&unit="+unit_id,
                            dataType: "json",
                            success: function(html){
                            $('select#users_do').empty();
                                if (html) {
                                    $.each(html, function(i, item) {
	                                    $('select#users_do')
										.append($("<option></option>")
										.attr("value",item.co)
										.text(item.name));
	                                    //item.name item.co
	                                    
                                    });
                                    }
                                    $('select#users_do').trigger('chosen:updated');
                                    //alert($('select#users_do').val());
                                    }
                                    
                                    });
	
	
	
	
}


    $("select#to").change(function() {
		var i=$('select#to').val();
        if ( $('select#to').val() != 0 ){

            $('#for_to').popover('hide');
            $('#for_to').removeClass('has-error');
            $('#for_to').addClass('has-success');
            
            createuserslist(i);
            //PROBLEM!
            
        }
        else {

            $('#for_to').popover('show');
            $('#for_to').addClass('has-error');

        }

    });

    $("select#subj").change(function() {

        if ( $('select#subj').val() != 0 ){

            $('#for_subj').popover('hide');
            $('#for_subj').removeClass('has-error');
            $('#for_subj').addClass('has-success');
        }
        else {

            $('#for_subj').popover('show');
            $('#for_subj').addClass('has-error');

        }

    });

    $("select#subj").blur(function() {

        if ( $('select#subj').val() != 0 ){

            $('#for_subj').popover('hide');
            $('#for_subj').removeClass('has-error');
            $('#for_subj').addClass('has-success');
        }
        else {

            $('#for_subj').popover('show');
            $('#for_subj').addClass('has-error');

        }

    });
    /*
     $("#subj").blur(function() {
     if($(this).val().length > 1) {
     // Enable submit button
     $("#subj").popover('hide');
     $("#for_subj").removeClass('has-error').addClass('has-success');

     } else {
     // Disable submit button
     $("#subj").popover('show');
     $("#for_subj").addClass('has-error');
     }
     });

     $("#subj").keypress(function() {
     if($(this).val().length > 1) {
     // Enable submit button
     $("#subj").popover('hide');
     $("#for_subj").removeClass('has-error').addClass('has-success');

     } else {
     // Disable submit button
     $("#subj").popover('show');
     $("#for_subj").addClass('has-error');
     }
     });
     */





    $('textarea#msg').keydown(function (e) {

        if (e.ctrlKey && e.keyCode == 13) {


            $("button#do_comment").click();


        }
    });



    $("textarea#msg").blur(function() {
        if($(this).val().length > 1) {
            // Enable submit button
            $("textarea#msg").popover('hide');
            $("#for_msg").removeClass('has-error').addClass('has-success');

        } else {
            // Disable submit button
            $("textarea#msg").popover('show');
            $("#for_msg").addClass('has-error');
        }
    });

    $("textarea#msg").keypress(function() {
        if($(this).val().length > 1) {
            // Enable submit button
            $("textarea#msg").popover('hide');
            $("#for_msg").removeClass('has-error').addClass('has-success');

        } else {
            // Disable submit button
            $("textarea#msg").popover('show');
            $("#for_msg").addClass('has-error');
        }
    });


    var options_workers = {
        currentPage: $("#cur_page").val(),
        totalPages: $("#total_pages").val(),
        bootstrapMajorVersion: 3,
        size: "small",
        //alignment:"center",
        itemContainerClass: function (type, page, current) {
            return (page === current) ? "active" : "pointer-cursor";
        },
        onPageClicked: function(e,originalEvent,type,page){
			var current=$("#curent_page").attr('value');

			if (page != current) {

            $("#curent_page").attr('value', page);

            //$('#alert-content').text("Page item clicked, type: "+type+" page: "+page);
            //$("#spinner").fadeIn(300);

            $.ajax({
                type: "POST",
                url: "inc/workers.inc.php",
                data: "page="+page+
                "&menu=list",
                success: function(html){
                    $("#content_worker").hide().html(html).fadeIn(500);
                    //$("#spinner").hide();
                    $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
            });
}

            //menu=out
            //page=N
        }

    }


    var options_in = {
        currentPage: $("#cur_page").val(),
        totalPages: $("#total_pages").val(),
        bootstrapMajorVersion: 3,
        size: "small",
        //alignment:"center",
        itemContainerClass: function (type, page, current) {
            return (page === current) ? "active" : "pointer-cursor";
        },
        onPageClicked: function(e,originalEvent,type,page){
			var current=$("#curent_page").attr('value');

			if (page != current) {

            $("#curent_page").attr('value', page);

            //$('#alert-content').text("Page item clicked, type: "+type+" page: "+page);
            $("#spinner").fadeIn(300);

            $.ajax({
                type: "POST",
                url: "inc/list_content.inc.php",
                data: "menu=in"+
                    "&page="+page,
                success: function(html){
                    $("#content").hide().html(html).fadeIn(500);
                    $("#spinner").hide();
                    $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
            });
}

            //menu=out
            //page=N
        }

    }
    var options_out = {
        currentPage: $("#cur_page").val(),
        totalPages: $("#total_pages").val(),
        bootstrapMajorVersion: 3,
        size: "small",
        itemContainerClass: function (type, page, current) {
            return (page === current) ? "active" : "pointer-cursor";
        },
        onPageClicked: function(e,originalEvent,type,page){
            //$('#alert-content').text("Page item clicked, type: "+type+" page: "+page);
            var current=$("#curent_page").attr('value');

			if (page != current) {
            $("#spinner").fadeIn(300);
            $("#curent_page").attr('value', page);
            $.ajax({
                type: "POST",
                url: "inc/list_content.inc.php",
                data: "menu=out"+
                    "&page="+page,
                success: function(html){
                    $("#content").hide().html(html).fadeIn(500);
                    $("#spinner").hide();
                    $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
            });
}

            //menu=out
            //page=N
        }

    }
    var options_arch = {
        currentPage: $("#cur_page").val(),
        totalPages: $("#total_pages").val(),
        bootstrapMajorVersion: 3,
        size: "small",
        itemContainerClass: function (type, page, current) {
            return (page === current) ? "active" : "pointer-cursor";
        },
        onPageClicked: function(e,originalEvent,type,page){
        var current=$("#curent_page").attr('value');

			if (page != current) {
            $("#curent_page").attr('value', page);
            //$('#alert-content').text("Page item clicked, type: "+type+" page: "+page);
            $("#spinner").fadeIn(300);

            $.ajax({
                type: "POST",
                url: "inc/list_content.inc.php",
                data: "menu=arch"+
                    "&page="+page,
                success: function(html){
                    $("#content").hide().html(html).fadeIn(500);
                    $("#spinner").hide();
                    $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
            });
}

            //menu=out
            //page=N
        }

    }

    $('#example_in').bootstrapPaginator(options_in);
    $('#example_out').bootstrapPaginator(options_out);
    $('#example_arch').bootstrapPaginator(options_arch);
	$('#example_workers').bootstrapPaginator(options_workers);

    /*
     $('#unit_id').editable({
     inputclass: 'input-sm',
     emptytext: 'пусто',
     value: $('#unit_id').attr("value"),    
     source: [
     {value: 1, text: 'Відділ впровадження інформаційних систем'},
     {value: 2, text: 'Сектор зв\'язку'},
     {value: 3, text: 'Відділ інформаційної безпеки та адміністрування мереж'},
     {value: 4, text: 'Відділ супроводження користувачів'},
     {value: 5, text: 'Відділ супроводження інформаційних систем'}
     ]
     });
     */

    $.ionSound({
        sounds: [
            "button_tiny"
        ]
    });


    var def_p = window.location.pathname.split("/");
    var def_filename = def_p[def_p.length-1];

    $.noty.defaults = {
        layout: 'top',
        theme: 'defaultTheme',
        type: 'information',
        text: '', // can be html or string
        dismissQueue: true, // If you want to use queue feature set this true
        template: '<div class="noty_message"><button type="button" class="close" style="padding-left: 2px;margin-top: -5px;" aria-hidden="true">&times;</button><span class="noty_text"></span></div>',
        animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 500 // opening & closing animation speed
        },
        timeout: false, // delay for closing event. Set false for sticky notifications
        force: false, // adds notification to the beginning of queue when set to true
        modal: false,
        maxVisible: 5, // you can set max visible notification for dismissQueue true option,
        killer: false, // for close all notifications before show
        closeWith: ['click'], // ['click', 'button', 'hover']
        callback: {
            onShow: function() {},
            afterShow: function() {},
            onClose: function() {},
            afterClose: function() {}
        },
        buttons: false // an array of buttons
    };






    /*
     <input type="hidden" id="main_last_new_ticket" value="<?php
     echo get_last_ticket_new($_SESSION['helpdesk_user_id']);
     ?>">
     ajax проверить новые заявки
     если есть то:
     сообщение
     если нет то:
     */





    function check_update() {
        //<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
        var ee=$("#main_last_new_ticket").val();
        //var hostadr=get_host_conf();
        if (ee) {
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=check_update"+
                    "&type=all"+
                    "&last_update="+ee,
                success: function(html){
                    if (html == "no") {//alert('no');
                    }
                    else {
                        var new_lu=html;	  											                  	
                        $.ajax({
                            type: "POST",
                            url: "actions.php",
                            data: "mode=list_ticket_update"+
                                "&last_update="+ee,
                            dataType: "json",
                            success: function(html){
                                if (html) {
                                    $.each(html, function(i, item) {
                                        var t='<div style=\'float: left;\'><a style=\'color: rgb(243, 235, 235); cursor: inherit;\' target=\'_blank\' href=\''+item.url+'/ticket.php?hash='+item.hash+'\'><strong>'+item.ticket+' #'+item.name+'</strong> </a></div><div style=\'float: right; padding-right: 10px;\'><small>'+item.time+'</small></div><br><hr style=\'margin-top: 5px; margin-bottom: 8px; border:0; border-top:0px solid #E4E4E4\'><a style=\'color: rgb(252, 252, 252); cursor: inherit;\' target=\'_blank\' href=\''+item.url+'/ticket.php?hash='+item.hash+'\'>'+item.at+'</a>';
                                        noty({
                                            text: t,
                                            layout: 'bottomRight',
                                            timeout: false
                                        });
                                        $.ionSound.play("button_tiny");
										$.titleAlert(item.up);
                                    });
                                }
                                $("#main_last_new_ticket").attr('value', new_lu);
                            }
                        });
                    }
                }});
        }
    };
    
    
    
        function check_update_index() {
        //<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
        var ee=$("#main_last_new_ticket").val();
        //var hostadr=get_host_conf();
        if (ee) {
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=check_update"+
                    "&type=all"+
                    "&last_update="+ee,
                success: function(html){
                    if (html == "no") {//alert('no');
                    }
                    else {
                        var new_lu=html;	  											                  	
                        $.ajax({
                            type: "POST",
                            url: "actions.php",
                            data: "mode=list_ticket_update"+
                                "&last_update="+ee,
                            dataType: "json",
                            success: function(html){
                                if (html) {
                                    $.each(html, function(i, item) {
                                        var t='<div style=\'float: left;\'><a style=\'color: rgb(243, 235, 235); cursor: inherit;\' target=\'_blank\' href=\''+item.url+'/ticket.php?hash='+item.hash+'\'><strong>'+item.ticket+' #'+item.name+'</strong> </a></div><div style=\'float: right; padding-right: 10px;\'><small>'+item.time+'</small></div><br><hr style=\'margin-top: 5px; margin-bottom: 8px; border:0; border-top:0px solid #E4E4E4\'><a style=\'color: rgb(252, 252, 252); cursor: inherit;\' target=\'_blank\' href=\''+item.url+'/ticket.php?hash='+item.hash+'\'>'+item.at+'</a>';
                                        noty({
                                            text: t,
                                            layout: 'bottomRight',
                                            timeout: false
                                        });
                                        $.ionSound.play("button_tiny");
										//$.titleAlert("Оновлено!");
										            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=last_news",
                success: function(html){
	                $('#last_news').html(html);
	                $('[data-toggle="tooltip"]').tooltip('hide');
	                $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
                });
                $('#spinner').show();
                                               $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=dashboard_t",
                success: function(html){
                
	                $('#dashboard_t').html(html);
	                $('#spinner').hide();
	                $('[data-toggle="tooltip"]').tooltip('hide');
	                $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
                });
                
                                                               $.ajax({
                type: "POST",
                url: "actions.php",
                dataType: "json",
                data: "mode=update_dashboard_labels",
                success: function(html){
						$.each(html, function(i, item) {
							$('#d_label_1').html(item.a);
							$('#d_label_2').html(item.b);
							$('#d_label_3').html(item.c);
						});
                }
                });
                
                
                                    });
                                }
                                $("#main_last_new_ticket").attr('value', new_lu);
                            }
                        });
                    }
                }});
        }
    };


    //check_update('hello');
if (def_filename == "notes.php") {

$.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_list_notes",
                success: function(html){
	                $('#table_list').html(html);
	                
	                $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_first_note",
                success: function(html){
	                                }
                });
                
                
                }
                });

		

		


}

    if (def_filename == "ticket.php") {
        setInterval(function(){
            var lu=$("#last_update").attr('value');
            var tid=$("#ticket_id").attr('value');
            check_update();
            $.ajax({
                type: "POST",
                url: "actions.php",
                dataType: "json",
                data: "mode=check_update_one"+
                    "&id="+tid+
                    "&last_update="+lu,
                success: function(html){


                    if (html) {
                        $.each(html, function(i, item) {


                            if (item.type == "update") {window.location = "ticket.php?hash="+item.hash+"&refresh"; }
                            else if (item.type == "comment") {
                                $.ajax({
                                    type: "POST",
                                    url: "actions.php",
                                    data: "mode=view_comment"+
                                        "&tid="+tid,
                                    success: function(r) {

                                        $("#comment_content").html(r);

                                        $("#last_update").attr('value',item.time);
                                    }
                                });

                            }
                            else if (item.type == "no") {

                            }



                        });

                    }

                }
            });




        },5000);


    }
    if (def_filename == "clients.php") {
        setInterval(function(){
            check_update();
        },5000);
    }

    if (def_filename == "profile.php") {
        setInterval(function(){
            check_update();
        },5000);
    }
        if (def_filename == "new.php") {
        setInterval(function(){
            check_update();
        },5000);
    }
    
            if (def_filename == "notes.php") {
            $('#buttons').hide();
        setInterval(function(){
            check_update();
        },5000);
    }

    if ((def_filename == "index.php") || (def_filename == "")) {
    //$('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
               $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=last_news",
                success: function(html){
	                $('#last_news').html(html);
	                //$('[data-toggle="tooltip"]').tooltip('hide');
	                //$('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
                });
                $('#spinner').show();
                               $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=dashboard_t",
                success: function(html){
	                $('#dashboard_t').html(html);
	                $('#spinner').hide();
	                //$('[data-toggle="tooltip"]').tooltip('hide');
	                $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                }
                });
                
                
                
        setInterval(function(){
            check_update_index();
            
            
        },5000);
        
    }


    if (def_filename == "reports.php") {

        $('#reportrange').daterangepicker(
            {
                ranges: {
                    'Сьогодні': [moment(), moment()],
                    'Вчора': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'За тиждень': [moment().subtract('days', 6), moment()],
                    'За 30 днів': [moment().subtract('days', 29), moment()],
                    'За місяць': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлий місяць': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('#d_start').attr('value', start.format('YYYY-MM-DD'));
                $('#d_stop').attr('value', end.format('YYYY-MM-DD'));
            }
        );

    }




if (def_filename == "helper.php") {
setInterval(function(){
            check_update();
        },5000);
        
$.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=list_help",
                success: function(html) {
                $("#help_content").html(html);
}
});
};




if (def_filename == "stats.php") {
       setInterval(function(){
            check_update();
        },5000);
	}




    if (def_filename == "list.php") {
        //alert('ok');
        setInterval(function(){
            var oo=$("#curent_page").attr('value');
            var pt=$("#page_type").attr('value');
            var lt=$("#last_ticket").attr('value');

            check_update();


            /*
             самое последнее изменение или создание старше чем то что есть то обновить.
             */
            //alert(oo);


            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=check_update"+
                    "&type="+pt+
                    "&last_update="+lt,
                success: function(html){
                    //alert(html);
                    if (html == "no") {//alert('no');
                    }
                    else {//alert('up');
                        if (oo == "null") {
                            window.location = "list.php?"+pt;
                        }

                        var new_lu=html;


                        //noty({text: '<i class=\"fa fa-refresh\"></i> Оновлено заявки!'});
                        $.ajax({
                            type: "POST",
                            url: "inc/list_content.inc.php",
                            data: "menu="+pt+
                                "&page="+oo,
                            success: function(html){
                                $('[data-toggle="tooltip"]').tooltip('hide');
                                $("#content").html(html);

                                ////////////////////last_ticket _UPDATE!!!!!!
                                $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                            }
                        });


//update labels;
							$.ajax({
                            type: "POST",
                            url: "actions.php",
                            data: "mode=update_list_labels",
                            dataType: "json",
                            success: function(html){
                                if (html) {
                                    $.each(html, function(i, item) {
                                    //alert(item.in);
                                    $('span#label_list_in').html(item.in);
                                    $('span#label_list_out').html(item.out);
                                    //label_list_out
                                    
                                    });
                                    }
                                    }
                                    });


                        //alert(new_lu+' & '+lt);
                        $("#last_ticket").attr('value', new_lu);



                    }

                }
            });








            /*

             $.ajax({
             type: "POST",
             url: "list_content.inc.php",
             data: "menu="+pt+
             "&page="+oo,
             success: function(html){
             $('[data-toggle="tooltip"]').tooltip('hide');
             $("#content").html(html);
             //$("#spinner").hide();
             $('[data-toggle="tooltip"]').tooltip({container: 'body'});
             }
             });

             */

        },5000);
    }



    $("#fio_find").autocomplete({
        max: 10,
        minLength: 2,
        source: "json.php?fio",
        focus: function(event, ui) {
            $("#fio_find").val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=find_worker"+
                    "&fio="+$("input#fio_find").val(),
                success: function(html) {
                    //alert(html);
                    //window.location = "users.php?create&ok";
                    $("#content_worker").hide().html(html).fadeIn(500);
                    //$("textarea#msg").val('')

                }
            });
            return false;
        }
    });

    $('body').on('click', 'button#create_new_help', function(event) {
        event.preventDefault();
        
        $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=create_helper",
                success: function(html) {
                    //alert(html);
                    //window.location = "users.php?create&ok";
                    $("#help_content").hide().html(html).fadeIn(500);
                        var settingsShow = function() {
        var showPanel = $(".chosen-select").find('option:selected').attr('id');
    }
    $(".chosen-select").chosen({
        no_results_text: "Не знайдено...",
        allow_single_deselect: true,
    });
    $(".chosen-select").chosen().change(settingsShow);
    $('#summernote_help').summernote({
	  height: 300,   //set editable area's height
	  focus: true,
	  lang: 'uk-UA'
  });

                }
            });

        
        
        });
        
        
        //add_worker
        /*
        $('body').on('click', 'button#add_worker', function(event) {
        event.preventDefault();
        $.ajax({
        		type: "POST",
                url: "inc/workers.inc.php",
                data: "menu=new",
                success: function(html){
                $('#content_worker').html(html);
                }
                });
        });
        */
        
    $('body').on('click', 'button#action_refer_to', function(event) {
        event.preventDefault();
        var st=$("#action_refer_to").attr('value');


        if (st == '0') {
            $("#refer_to").fadeIn(500);
            $(this).addClass('active').attr('value', '1');
        }
        if (st == '1') {
            $("#refer_to").fadeOut(500);
            $(this).removeClass('active').attr('value', '0');
        }


    });
    
                $('body').on('click', 'button#save_notes', function(event) {
        event.preventDefault();
        var u=$(this).attr('value');
        var sHTML = $('#summernote').code();
        var data = { 'mode' : 'save_notes', 'hn' : u, 'msg' : sHTML };
        
        $.ajax({
        		type: "POST",
                url: "actions.php",
                
                data: data,
                success: function(html){
                //console.log(html);
                	                 $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_list_notes",
                success: function(html){
	                $('#table_list').html(html);
	                
	                
	                noty({
                                            text: "Запис збережено",
                                            layout: 'center',
                                            type: 'information',
                                            timeout: 2000

                                        });
	                
	                
                }
                });
                }
                });
        
        });

            $('body').on('click', 'a#to_notes', function(event) {
        event.preventDefault();
        var u=$(this).attr('value');
        var hostadr=get_host_conf();
        var langp=get_lang_param('JS_save');
        var langup=get_lang_param('JS_pub');

        //$('#save_notes').attr('value', u);
        $('#exampleInputEmail1').attr('value', hostadr+"/note.php?h="+u);
		
        $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_notes"+
                "&hn="+u,
                success: function(html){
                $('#summernote').destroy();

                $('#summernote').html(html);
                $('#buttons').show();
                
$('#summernote').summernote({
	  height: 300,   //set editable area's height
	  focus: true,
	  lang: 'uk-UA',
	  oninit: function() {
            // Add "open" - "save" buttons
            var openBtn = '<button id="save_notes" value="'+u+'" type="button" class="btn btn-success btn-sm btn-small" title="'+langp+'" data-event="something" tabindex="-1"><i class="fa fa-check-circle"></i></button>';
            var saveBtn = '<button id="saveFileBtn" type="button" class="btn btn-warning btn-sm btn-small" title="'+langup+'" data-event="something" tabindex="-1" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-bullhorn"></i> </button>';
            var fileGroup = '<div class="note-file btn-group">' + openBtn + saveBtn + '</div>';
            $(fileGroup).prependTo($('.note-toolbar'));
            // Button tooltips
            $('#save_notes').tooltip({container: 'body', placement: 'bottom'});
            $('#saveFileBtn').tooltip({container: 'body', placement: 'bottom'});
            // Button events
            /*
            $('#openFileBtn').click(function(event) {
                loadContent(editor);
            });
            $('#saveFileBtn').click(function(event) {
                saveContent(editor);
            });
            */
        }
  });
                
                
                                }
                });
        
        });

function get_host_conf() {
var result="";
	$.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_host_conf",
                async: false,
                success: function(html){
                	//alert(html);
                	
                	result=html;
                }
                });
                //alert (res);
                return (result);
                
};
//var mmm=get_host_conf();
//alert(mmm);
//get_host_conf();

/*
$('body').on('click', 'button#delete_user', function(event) {
        event.preventDefault();
        var n_id=$(this).attr('value');
        var lang_del=get_lang_param('JS_del');
        
        
                        bootbox.confirm(lang_del, function(result) {
  if (result == true) {
	  $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=del_user"+
                "&nid="+n_id,
                success: function(html){
                //alert(html);
	                 $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_list_notes",
                success: function(html){
	             window.location = "users.php?list";
                }
                });
                }
                });
	  
	  
  }
  else if (result == false) {}
});
        
        
        
        
        
        });
*/

        $('body').on('click', 'button#del_notes', function(event) {
        event.preventDefault();
        var n_id=$(this).attr('value');
        var langp=get_lang_param('JS_create');
        /*$.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=del_notes"+
                "&nid="+$(this).attr('value'),
                success: function(html){
                //alert(html);
	                 $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_list_notes",
                success: function(html){
	                $('#table_list').html(html);
	                $('#summernote').destroy();

                $('#summernote').html("<div class=\"jumbotron\"><p><center>Створіть новий запис або оберіть...</center></p></div>");
                $('#buttons').hide();
                }
                });
                }
                });
                */
                var lang_del=get_lang_param('JS_del');
                bootbox.confirm(lang_del, function(result) {
  if (result == true) {
	  $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=del_notes"+
                "&nid="+n_id,
                success: function(html){
                //alert(html);
	                 $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_list_notes",
                success: function(html){
	                $('#table_list').html(html);
	                $('#summernote').destroy();

                $('#summernote').html("<div class=\"jumbotron\"><p><center>"+langp+"</center></p></div>");
                $('#buttons').hide();
                }
                });
                }
                });
	  
	  
  }
  else if (result == false) {}
});
        });
    $('body').on('click', 'button#create_new_note', function(event) {
        event.preventDefault();
        var langp=get_lang_param('JS_save');
        var langup=get_lang_param('JS_pub');
        $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=create_notes",
                success: function(html){
                //alert(html);
                
                
                
                
                var u=html;
                var hostadr=get_host_conf();
                //$('#save_notes').attr('value', u);
                $('#exampleInputEmail1').attr('value', hostadr+"/note.php?h="+u);
                        $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_notes"+
                "&hn="+u,
                success: function(html){
                $('#summernote').destroy();

                $('#summernote').html(html);
                $('#buttons').show();
                
$('#summernote').summernote({
	  height: 300,   //set editable area's height
	  focus: true,
	  lang: 'uk-UA',
	  oninit: function() {
            // Add "open" - "save" buttons
            var openBtn = '<button id="save_notes" value="'+u+'" type="button" class="btn btn-success btn-sm btn-small" title="'+langp+'" data-event="something" tabindex="-1"><i class="fa fa-check-circle"></i></button>';
            var saveBtn = '<button id="saveFileBtn" type="button" class="btn btn-warning btn-sm btn-small" title="'+langup+'" data-event="something" tabindex="-1" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-bullhorn"></i> </button>';
            var fileGroup = '<div class="note-file btn-group">' + openBtn + saveBtn + '</div>';
            $(fileGroup).prependTo($('.note-toolbar'));
            // Button tooltips
            $('#save_notes').tooltip({container: 'body', placement: 'bottom'});
            $('#saveFileBtn').tooltip({container: 'body', placement: 'bottom'});
            // Button events
            /*
            $('#openFileBtn').click(function(event) {
                loadContent(editor);
            });
            $('#saveFileBtn').click(function(event) {
                saveContent(editor);
            });
            */
        }
  });

                
                }
                });
                
                
                
                
                
                
                
                
                
                
	                        $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=get_list_notes",
                success: function(html){
	                $('#table_list').html(html);
                }
                });
                }
                });
                
        
                
                
                
                
        
        });
    
    
    
   

    $('body').on('click', 'button#units_del', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=units_del"+
                "&id="+$(this).attr('value'),
            success: function(html) {
                $("#content_units").html(html);
                //$("#subj_text").val('');
            }
        });

    });




    $('body').on('click', 'button#do_report', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=get_report"+
                "&id="+$("#user_report").val()+
                "&s="+$("#d_start").val()+
                "&e="+$("#d_stop").val(),
            success: function(html) {
                $("#content_report").html(html);
                //$("#subj_text").val('');
            }
        });

    });


    $('body').on('click', 'button#units_add', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=units_add"+
                "&text="+$("#units_text").val(),
            success: function(html) {
                $("#content_units").html(html);
                $("#units_text").val('');
            }
        });

    });


    $('body').on('click', 'button#subj_del', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=subj_del"+
                "&id="+$(this).attr('value'),
            success: function(html) {
                $("#content_subj").html(html);
                //$("#subj_text").val('');
            }
        });

    });


    $('body').on('click', 'button#subj_add', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=subj_add"+
                "&text="+$("#subj_text").val(),
            success: function(html) {
                $("#content_subj").html(html);
                $("#subj_text").val('');
            }
        });

    });

    
    
        $('body').on('click', 'button#deps_del', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=deps_del"+
                "&id="+$(this).attr('value'),
            success: function(html) {
                $("#content_deps").html(html);
                //$("#subj_text").val('');
            }
        });

    });
        $('body').on('click', 'button#deps_add', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=deps_add"+
                "&text="+$("#deps_text").val(),
            success: function(html) {
                $("#content_deps").html(html);
                $("#deps_text").val('');
            }
        });

    });


    $('body').on('click', 'button#posada_add', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=posada_add"+
                "&text="+$("#posada_text").val(),
            success: function(html) {
                $("#content_posada").html(html);
                $("#posada_text").val('');
            }
        });

    });
    $('body').on('click', 'button#posada_del', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../actions.php",
            data: "mode=posada_del"+
                "&id="+$(this).attr('value'),
            success: function(html) {
                $("#content_posada").html(html);
                //$("#subj_text").val('');
            }
        });

    });

    //$('#enable').click(function() {
    // $('#edit_subj_ticket').editable('toggleDisabled');
    //$('#edit_msg_ticket').editable('toggleDisabled');

    $('body').on('click', 'button#editable_enable', function(event) {
        event.preventDefault();
        //$('#editable_enable').click(function() {
        $('#edit_subj_ticket').editable('toggleDisabled');
        $('#edit_msg_ticket').editable('toggleDisabled');
    });


    $('body').on('click', 'button#action_aprove_yes', function(event) {
        event.preventDefault();
        var table_id = $(this).attr('value');
        var elem = "#table_" + table_id;

        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=aprove_yes"+
                "&id="+table_id,
            success: function() {
                $(elem).fadeOut(500);
                //alert(html);
            }
        });

    });

    $('body').on('click', 'button#action_aprove_no', function(event) {
        event.preventDefault();
        var table_id = $(this).attr('value');
        var elem = "#table_" + table_id;

        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=aprove_no"+
                "&id="+table_id,
            success: function() {
                $(elem).fadeOut(500);
                //alert(html);
            }
        });

    });




    $('body').on('click', 'button#edit_profile_main', function(event) {
        event.preventDefault();


        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=edit_profile_main"+
                "&login="+$("#login").val()+
                "&mail="+$("#mail").val()+
                "&id="+$("#edit_profile_main").attr('value'),
            success: function(html) {
                //alert(html);
                //window.location = "users.php?create&ok";
                $("#m_info").hide().html(html).fadeIn(500);


            }
        });
    });


    $('body').on('click', 'button#edit_profile_pass', function(event) {
        event.preventDefault();


        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=edit_profile_pass"+
                "&old_pass="+$("#old_pass").val()+
                "&new_pass="+$("#new_pass").val()+
                "&new_pass2="+$("#new_pass2").val()+
                "&id="+$("#edit_profile_main").attr('value'),
            success: function(html) {
                //alert(html);
                //window.location = "users.php?create&ok";
                $("#p_info").hide().html(html).fadeIn(500);


            }
        });
    });


//send_zapit_add
$('body').on('click', 'button#send_zapit_add', function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=send_zapit_add"+"&"+
                $('#form_approve').serialize()
            ,
            success: function(html) {
                //alert(html);
                //window.location = "users.php?create&ok";
                $("#sze_info").hide().html(html).fadeIn(500);




                //$("#sze_info").hide().html(html).fadeIn(500);

                //$("textarea#msg").val('')
                $("#send_zapit_add").fadeOut(500);

            }
        });
    });


    $('body').on('click', 'button#send_zapit_edit_ok', function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=send_zapit_edit_ok"+"&"+
                $('#form_approve').serialize()
            ,
            success: function(html) {
                //alert(html);
                //window.location = "users.php?create&ok";
                $("#sze_info").hide().html(html).fadeIn(500);




                //$("#sze_info").hide().html(html).fadeIn(500);

                //$("textarea#msg").val('')
                $("#send_zapit_edit_ok").fadeOut(500);

            }
        });
    });



    $('body').on('click', 'button#send_zapit_edit', function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=send_zapit_edit"+"&"+
                $('#form_approve').serialize()
            ,
            success: function(html) {
                //alert(html);
                //window.location = "users.php?create&ok";
                $("#sze_info").hide().html(html).fadeIn(500);




                //$("#sze_info").hide().html(html).fadeIn(500);

                //$("textarea#msg").val('')
                $("#send_zapit_edit").fadeOut(500);

            }
        });
    });


    $('body').on('click', 'button#do_find', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=find_worker"+
                "&fio="+$("input#fio_find").val(),
            success: function(html) {
                //alert(html);
                //window.location = "users.php?create&ok";
                $("#content_worker").hide().html(html).fadeIn(500);
                //$("textarea#msg").val('')

            }
        });
    });





    $('body').on('click', 'button#do_comment', function(event) {
        event.preventDefault();
        var tid=$(this).attr('value');
        var usr=$(this).attr('user');
        var m=$("textarea#msg").val().length;




        var error_code=0;
        if (m == 0) {
            error_code=1;
            $("textarea#msg").popover('show');
            $("#for_msg").addClass('has-error');

        }

        if (error_code == 0) {




            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=add_comment"+
                    "&user="+usr+
                    "&textmsg="+$("textarea#msg").val().replace(/\r\n|\r|\n/g,"<br />")+
                    "&tid="+tid,
                success: function(html) {
                    //alert(html);
                    //window.location = "users.php?create&ok";
                    $("#comment_content").html(html);
                    $("textarea#msg").val('')

                }
            });


        }

    });

    $('body').on('click', 'button#prio_low', function(event) {
        event.preventDefault();
        $('button#prio_low').addClass('active');
        $('button#prio_normal').removeClass('active');
        $('button#prio_high').removeClass('active');
        $('i#lprio_low').addClass('fa fa-check');
        $("i#lprio_norm").removeClass("fa fa-check");
        $("i#lprio_high").removeClass("fa fa-check");
        $("#prio").val('0');
    });

    $('body').on('click', 'button#prio_normal', function(event) {
        event.preventDefault();
        $('button#prio_low').removeClass('active');
        $('button#prio_normal').addClass('active');
        $('button#prio_high').removeClass('active');
        $('i#lprio_low').removeClass('fa fa-check');
        $("i#lprio_norm").addClass("fa fa-check");
        $("i#lprio_high").removeClass("fa fa-check");
        $("#prio").val('1');
    });

    $('body').on('click', 'button#prio_high', function(event) {
        event.preventDefault();
        $('button#prio_low').removeClass('active');
        $('button#prio_normal').removeClass('active');
        $('button#prio_high').addClass('active');
        $('i#lprio_low').removeClass('fa fa-check');
        $("i#lprio_norm").removeClass("fa fa-check");
        $("i#lprio_high").addClass("fa fa-check");
        $("#prio").val('2');
    });




    $('body').on('click', 'button#create_user', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=add_user"+
                "&fio="+$("#fio").val()+
                "&login="+$("#login").val()+
                "&pass="+$("#exampleInputPassword1").val()+
                "&unit="+$("#my-select").val()+
                "&priv="+$("input[type=radio][name=optionsRadios]:checked").val()+
                "&mail="+$("#mail").val(),
            success: function(html) {
                //alert(html);
                window.location = "users.php?create&ok";

            }
        });
    });
    ////////////////////////////////////
        $('body').on('click', 'button#edit_helper', function(event) {
        event.preventDefault();
        var hn=$(this).val();
        
                $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=edit_helper"+
            "&hn="+hn,
			success: function(html) {
				$("#help_content").html(html);
				                        var settingsShow = function() {
        var showPanel = $(".chosen-select").find('option:selected').attr('id');
    }
    $(".chosen-select").chosen({
        no_results_text: "Не знайдено...",
        allow_single_deselect: true,
    });
    $(".chosen-select").chosen().change(settingsShow);
    $('#summernote_help').summernote({
	  height: 300,   //set editable area's height
	  focus: true,
	  lang: 'uk-UA'
  });
			}
			});
        });
        $('body').on('click', 'button#del_helper', function(event) {
        event.preventDefault();
        var hn=$(this).val();
        
        var langdel= get_lang_param('JS_del');
        
        bootbox.confirm(langdel, function(result) {
  if (result == true) {        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=del_help"+
            "&hn="+hn,
			success: function(html) {
			
			$.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=list_help",
                success: function(html) {
                $("#help_content").html(html);
}
});
			
			}
			});
  }
  });
        
        
        


        
        });
//do_save_help
    $('body').on('click', 'button#do_save_help', function(event) {
        event.preventDefault();
        var sHTML = $('#summernote_help').code();
        var hn = $(this).val();
        var u=$("#u").chosen().val();
		
		var lang_unit= get_lang_param('JS_unit');
		var lang_probl= get_lang_param('JS_probl');
        var t=$("#t").val();
        var data = { 'mode' : 'do_save_help', 'u' : u, 't' : t, 'msg' : sHTML, 'hn': hn };
        
        var error_code=0;
                if (u == null) { 
	        error_code=1;
	        noty({
                                            text: lang_unit,
                                            layout: 'center',
                                            type: 'information',
                                            timeout: 2000

                                        });
        }
        
        if ($("#t").val().length == 0 ) { error_code=1; 
	        noty({
                                            text: lang_probl,
                                            layout: 'center',
                                            type: 'information',
                                            timeout: 2000

                                        });
        }
        
        if (error_code == 0) {
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: data,
            success: function(html) {
            
                //alert(html);
                window.location = "helper.php";

            }
        });
}
        });
        
        
    $('body').on('click', 'button#do_create_help', function(event) {
        event.preventDefault();
        var sHTML = $('#summernote_help').code();
       
        var u=$("#u").chosen().val();
		var lang_unit= get_lang_param('JS_unit');
		var lang_probl= get_lang_param('JS_probl');

        var t=$("#t").val();
        var data = { 'mode' : 'do_create_help', 'u' : u, 't' : t, 'msg' : sHTML };
        
        var error_code=0;
        
        //alert (u);
        if (u == null) { 
	        error_code=1;
	        noty({
                                            text: lang_unit,
                                            layout: 'center',
                                            type: 'information',
                                            timeout: 2000

                                        });
        }
        
        if ($("#t").val().length == 0 ) { error_code=1; 
	        noty({
                                            text: lang_probl,
                                            layout: 'center',
                                            type: 'information',
                                            timeout: 2000

                                        });
        }
        
        if (error_code == 0) {
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: data,
            success: function(html) {
            
                //alert(html);
                window.location = "helper.php";

            }
        });
}
        });
//find_helper
$("input#find_helper").keyup(function() {
	var t=$(this).val();
	
	
	
	$.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=find_help"+
            "&t="+t,
			success: function(html) {
			$("#help_content").html(html);
			}
			});


});


$("input#fio_find_admin").keyup(function() {
	var t=$(this).val(),
		t_l=$(this).val().length;
	
	
	console.log(t_l);
	
	if (t_l > 0 ) {
		$('#example_workers').hide();
	}
	if (t_l == 0 ) {
		$('#example_workers').show();
	}
	
	$.ajax({
            type: "POST",
            url: "inc/workers.inc.php",
            data: "menu=list"+
            "&page=1"+
            "&t="+t,
			success: function(html) {
			$("#content_worker").html(html);
			
			
			}
			});


});


    $('body').on('click', 'button#edit_user', function(event) {
        event.preventDefault();
        var usid = $(this).attr('value');
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=edit_user"+
                "&fio="+$("#fio").val()+
                "&login="+$("#login").val()+
                "&pass="+$("#exampleInputPassword1").val()+
                "&unit="+$("#my-select").val()+
                "&priv="+$("input[type=radio][name=optionsRadios]:checked").val()+
                "&status="+$("#lock").val()+
                "&mail="+$("#mail").val()+
                "&idu="+usid,
            success: function(html) {
                //alert(html);
                window.location = "users.php?edit="+usid+"&ok";

            }
        });
    });



    $('#edit_subj_ticket').editable({
        inputclass: 'input-sm',
        emptytext: 'пусто',
        params: {
            mode: 'edit_ticket_subj'
        }
    });
    $('#edit_msg_ticket').editable({
        inputclass: 'input-sm',
        emptytext: 'пусто',
        params: {
            mode: 'edit_ticket_msg'}
    });

    $('body').on('click', 'button#action_list_ok', function(event) {
        event.preventDefault();
        var status_ll = $(this).attr('status');
        var tr_id = $(this).attr('value');
        var elem = '#tr_' + tr_id;
        var us=$(this).attr('user');

        if (status_ll == "ok") {
            $(this).attr("status", "unok");
            $(this).html('<i class=\"fa fa-check-circle-o\"></i>');
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=status_no_ok"+
                    "&tid="+tr_id+
                    "&user="+us,
                success: function(){
                    //$("#msg").hide().html(html).fadeIn(500);
                    $(elem).removeClass().addClass('success', 1000);



                }
            });
        }
        if (status_ll == "unok") {
            $(this).attr("status", "ok");
            $(this).html('<i class=\"fa fa-circle-o\"></i>');
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=status_ok"+
                    "&tid="+tr_id+
                    "&user="+us,
                success: function(){
                    //$("#msg").hide().html(html).fadeIn(500);
                    $(elem).removeClass('success', 1000);



                }
            });
        }


    });


    $('body').on('click', 'button#action_arch_now', function(event) {
        event.preventDefault();

        var tr_id = $(this).attr('value');
        var elem = '#tr_' + tr_id;
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=arch_now"+
                "&tid="+tr_id,
            success: function(){
                //$("#msg").hide().html(html).fadeIn(500);

                //$("#msg").hide().html(html).fadeIn(500);
                //setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);
                $(elem).fadeOut(500);


            }
        });

    });
    $('body').on('click', 'button#action_del_time', function(event) {
        event.preventDefault();
        var tr_id = $(this).attr('value');
        var elem = '#tr_' + tr_id;
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: "mode=del_now"+
                "&tid="+tr_id,
            success: function(){
                //$("#msg").hide().html(html).fadeIn(500);

                //$("#msg").hide().html(html).fadeIn(500);
                //setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);
                $(elem).fadeOut(500);


            }
        });

    });

    $('body').on('click', 'button#action_list_lock', function(event) {
        event.preventDefault();

        var status_ll = $(this).attr('status');
        var tr_id = $(this).attr('value');
        var elem = '#tr_' + tr_id;
        var us=$(this).attr('user');

        //var button_id= "#action_list_lock [value='"+tr_id+"']";
        //alert(elem);


        if (status_ll == "lock") {

            $(this).attr("status", "unlock");
            $(this).html('<i class=\"fa fa-lock\"></i>');
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=lock"+
                    "&tid="+tr_id+
                    "&user="+us,
                success: function(){
                    //$("#msg").hide().html(html).fadeIn(500);

                    //$("#msg").hide().html(html).fadeIn(500);
                    //setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);
                    $(elem).removeClass().addClass('warning', 1000);


                }
            });


        }

        if (status_ll == "unlock") {


            $(this).attr("status", "lock");
            $(this).html('<i class=\"fa fa-unlock\"></i>');




            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=unlock"+
                    "&tid="+tr_id,
                success: function(){
                    //$("#msg").hide().html(html).fadeIn(500);

                    //$("#msg").hide().html(html).fadeIn(500);
                    //setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);
                    $(elem).removeClass('warning', 1000);


                }
            });






        }


    });





    $('body').on('click', 'button#action_ok', function(event) {
        event.preventDefault();
        var status_lock=$("button#action_ok").attr('status');
        var ok_val=$("button#action_ok").attr("value");
        var ok_val_tid=$("button#action_ok").attr("tid");
        var lang_ok= get_lang_param('JS_ok');
        if (status_lock == 'ok') {
            $("button#action_ok").attr('status', "no_ok").html("<i class=\"fa fa-check\"></i> "+lang_ok);
            $("button#action_lock").removeAttr('disabled');
            $("button#action_refer_to").removeAttr('disabled');
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=status_ok"+
                    "&tid="+ok_val_tid+
                    "&user="+ok_val,
                success: function(html){
                    //$("#msg").hide().html(html).fadeIn(500);

                    $("#msg").hide().html(html).fadeIn(500);
                    setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);


                }
            });
        }
        if (status_lock == 'no_ok') {
        	var lang_nook= get_lang_param('JS_no_ok');
            $("button#action_lock").attr('disabled', "disabled");
            $("button#action_refer_to").attr('disabled', "disabled");
            $("button#action_ok").attr('status', "ok").html("<i class=''></i> "+lang_nook);
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=status_no_ok"+
                    "&tid="+ok_val_tid+
                    "&user="+ok_val,
                success: function(html){
                    //$("#msg").hide().html(html).fadeIn(500);

                    $("#msg").hide().html(html).fadeIn(500);
                    setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);


                }
            });

        }



    });


    $('body').on('click', 'button#action_lock', function(event) {
        event.preventDefault();
        var lock_val=$("button#action_lock").attr("value");
        var lock_val_tid=$("button#action_lock").attr("tid");
        var status_lock=$("button#action_lock").attr('status');
var lang_unlock= get_lang_param('JS_unlock');
        if (status_lock == 'lock') {
            $("button#action_lock").attr('status', "unlock").html("<i class='fa fa-unlock'></i> "+lang_unlock);
            //$("div#alert_lock").fadeIn(500);
            $("#msg_e").hide();
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=lock"+
                    "&tid="+lock_val_tid+
                    "&user="+lock_val,
                success: function(html){
                    //$("#msg").hide().html(html).fadeIn(500);

                    $("#msg").hide().html(html).fadeIn(500);
                    setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);


                }
            });

        }
        if (status_lock == 'unlock') {
            $("#msg_e").hide();
            var lang_lock= get_lang_param('JS_lock');
            $("button#action_lock").attr('status', "lock").html("<i class='fa fa-lock'></i> "+lang_lock);
            //$("div#alert_lock").fadeOut(500);
            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=unlock"+
                    "&tid="+lock_val_tid,
                success: function(html){

                    $("#msg").hide().html(html).fadeIn(500);
                    setTimeout(function() {$('#msg').children('.alert').fadeOut(500);}, 3000);


                }
            });
        }




    });




    $('body').on('click', 'button#ref_ticket', function(event) {
        event.preventDefault();
        var to=$("select#t_to").val();
        var tou=$("select#t_users_do").val();
        //alert(to);
        var error_code=0;
        if (to == '0') {
            error_code=1;
            //alert('no');
            $('#t_for_to').popover('show');
            $('#t_for_to').addClass('has-error');

        }

        if (error_code == 0) {
            var pp=$("button#ref_ticket").attr("value");
            //to, pp, tou
            //alert(tou);

            $.ajax({
                type: "POST",
                url: "actions.php",
                data: "mode=update_to"+
                    "&ticket_id="+pp+
                    "&to="+to+
                    "&tou="+tou,
                success: function(html){
                    $("#ccc").hide().html(html).fadeIn(500);
                    window.location = "list.php?in";

                }
            });

        }

    });



    //$("#form_field").chosen().change( … );
    $("select#t_users_do").change(function() {

        var p=$('select#t_users_do').val();
        var t=$('select#t_to').val();
        //alert(p);


        if (t == 0 ) {
            if (p != 0 ) {
                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: "mode=get_unit_id"+
                        "&uid="+p,
                    success: function(html){




                        $("select#t_to [value='"+html+"']").attr("selected", "selected");
                        $('select#t_to').trigger('chosen:updated');
                        $('#t_for_to').popover('hide');
                        $('#t_for_to').removeClass('has-error');
                        $('#t_for_to').addClass('has-success');


                        //alert(n);
                    }
                });
            }
            if (p == 0 ) {
                $("select#t_to").find('option:selected').removeAttr("selected");
                $('select#t_to').trigger('chosen:updated');
            }
        }


    });



    $("select#users_do").change(function() {

        var p=$('select#users_do').val();
        var t=$('select#to').val();
        //alert(p);


        if (t == 0 ) {
            if (p != 0 ) {
                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: "mode=get_unit_id"+
                        "&uid="+p,
                    success: function(html){

//alert (html);


                        $("select#to [value='"+html+"']").attr("selected", "selected");
                        $('select#to').trigger('chosen:updated');
                        $('#for_to').popover('hide');
                        $('#for_to').removeClass('has-error');
                        $('#for_to').addClass('has-success');


                        //alert(n);
                    }
                });
            }
            if (p == 0 ) {
                $("select#to").find('option:selected').removeAttr("selected");
                $('select#to').trigger('chosen:updated');
            }
        }


    });




    $("select#t_to").change(function() {

        if ( $('select#t_to').val() != 0 ){

            $('#t_for_to').popover('hide');
            $('#t_for_to').removeClass('has-error');
            $('#t_for_to').addClass('has-success');
        }
        else {

            $('#t_for_to').popover('show');
            $('#t_for_to').addClass('has-error');

        }

    });


    $('body').on('click', 'button#enter_ticket', function(event) {
        event.preventDefault();
        var z=$("#username").text();
        var s=$("#subj").val();
        var to=$("select#to").val();
        var m=$("#msg").val().length;
        //alert(to);

	

//alert($("#users_do").val());

        var error_code=0;

        //if ($('#fio').val().length == 0 && $('#user_login').val().length == 0){
        if ($('#fio').val().length == 0){
            error_code=1;
            //alert('no');
            //$('#fio').popover('show');
            $('#fio').popover('show');
            $('#for_fio').addClass('has-error');
        }

        if (to == '0') {
            error_code=1;
            //alert('no');
            //$('#for_to').popover('show');
            $('#dsd').popover('show');
            $('#for_to').addClass('has-error');

        }

        if (s == 0) {
            error_code=1;
            $("#for_subj").popover('show');
            $("#for_subj").addClass('has-error');

        }
        if (m == 0) {
            error_code=1;
            $("#msg").popover('show');
            $("#for_msg").addClass('has-error');

        }







        if (error_code == 0) {

            var status_action=$("#status_action").val();
            if (status_action == 'edit') {

            }
            if (status_action =='add') {





                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: "mode=add_ticket"+
                        "&type_add=add"+
                        "&fio="+$("#username").text()+
                        "&tel="+$("#new_tel").text()+
                        "&login="+$("#new_login").text()+
                        "&pod="+$("#new_unit").text()+
                        "&adr="+$("#new_adr").text()+
                        "&tel="+$("#new_tel").text()+
                        "&mail="+$("#new_mail").text()+
                        "&posada="+$("#new_posada").text()+
                        "&user_init_id="+$("#user_init_id").val()+
                        "&user_do="+$("#users_do").val()+
                        "&subj="+$("#subj").val()+
                        "&msg="+$("#msg").val().replace(/\r\n|\r|\n/g,"<br />").replace(/'/g, '\'')+
                        "&unit_id="+$("#to").val()+
                        "&prio="+$("#prio").val()+
                        "&hashname="+$("#hashname").val(),
                    success: function(html) {
                        //alert(html);
                        window.location = "new.php?ok&h="+html;

                    }
                });




            }


            if (status_action =='edit') {
                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: "mode=add_ticket"+
                        "&type_add=edit"+
                        "&client_id_param="+$("#client_id_param").val()+
                        "&tel="+$("#edit_tel").text()+
                        "&login="+$("#edit_login").text()+
                        "&pod="+$("#edit_unit").text()+
                        "&adr="+$("#edit_adr").text()+
                        "&tel="+$("#edit_tel").text()+
                        "&mail="+$("#edit_mail").text()+
                        "&posada="+$("#edit_posada").text()+
                        "&user_init_id="+$("#user_init_id").val()+
                        "&user_do="+$("#users_do").val()+
                        "&subj="+$("#subj").val()+
                        "&msg="+$("#msg").val().replace(/\r\n|\r|\n/g,"<br />").replace(/'/g, '\'')+
                        "&unit_id="+$("#to").val()+
                        "&prio="+$("#prio").val()+
                        "&hashname="+$("#hashname").val(),
                    success: function(html) {
                        //alert(html);
                        window.location = "new.php?ok&h="+html;
                        //alert(html);
                    }
                });




            }


        }

    });


});