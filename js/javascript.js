$("#save").click(function(){

    let data = {
        name: $("[data-name=\"name\"]").val(),
        email: $("[data-name=\"email\"]").val(),
        text: $("[data-name=\"text\"]").val(),
    }

    $.post("base/save", data, function (data) {

        if(data.status){

            $("[data-name=\"name\"]").removeClass("is-invalid").val("");
            $("[data-name=\"email\"]").removeClass("is-invalid").val("");
            $("[data-name=\"text\"]").removeClass("is-invalid").val("");

            let success = '<div class="alert alert-success d-flex align-items-center" role="alert">\n' +
                '  <div>\n' +
                '    Успех\n' +
                '  </div>\n' +
                '</div>';

            $(".toast-body").html(success);

            let toastLiveExample = $("#liveToast");
            var toast = new bootstrap.Toast(toastLiveExample);
            toast.show();


            setTimeout(function(){
                location.reload();
            }, 1000);
        }
        else{

            if(data.error.indexOf("name") >= 0){
                $("[data-name=\"name\"]").addClass("is-invalid");
            }
            else{
                $("[data-name=\"name\"]").removeClass("is-invalid");
            }

            if(data.error.indexOf("email") >= 0){
                $("[data-name=\"email\"]").addClass("is-invalid");
            }
            else{
                $("[data-name=\"email\"]").removeClass("is-invalid");
            }

            if(data.error.indexOf("text") >= 0){
                $("[data-name=\"text\"]").addClass("is-invalid");
            }
            else{
                $("[data-name=\"text\"]").removeClass("is-invalid");
            }

            if(data.error.indexOf("name") === -1
                && data.error.indexOf("email") === -1
                && data.error.indexOf("text") === -1){

                let dang = '<div class="alert alert-danger d-flex align-items-center" role="alert">\n' +
                    '  <div>\n' +
                    '    Ошибка\n' +
                    '  </div>\n' +
                    '</div>';

                $(".toast-body").html(dang);

                let toastLiveExample = $("#liveToast");
                var toast = new bootstrap.Toast(toastLiveExample);
                toast.show();

            }
        }
    }, 'json');
});

var url = document.URL;
let get = [];
let get_obj = {};

if(url.indexOf("?") >= 0){
    let get_s = url.split('?')[1];

    if(get_s.indexOf("&") >= 0){
        let arr_get = get_s.split('&');

        get.push(arr_get[0]);
        get.push(arr_get[1]);

    }
    else{
        get.push(get_s)
    }

    for(let i=0; i<get.length; i++){
        let arr_a = get[i].split('=');
        get_obj[arr_a[0]] = arr_a[1];
    }

    if(get_obj.sort != undefined){
        $('#select_sort option[value='+get_obj.sort+']').prop('selected', true);
    }

    if(get_obj.page != undefined){
        $('#next_'+get_obj.page).css({background: "orange"});
    }

}
else{
    $('#next_1').css({background: "orange"});
}

$(".next_btn").click(function(){
    console.log("next_btn");

    let page = $(this).attr("id");

    page = page.replace("next_", "");

    get_obj.page = page;
    location_get();

});

$("#select_sort").change(function(){
    get_obj.sort = $(this).val();
    location_get();
});

function location_get(){

    let path = '';
    for(var index in get_obj) {
        if(path == ''){
            path = "?"+index+"="+get_obj[index];
        }
        else{
            path += "&"+index+"="+get_obj[index];
        }
    }
    window.location.href = path;
}

