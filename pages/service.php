<?php
if ($_GET) {
    require_once('../dist/classes/CMySQL.php');
    switch ($_GET['action']) {
        case 'getMembersAjx':
            getMembersAjx();
            break;
        case 'updateMemberAjx':
            updateMemberAjx();
            break;
        case 'deleteMember':
            deleteMember();
            break;
		case 'addMemberAjx':
			addMemberAjx();
        break;
    }
    exit;
}

function getMembersAjx() {

    // SQL limit
    $sLimit = '';
    if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
        $sLimit = 'LIMIT ' . (int)$_GET['iDisplayStart'] . ', ' . (int)$_GET['iDisplayLength'];
    }

    // SQL order
    //$aColumns = array('first_name', 'last_name', 'email', 'status', 'role', 'date_reg');
	$aColumns = array( 'NR_MATRICULA', 'SENHA', 'NM_ALUNO', 'NR_CELULAR', 'EMAIL', 'ACTIVO', 'SESSAO' );
    $sOrder = '';
    if (isset($_GET['iSortCol_0'])) {
        $sOrder = 'ORDER BY  ';
        for ($i=0 ; $i<(int)$_GET['iSortingCols'] ; $i++) {
            if ( $_GET[ 'bSortable_'.(int)$_GET['iSortCol_'.$i] ] == 'true' ) {
                $sOrder .= '`'.$aColumns[ (int)$_GET['iSortCol_'.$i] ].'` '.
                    ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .', ';
            }
        }

        $sOrder = substr_replace($sOrder, '', -2);
        if ($sOrder == 'ORDER BY') {
            $sOrder = '';
        }
    }

    // SQL where
    $sWhere = 'WHERE 1';
    if (isset($_GET['sSearch']) && $_GET['sSearch'] != '') {
        $sWhere = 'WHERE 1 AND (';
        for ($i=0; $i<count($aColumns) ; $i++) {
            if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == 'true') {
                $sWhere .= '`' . $aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch'])."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, '', -3 );
        $sWhere .= ')';
    }

    $aMembers = $GLOBALS['MySQL']->getAll("SELECT * FROM `aluno` {$sWhere} {$sOrder} {$sLimit}");
    $iCnt = (int)$GLOBALS['MySQL']->getOne("SELECT COUNT(`id`) AS 'Cnt' FROM `aluno` WHERE 1");

    $output = array(
        'sEcho' => intval($_GET['sEcho']),
        'iTotalRecords' => count($aMembers),
        'iTotalDisplayRecords' => $iCnt,
        'aaData' => array()
    );
    foreach ($aMembers as $iID => $aInfo) {
        $aItem = array(
            $aInfo['NR_MATRICULA'], $aInfo['SENHA'], $aInfo['NM_ALUNO'], $aInfo['NR_CELULAR'], $aInfo['EMAIL'], $aInfo['ACTIVO'], $aInfo['SESSAO'], 'DT_RowId' => $aInfo['id']
        );
        $output['aaData'][] = $aItem;
    }
    echo json_encode($output);
}
function updateMemberAjx() {
    $sVal = $GLOBALS['MySQL']->escape($_POST['value']);

    $iId = (int)$_POST['id'];
    if ($iId && $sVal !== FALSE) {
        switch ($_POST['columnName']) {
            case 'MATRICULA':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `NR_MATRICULA`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'SENHA':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `senha`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'NOME':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `nm_aluno`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'CELULAR':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `nr_celular`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'EMAIL':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `email`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'ATIVO':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `activo`='{$sVal}' WHERE `id`='{$iId}'");
                break;
        }
        echo 'Successfully saved';
    }
    exit;
}

function addMemberAjx() {

    //$sVal = $GLOBALS['MySQL']->escape($_POST['value']);
define( 'DB_FULL_DEBUG_MODE', true );
 $matricula = $GLOBALS['MySQL']->escape($_POST["matricula"]);
 $senha = $_POST["senha"];
 $nome = $_POST["nome"];
 $celular = $_POST["celular"];
 $email = $_POST["email"];
 $status = $_POST["status"];
 
		$GLOBALS['MySQL']->res("INSERT INTO `aluno`(`id` ,`NR_MATRICULA` ,`SENHA` ,`NM_ALUNO` ,`NR_CELULAR` ,`EMAIL` ,`ACTIVO` ,`SESSAO`) VALUES (NULL ,  '{$matricula}', '{$senha}', '{$nome}', '{$celular}', '{$email}', '{$status}', '')");
		//	mysql_query("INSERT INTO `u430563209_local`.`aluno` (`id`, `NR_MATRICULA`, `SENHA`, `NM_ALUNO`, `NR_CELULAR`, `EMAIL`, `ACTIVO`, `SESSAO`) VALUES (NULL, '34533453', 'qaz123', 'zezao', '4564', 'fwer', 'S', '')");
        //INSERT INTO `aluno`(`id`, `NR_MATRICULA`, `SENHA`, `NM_ALUNO`, `NR_CELULAR`, `EMAIL`, `ACTIVO`, `SESSAO`) VALUES ();
		echo 'Successfully saved';

    exit;
}

function deleteMember() {
    $iId = (int)$_POST['id'];
    if ($iId) {
        $GLOBALS['MySQL']->res("DELETE FROM `aluno` WHERE `id`='{$iId}'");
        return;
    }
    echo 'Error';exit;
}
?>