<?php

    require_once('CMySQL.php');

    $sVal = $GLOBALS['MySQL']->escape($_POST['value']);
	
    $iId = (int)$_POST['id'];
	
    if ($iId && $sVal !== FALSE) {
        switch ($_POST['columnName']) {
            case 'MATRICULA':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `NR_MATRICULA`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'last_name':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `last_name`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'email':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `email`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'status':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `status`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'role':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `role`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'date_reg':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `date_reg`='{$sVal}' WHERE `id`='{$iId}'");
                break;
        }
        echo 'Successfully saved';
    }
    exit;

	
?>

