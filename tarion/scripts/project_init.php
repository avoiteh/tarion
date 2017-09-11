<?php
if(file_exists('tarion.project')){
	$project=unserialize(file_get_contents('tarion.project'));
}else{
	$project=array(
	"tables"=>array(),
	"front"=>array(),
	"back"=>array()
	);
	file_put_contents('tarion.project', serialize($project));
}
/*
tables = array("name", "fields"=>array("name","type","remark"))
type - int, string
front & back = array("name", "type", "content", "child"=>array(NODE))
type - menu, list, form, blank


back & front = array(
	...
	"4"=>array("parent"=>"3","type"="menu","name"=>"��� ��������","content"=>array(...���������� ������� �� ���� ��������...));
	...
);
���� ���������
"menu" (����� ����) - content ������, ����� ����� �������-�� �������� ���� "menu" ��� ���� ������� ���� CRUD
"CRUD" (���������+�������� ������) - content �������� ������ � ��������� ������� � ��, � ������� ������, � ������� ���������, � ���������� ������� � ������������. �������� ���� �� �����.
"TreeCRUD" (���������+�������� ������) - ���� �����, ��� � CRUD, �� ��� ����������� ����� ������

<html>
<head>
<title>Tarion</title>
<meta http-equiv=charset content="windows-1251">
</head>
<body>
<script>
var tables=<?php echo(json_encode($project['tables']));?>;
var front=<?php echo(json_encode($project['front']));?>;
var back=<?php echo(json_encode($project['back']));?>;
</script>
</body>
</html>

*/
function objectToArray( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( 'objectToArray', $object );
    }
function makeDir($path){
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
}
?>
