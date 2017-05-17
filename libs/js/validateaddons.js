$.validator.addMethod("regexp", function(value, element, regexp) {
    var re = new RegExp(regexp);
    return this.optional(element) || re.test(value);
}, "");
$.validator.addMethod("depends", function(value, element, params) {
    var res = params.split("$");
    var bool = false
    for (i = 1; i < res.length; i++) {
        if ($("#" + res[0]).val() === res[i]) {
            bool = true;
            break;
        }
    }
    console.log("entra")
    if (!bool)
        element.value = 0
    return bool;
}, "");


$(function() {
    $("#dialog-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 400,
        modal: true,
        buttons: {
            "Aceptar": function() {
                console.log("Entra2");
                //$(this).attr("acepto", true);
                console.log($("a[href*=eliminar]").attr("href"));
                window.location.href = $("a[href*=eliminar]").attr("href");
                $(this).dialog("close");

            },
            Cancelar: function() {
                console.log("Entra3");
                //$(this).attr("acepto",false);
                $(this).dialog("close");
            }
        }
    });
});
tableOptions = function() {
    var length = $(".row-table:checked").length;
    if (length === 0) {
        $(".table-options-one").hide();
        $(".table-options-mult").hide();
    } else if (length === 1) {
        var str = new RegExp("^.*/");
        $(".table-options-one").each(function() {
            var url = $("a", this).attr("href");
            r = str.exec(url);
            $("a", this).attr("href", r[0] + $(".row-table:checked").attr('data-val'))
        })
        $(".table-options-one").show();
        $(".table-options-mult").hide();
    } else {
        $(".table-options-mult").show();
        $(".table-options-one").hide();
    }
}
$(document).ready(function() {
    tableOptions();
    $(".row-table").on("click", function(el) {
        tableOptions();
    })

    $(".datepick").each(function() {
        $(this).datepicker({format: 'yyyy/mm/dd'});
    });
//    $(".report").append("<img style='width:40px;height:40px' src='"+BASE+"/img/excel.png'></div>");

    $(".slider-tabla").bootstrapSwitch({onText: "SI", offText: "NO"});
//    $(document).on("click", ".btn-control-agregar", function(ev) {
//        $(".contenedor-forms").append("<tr>" + $(".tr-original").html() + "</tr>")
//    });

    $("a[href*=eliminar]").on("click", function(ev) {
        console.log("Entra1");
        //alert("HOLA");
        ev.preventDefault();
        console.log($("#dialog-confirm").dialog("open").attr("acepto"));
    });
//    $(".report").attr("href",window.location.href+"/1")
    NProgress.done();
});
////////////////////////conectar con facebook
//App ID:1681772598704166
//API Version:v2.5
//App Secret:4b6804fc91280077edf58ebb3a55a4e2
window.fbAsyncInit = function() {
    FB.init({
        appId: '1681772598704166',
        xfbml: true,
        version: 'v2.5'
    });
};

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function crearBootstrapSwitch(clase, url) {

//    $(document).ready(function() {
//        $(clase).bootstrapSwitch();
//            alert("hola: "+clase);
    $(clase).on("switchChange.bootstrapSwitch", function(event, state) {
//            alert($(this).val());
        //console.log(event);
        //console.log(state);
//        alert(BASE + url);
        $.ajax({
//            url: CONTROLLERPATH + url,
            url: BASE + url,
            type: "POST",
            data: {
                id: $(this).val(),
                estado: state ? 1 : 0
            },
            error: function(error) {
                console.log(error);
                $("<div class='mensaje alert alert-danger'></div>").insertBefore("h1").text("Ha ocurrido un error").append('<button type="button" class="close" data-dismiss="alert">&times;</button>').show().delay(100).fadeOut(5000);

            },
            success: function(success) {
                console.log(success);

                $("<div class='mensaje alert alert-success'></div>").insertBefore("h1").text(success).append('<button type="button" class="close" data-dismiss="alert">&times;</button>').show().delay(100).fadeOut(5000);
            }
        });
    })
//    });

}
var normalize = (function() {
    var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
            to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
            mapping = {};

    for (var i = 0, j = from.length; i < j; i++)
        mapping[ from.charAt(i) ] = to.charAt(i);

    return function(str) {
        var ret = [];
        for (var i = 0, j = str.length; i < j; i++) {
            var c = str.charAt(i);
            if (mapping.hasOwnProperty(str.charAt(i)))
                ret.push(mapping[ c ]);
            else
                ret.push(c);
        }
        return ret.join('');
    }

})();

function setTimedMessage(type, text) {
    $(".timed-msg").addClass(type).text(text).show();
    setTimeout(function() {
        $(".timed-msg").hide()
    }, 5000);
}
NProgress.start();
