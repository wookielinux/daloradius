<?php

include('../../library/checklogin.php');
include('pages_common.php');

/*
 * delGroups removes an instance of a select box item for a group
 */
if(isset($_GET['delGroups'])) {

	if (isset($_GET['divContainer']))
		$divContainer = $_GET['divContainer'];

	if (isset($_GET['divCounter']))
		$divCounter = $_GET['divCounter'];


        printqn("
                var divContainer = document.getElementById('$divContainer');
		var childGroup = document.getElementById('divContainerGroups$divCounter');
		divContainer.removeChild(childGroup);
	");
}



/*
 * getGroups creates a new select item for adding groups along with a Del link to delete
 * the added item
 */
if(isset($_GET['getGroups'])) {

	if (isset($_GET['divContainer']))
		$divContainer = $_GET['divContainer'];

	if (isset($_GET['divCounter']))
		$divCounter = $_GET['divCounter'];


	include '../../library/opendb.php';

        $sql = "(SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].")".
                        "UNION (SELECT distinct(GroupName) FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].");";
        $res = $dbSocket->query($sql);


	printqn("
		var divContainer = document.getElementById('$divContainer');
		var groups = ''+
	                '<label for=\'group\' class=\'form\'>Group</label>'+
	                '        <select class=\'form\' name=\'groups[]\' >'+
	");
			

        while($row = $res->fetchRow()) {

		printqn("
	        	'<option value=\'$row[0]\'>$row[0]</option>'+
		");

	}

        printqn("
	        '        </select>'+
                '&nbsp; <a class=\"tablenovisit\" href=\"#\"'+
                '        onClick=\"javascript:ajaxGeneric(\'include/management/dynamic_groups.php\',\'delGroups\',\'divContainerGroups\',\'divCounter=$divCounter\');\">Del</a>';

		var childGroup = document.createElement('div');
		childGroup.setAttribute('id','divContainerGroups$divCounter');
		childGroup.innerHTML = groups;
		divContainer.appendChild(childGroup);
	");
	


	include '../../library/closedb.php';

}


?>