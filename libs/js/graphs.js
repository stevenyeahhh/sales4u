google.load("visualization", "1", {packages: ["corechart"]});


function cargarChartPie(json, nombre, element) {
    if ($(".report").length == 0) {
    //    $("<a class='report' href='" + window.location.href + "/1'><img style='width:40px;height:40px' src='" + BASE + "/img/excel.png' ></a>").insertAfter("h1");
    }
    js = json;
    console.log(json)
    arr = [];
    for (el in json) {
        arr.push([json[el]["descripcion"], (json[el]["CNT"]) / 1]);
    }
    //////////////
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Conteo');
    data.addRows(arr);

    if(typeof options=="undefined"){
        var options={}
    }
    options.title = "nombre";

    console.log(options);
    var chart = new google.visualization.PieChart(document.getElementById(element));
    chart.draw(data, options);
}


function cargarBar1(json, nombre, element) {
    if ($(".report").length == 0) {
    //    $("<a class='report' href='" + window.location.href + "/1'><img style='width:40px;height:40px' src='" + BASE + "/img/excel.png' ></a>").insertAfter("h1");
    }
    js = json;
    console.log(json)
    arr = [];
    for (el in json) {
        arr.push([json[el]["descripcion"], (json[el]["CNT"]) / 1]);
    }
    //////////////
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Conteo');
    data.addRows(arr);

    if(typeof options=="undefined"){
        var options={}
    }
    options.title = "nombre";

    console.log(options);
    var chart = new google.visualization.ColumnChart(document.getElementById(element));
    chart.draw(data, options);
}

function cargarBar2(json, nombre, element) {
    if ($(".report").length == 0) {
    //    $("<a class='report' href='" + window.location.href + "/1'><img style='width:40px;height:40px' src='" + BASE + "/img/excel.png' ></a>").insertAfter("h1");
    }
    js = json;
    console.log(json)
    arr = [];
    for (el in json) {
        arr.push([json[el]["descripcion"], (json[el]["CNT"]) / 1]);
    }
    //////////////
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Numero de Votos');
    //data.addColumn('string', 'Cosas');
    data.addRows(arr);

    if(typeof options=="undefined"){
        var options={}
    }
    options.title = "nombre";

    console.log(options);
    var chart = new google.visualization.ColumnChart(document.getElementById(element));
    chart.draw(data, options);
}


