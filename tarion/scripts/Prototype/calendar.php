<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Календарь</title>
	<meta name="robots" content="noindex,nofollow" />
</head>
<body>
<style>
/* general tags */
html {
    font-size: 82%;
}

input, select, textarea {
    font-size: 1em;
}

body {
    font-family:        sans-serif;
    padding:            0;
    margin:             0.5em;
    color:              #000000;
    background:         #F5F5F5;
}

textarea, tt, pre, code {
    font-family:        monospace;
}
h1 {
    font-size:          140%;
    font-weight:        bold;
}

h2 {
    font-size:          120%;
    font-weight:        bold;
}

h3 {
    font-weight:        bold;
}

a:link,
a:visited,
a:active {
    text-decoration:    none;
    color:              #0000FF;
}

a:hover {
    text-decoration:    underline;
    color:              #FF0000;
}

dfn {
    font-style:         normal;
}

dfn:hover {
    font-style:         normal;
    cursor:             help;
}

th {
    font-weight:        bold;
    color:              #000000;
    background:         #D3DCE3;
}

a img {
    border:             0;
}

hr {
    color:              #000000;
    background-color:   #000000;
    border:             0;
    height:             1px;
}

form {
    padding:            0;
    margin:             0;
    display:            inline;
}

textarea {
    overflow:           visible;
    height:             9em;
}

fieldset {
    margin-top:         1em;
    border:             #000000 solid 1px;
    padding:            0.5em;
    background:         #E5E5E5;
}

fieldset fieldset {
    margin:             0.8em;
}

fieldset legend {
    font-weight:        bold;
    color:              #444444;
    background-color:   transparent;
}

/* buttons in some browsers (eg. Konqueror) are block elements,
   this breaks design */
button {
    display:            inline;
}

table caption,
table th,
table td {
    padding:            0.1em 0.5em 0.1em 0.5em;
    margin:             0.1em;
    vertical-align:     top;
}

img,
input,
select,
button {
    vertical-align:     middle;
}
/* Calendar */
table.calendar {
    width:              100%;
}
table.calendar td {
    text-align:         center;
}
table.calendar td a {
    display:            block;
}

table.calendar td a:hover {
    background-color:   #CCFFCC;
}

table.calendar th {
    background-color:   #D3DCE3;
}

table.calendar td.selected {
    background-color:   #FFCC99;
}

img.calendar {
    border:             none;
}
form.clock {
    text-align:         center;
}
/* end Calendar */
</style>
<script src="tbl_change.js"></script>
<script>
var month_names = new Array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
var day_names = new Array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
var submit_text = " Время ";
</script>
</head>
<body onload="initCalendar();">
<div id="calendar_data"></div>
<div id="clock_data"></div>
</body>
</html>