$("#entrance").click(function(){

    let data = {
        login: $("[data-name=\"login\"]").val(),
        password: $("[data-name=\"password\"]").val(),
    }

    $.post("base/authorization", data, function (data) {

        if(data.status){

            let success = '<div class="alert alert-success d-flex align-items-center" role="alert">\n' +
                '  <div>\n' +
                '    Успех\n' +
                '  </div>\n' +
                '</div>';

            $(".toast-body").html(success);

            let toastLiveExample = $("#liveToast");
            var toast = new bootstrap.Toast(toastLiveExample);
            toast.show();

            setTimeout(function(){
                location.reload();
            }, 1000);
        }
        else{

            if(data.error != null){
                if(data.error.indexOf("login") >= 0){
                    $("[data-name=\"login\"]").addClass("is-invalid");
                }
                else{
                    $("[data-name=\"login\"]").removeClass("is-invalid");
                }

                if(data.error.indexOf("password") >= 0){
                    $("[data-name=\"password\"]").addClass("is-invalid");
                }
                else{
                    $("[data-name=\"password\"]").removeClass("is-invalid");
                }

                if(data.error.indexOf("login") === -1
                    && data.error.indexOf("password") === -1){


                    let dang = '<div class="alert alert-danger d-flex align-items-center" role="alert">\n' +
                        '  <div>\n' +
                        '    Ошибка авторизации\n' +
                        '  </div>\n' +
                        '</div>';

                    $(".toast-body").html(dang);

                    let toastLiveExample = $("#liveToast");
                    var toast = new bootstrap.Toast(toastLiveExample);
                    toast.show();


                }

            }
            else{
                let dang = '<div class="alert alert-danger d-flex align-items-center" role="alert">\n' +
                    '  <div>\n' +
                    '    Ошибка авторизации\n' +
                    '  </div>\n' +
                    '</div>';

                $(".toast-body").html(dang);

                let toastLiveExample = $("#liveToast");
                var toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }
        }
    }, 'json');

});

$("#exit").click(function(){

    $.get("base/exit", function (data) {

        if(data.status){
            location.reload();
        }
        else{}

    }, 'json');

});

$(".edit_form").click(function (){
    $("#editModal").modal("show");
    $("[data-name=\"edit_text\"]").val($(this).attr("text_row"));

    if($(this).attr("status_row") == 1){
        $("[data-name=\"edit_status\"]").prop('checked', true);
    }
    else{
        $("[data-name=\"edit_status\"]").prop('checked', false);
    }

    $("[data-name=\"id_row\"]").val($(this).attr("id_row"));
});

$("#save_edit").click(function(){
    console.log("save");

    let edit_status = false;

    if ($('[data-name=\"edit_status\"]').is(":checked"))
    {
        edit_status = true;
    }

    let data = {
        text: $("[data-name=\"edit_text\"]").val(),
        status: edit_status,
        id: $("[data-name=\"id_row\"]").val()
    }

    $.post("base/saveform", data, function (data) {

        if(data.status){

            let success = '<div class="alert alert-success d-flex align-items-center" role="alert">\n' +
                '  <div>\n' +
                '    Успех\n' +
                '  </div>\n' +
                '</div>';

            $(".toast-body").html(success);

            let toastLiveExample = $("#liveToast");
            var toast = new bootstrap.Toast(toastLiveExample);
            toast.show();

            setTimeout(function(){
                location.reload();
            }, 1000);
        }
        else{

            if(data.error != null){
                if(data.error.indexOf("text") >= 0){
                    $("[data-name=\"text\"]").addClass("is-invalid");
                }
                else{
                    $("[data-name=\"text\"]").removeClass("is-invalid");
                }

                if(data.error.indexOf("status") >= 0){
                    $("[data-name=\"status\"]").addClass("is-invalid");
                }
                else{
                    $("[data-name=\"status\"]").removeClass("is-invalid");
                }

                if(data.error.indexOf("not_session") >= 0){

                    let dang = '<div class="alert alert-danger d-flex align-items-center" role="alert">\n' +
                        '  <div>\n' +
                        '    Ошибка авторизации\n' +
                        '  </div>\n' +
                        '</div>';

                    $(".toast-body").html(dang);

                    let toastLiveExample = $("#liveToast");
                    var toast = new bootstrap.Toast(toastLiveExample);
                    toast.show();
                }

            }
            else{
                let dang = '<div class="alert alert-danger d-flex align-items-center" role="alert">\n' +
                    '  <div>\n' +
                    '    Ошибка авторизации\n' +
                    '  </div>\n' +
                    '</div>';

                $(".toast-body").html(dang);

                let toastLiveExample = $("#liveToast");
                var toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }
        }
    }, 'json');
});