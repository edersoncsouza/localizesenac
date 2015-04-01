<?php

var $entidades = array('aluno', 'area_ensino', 'categoria', 'curso', 'disciplina', 'evento_aluno', 'nivel_ensino', 'sala', 'unidade');

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
	//$aColumns = array( 'NR_MATRICULA', 'SENHA', 'NM_ALUNO', 'NR_CELULAR', 'EMAIL', 'ACTIVO', 'SESSAO' );
	$aColumns = array( 'matricula', 'senha', 'nome', 'celular', 'email', 'ativo' );
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
            $aInfo['matricula'], $aInfo['senha'], $aInfo['nome'], $aInfo['celular'], $aInfo['email'], $aInfo['ativo'], 'DT_RowId' => $aInfo['id']
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
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `matricula`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'SENHA':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `senha`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'NOME':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `nome`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'CELULAR':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `celular`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'EMAIL':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `email`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'ATIVO':
                $GLOBALS['MySQL']->res("UPDATE `aluno` SET `ativo`='{$sVal}' WHERE `id`='{$iId}'");
                break;
        }
        echo 'Salvo com sucesso';
    }
    exit;
}

function addMemberAjx() {

 $matricula = $GLOBALS['MySQL']->escape($_POST["matricula"]);
 $senha = $GLOBALS['MySQL']->escape($_POST["senha"]);
 $nome = $GLOBALS['MySQL']->escape($_POST["nome"]);
 $celular = $GLOBALS['MySQL']->escape($_POST["celular"]);
 $email = $GLOBALS['MySQL']->escape($_POST["email"]);
 $status = $GLOBALS['MySQL']->escape($_POST["status"]);
 
		$GLOBALS['MySQL']->res("INSERT INTO `aluno`(`id` ,`matricula` ,`senha` ,`nome` ,`celular` ,`email` ,`ativo`) VALUES (NULL ,  '{$matricula}', '{$senha}', '{$nome}', '{$celular}', '{$email}', '{$status}')");
		echo 'Salvo com sucesso';

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