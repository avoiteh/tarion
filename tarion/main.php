<?php
session_start();
//require('connect_db.php');
/*
function json_encode($content, $assoc=false){
                require_once 'JSON.php';
                if ( $assoc ){
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
                    $json = new Services_JSON;
                }
        return $json->encode($content);
}
*/
?>
<html>
<script type="text/javascript" src="js/components/setouterhtml.js"></script>
<script type="text/javascript" src="js/components/tdbtables.js"></script>
<script type="text/javascript" src="js/components/edit_menu.js"></script>
<script type="text/javascript" src="js/components/edit_crud.js"></script>
<script type="text/javascript" src="js/components/edit_treecrud.js"></script>
<script type="text/javascript" src="js/field_data.js"></script>
<script type="text/javascript" src="js/field_float.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/panel.js"></script>
<script type="text/javascript" src="js/panel_tables.js"></script>
<script type="text/javascript" src="js/panel_bo.js"></script>
<script type="text/javascript" src="js/panel_fo.js"></script>
<script type="text/javascript" src="js/panel_translate.js"></script>
<script type="text/javascript" src="js/panel_about.js"></script>
<script type="text/javascript" src="js/escape.js"></script>

<script type="text/javascript" src="js/components/dataload.js"></script>
<script type="text/javascript" src="js/components/oneannot.js"></script>
<script type="text/javascript" src="js/components/annotfilter.js"></script>
<script type="text/javascript" src="js/components/ttable.js"></script>
<script type="text/javascript" src="js/model_mainmenu.js"></script>
<script type="text/javascript" src="js/components/upload_image.js"></script>


<title>Tarion CMS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onmousedown="main.onmousedown();" onmousemove="main.onmousemove(event);" onmouseup="main.onmouseup();">
<link rel="stylesheet" href="grid.css" type="text/css"/>
<div id="Hmain">bgtyyi</div>
<iframe style="position:absolute;left:0;top:0;display:none;" name="upload_iframe"></iframe>
<!--
<form style="position:absolute;left:0;top:0;display:none;" id="mainAJAXform" name="mainAJAXform" action="ajax_test.php" method="post" target="upload_iframe"><input type="hidden" name="query" id="main_ajax_query"></form>
-->
<div id="debug" style="position:absolute;left:0;top:300;z-index:500; background-color:#00ff00; width:400;height:500; overflow:scroll; display:none;">###</div>
<img id="ajax_clock" src="images/ajax-loader.gif" style="position:absolute;left:0px;top:0px;display:none;">
<script>
var deb=document.getElementById('debug');
//при инициализации контекст всегда должен носить имя main
//здесь держим мегаГлобальную переменную "AJAX-запроса", увы только так :( внутре класса не получается
var gloAJAXreq=null;
//HTML-контейнер, всегда id=Hmain
var main = new TContext('main', 'Hmain');
//инициализирующая отрисовка
main.Paint();

//таблицы БД
var panelTables = new TPanelTables('panelTables', 'hpanelTables', main);
panelTables.SendQuest();
main.elements[main.elements.length]=panelTables;
//Back Office
var panelBO = new TPanelBO('panelBO', 'hpanelBO', main);
panelBO.SendQuest();
main.elements[main.elements.length]=panelBO;
//Front Office
var panelFO = new TPanelFO('panelFO', 'hpanelFO', main);
panelFO.SendQuest();
main.elements[main.elements.length]=panelFO;
//Транслятор
var panelTranslate = new TPanelTranslate('panelTranslate', 'hpanelTranslate', main);
main.elements[main.elements.length]=panelTranslate;
//о программе
var panelAbout = new TPanelAbout('panelAbout', 'hpanelAbout', main);
main.elements[main.elements.length]=panelAbout;

//рабочая отрисовка
main.Paint();
//mapView.SendQuest();
</script>
</body>
</html>