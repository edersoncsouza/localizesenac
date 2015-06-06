<?php

//var $entidades = array('aluno', 'area_ensino', 'categoria', 'curso', 'disciplina', 'evento_aluno', 'evento_geral', 'nivel_ensino', 'sala', 'unidade');

if ($_GET) {
	require_once('../classes/CMySQL.php');

	switch ($_GET['entidade']) {

            case 'Alunos':
                $aColumns = array( 'matricula', 'senha', 'nome', 'celular', 'email', 'ativo' );
				$entidade = 'aluno';
                break;
			case 'Areas':
				$aColumns = array('descricao','nivel');
				$entidade = 'area_ensino';
				break;
			case 'Categorias':
				$aColumns = array('nome','imagem');
				$entidade = 'categoria';
				break;
			case 'Coordenadas':
				$aColumns = array('unidade','andar', 'numero','longitude', 'latitude');
				$entidade = 'coordenadas';
				break;	
			case 'Cursos':
				$aColumns = array('descricao','area','nivel');
				$entidade = 'curso';
				break;
			case 'Disciplinas':
				$aColumns = array( 'nome', 'creditos');
				$entidade = 'disciplina';
				break;
			case 'Eventos':
				$aColumns = array('descricao', 'dia_semana', 'dt_final','dt_inicio','andar','aluno','numero_sala','unidade');
				$entidade = 'evento_aluno';
				break;
			case 'EventosAcademicos':
				$aColumns = array('data_inicio','hora_inicio' ,'data_final','hora_final','descricao','local_evento');
				$entidade = 'evento_geral';
				break;
			case 'Niveis':
				$aColumns = array('descricao');
				$entidade = 'nivel_ensino';
				break;
			case 'Salas':
				$aColumns = array('unidade', 'andar', 'numero', 'categoria');
				$entidade = 'sala';
				break;
			case 'Unidades':
				$aColumns = array('nome', 'endereco');
				$entidade = 'unidade';
				break;

	}
	
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

	global $aColumns;
	global $entidade; // utiliza o escopo global das variaveis

	
    // SQL limit
    $sLimit = '';
    if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
        $sLimit = 'LIMIT ' . (int)$_GET['iDisplayStart'] . ', ' . (int)$_GET['iDisplayLength'];
    }

    // SQL order
	//$aColumns = array( 'NR_MATRICULA', 'SENHA', 'NM_ALUNO', 'NR_CELULAR', 'EMAIL', 'ACTIVO', 'SESSAO' );
	//$aColumns = array( 'matricula', 'senha', 'nome', 'celular', 'email', 'ativo' );
    $sOrder = '';
	
	/* TENTATIVA DE DESCOBRIR PQ TABELAS SEM COLUNAS VARCHAR NÃO FUNCIONAM COM SORTING AUTOMATIZADO PELO PROCEDIMENTO */
	/*
    if (isset($_GET['iSortCol_0'])) {
        $sOrder = 'ORDER BY  ';
		
		if (isset($_GET['iSortingCols'])) {
			for ($i=0 ; $i<(int)$_GET['iSortingCols'] ; $i++) {
				
				if (isset($_GET[ $_GET[ 'bSortable_'.(int)$_GET['iSortCol_'.$i] ])) {
					if ( $_GET[ 'bSortable_'.(int)$_GET['iSortCol_'.$i] ] == 'true' ) {
						
						if (isset($_GET['sSortDir_'.$i])) {
							
							$sOrder .= '`'.$aColumns[ (int)$_GET['iSortCol_'.$i] ].'` '.
								($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .', ';
						}
					}
				}
				
			}

			//$sOrder = substr_replace($sOrder, '', -2);
			if ($sOrder == 'ORDER BY') {
				$sOrder = '';
			}
		}
    }
	*/
	
	/* ORDER ORIGINAL */
	/*
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
	*/
	
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
	
    //$aMembers = $GLOBALS['MySQL']->getAll("SELECT * FROM `aluno` {$sWhere} {$sOrder} {$sLimit}");
	$aMembers = $GLOBALS['MySQL']->getAll("SELECT * FROM {$entidade} {$sWhere} {$sOrder} {$sLimit}");
    //$iCnt = (int)$GLOBALS['MySQL']->getOne("SELECT COUNT(`id`) AS 'Cnt' FROM `aluno` WHERE 1");
	$iCnt = (int)$GLOBALS['MySQL']->getOne("SELECT COUNT(`id`) AS 'Cnt' FROM {$entidade} WHERE 1");

	// Saida dos totalizadores de registros
    $output = array(
        'sEcho' => intval($_GET['sEcho']),
        'iTotalRecords' => count($aMembers),
        'iTotalDisplayRecords' => $iCnt,
        'aaData' => array()
    );
	
	// Saida do preenchimento da tabela
    foreach ($aMembers as $iID => $aInfo) {
        /*
		$aItem = array(
			$aInfo['matricula'], $aInfo['senha'], $aInfo['nome'], $aInfo['celular'], $aInfo['email'], $aInfo['ativo'], 'DT_RowId' => $aInfo['id']
        );
		*/
		$aItem = array();
		
		switch ($entidade) {
		
            case 'aluno':
                $aItem = array( $aInfo['matricula'], $aInfo['senha'], $aInfo['nome'], $aInfo['celular'], $aInfo['email'], $aInfo['ativo'], 'DT_RowId' => $aInfo['id'] );
                break;
			case 'area_ensino':
				$aItem = array( $aInfo['descricao'], $aInfo['fk_id_nivel'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'categoria':
				$aItem = array( $aInfo['nome'], $aInfo['parametro_imagem'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'coordenadas':
				$aItem = array( $aInfo['fk_sala_fk_id_unidade'], $aInfo['fk_andar_sala'], $aInfo['fk_numero_sala'], $aInfo['longitude'], $aInfo['latitude'], 'DT_RowId' => $aInfo['id'] );
			case 'curso':
				$aItem = array( $aInfo['descricao'], $aInfo['fk_id_area_ensino'], $aInfo['fk_id_nivel_ensino'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'disciplina':
				$aItem = array( $aInfo['nome'], $aInfo['creditos'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'evento_aluno':
				$aItem = array( $aInfo['descricao'], $aInfo['dia_semana'], $aInfo['dt_final'], $aInfo['dt_inicio'], $aInfo['andar'], $aInfo['aluno'], $aInfo['numero_sala'], $aInfo['unidade'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'evento_geral':
				$aItem = array( $aInfo['data_inicio'], $aInfo['hora_inicio'], $aInfo['data_final'], $aInfo['hora_final'], $aInfo['descricao'], $aInfo['local_evento'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'nivel_ensino':
				$aItem = array( $aInfo['descricao'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'sala':
				$aItem = array( $aInfo['fk_id_unidade'], $aInfo['andar'], $aInfo['numero'], $aInfo['fk_id_categoria'], 'DT_RowId' => $aInfo['id'] );
				break;
			case 'unidade':
				$aItem = array( $aInfo['nome'], $aInfo['endereco'], 'DT_RowId' => $aInfo['id'] );			
				break;

		}
		
		$output['aaData'][] = $aItem;
    }
    echo json_encode($output);
}

/*
 * updateMemberAjx: esta funcao faz o update das informações para todas as tabelas
 *					aqui todos os campos de todas as entidades estao misturados
 *					podem acontecer problemas se houveram campos com nomes iguais
 *					em entidades diferentes e com tipos diferentes
 */

function updateMemberAjx() {
    $sVal = $GLOBALS['MySQL']->escape($_POST['value']);
	global $entidade;

	// campos da tabela evento_geral: 'data_inicio','hora_inicio' ,'data_final','hora_final','descricao','local_evento'
	
    $iId = (int)$_POST['id'];
    if ($iId && $sVal !== FALSE) {
        switch ($_POST['columnName']) {
            case 'MATRICULA':
                $GLOBALS['MySQL']->res("UPDATE {$entidade} SET `matricula`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'SENHA':
                $GLOBALS['MySQL']->res("UPDATE {$entidade} SET `senha`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'NOME':
                $GLOBALS['MySQL']->res("UPDATE {$entidade} SET `nome`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'CELULAR':
                $GLOBALS['MySQL']->res("UPDATE {$entidade} SET `celular`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'EMAIL':
                $GLOBALS['MySQL']->res("UPDATE {$entidade} SET `email`='{$sVal}' WHERE `id`='{$iId}'");
                break;
            case 'ATIVO':
                $GLOBALS['MySQL']->res("UPDATE {$entidade} SET `ativo`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'CREDITOS':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `creditos`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'DESCRICAO':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `descricao`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'DATA DE INICIO':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `data_inicio`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'HORA DE INICIO':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `hora_inicio`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'DATA FINAL':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `data_final`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'HORA FINAL':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `hora_final`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'DESCRICAO EVENTO':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `descricao`='{$sVal}' WHERE `id`='{$iId}'");
                break;
			case 'LOCAL EVENTO':
				$GLOBALS['MySQL']->res("UPDATE {$entidade} SET `local_evento`='{$sVal}' WHERE `id`='{$iId}'");
                break;
        }
        echo 'Salvo com sucesso';
    }
    exit;
}

function addMemberAjx() {

/*
	global $aColumns;
	global $entidade; // utiliza o escopo global das variaveis	

 $matricula = $GLOBALS['MySQL']->escape($_POST["matricula"]);
 $senha = $GLOBALS['MySQL']->escape($_POST["senha"]);
 $nome = $GLOBALS['MySQL']->escape($_POST["nome"]);
 $celular = $GLOBALS['MySQL']->escape($_POST["celular"]);
 $email = $GLOBALS['MySQL']->escape($_POST["email"]);
 $status = $GLOBALS['MySQL']->escape($_POST["status"]);
 
		$GLOBALS['MySQL']->res("INSERT INTO `aluno`(`id` ,`matricula` ,`senha` ,`nome` ,`celular` ,`email` ,`ativo`) VALUES (NULL ,  '{$matricula}', '{$senha}', '{$nome}', '{$celular}', '{$email}', '{$status}')");
		echo 'Salvo com sucesso';
exit;
	*/

	global $aColumns;
	global $entidade; // utiliza o escopo global das variaveis	
		
	foreach(array_keys($_POST) as $key){$postLimpo[$key] = mysql_real_escape_string($_POST[$key]);} // limpa as entradas de $_POST
	
	// monta a string de insercao
	$sql = "insert into ".$entidade."(`";
	$sql .= implode("`,`",$aColumns);
	$sql .= "`) values('";
	$sql .= implode("','",$postLimpo);
	$sql .= "')";

	$GLOBALS['MySQL']->res($sql); // executa o metodo de query
	echo 'Salvo com sucesso';
	
    exit;
}

function deleteMember() {
	
	global $entidade; // utiliza o escopo global das variaveis	
		
    $iId = (int)$_POST['id'];
    if ($iId) {
        //$GLOBALS['MySQL']->res("DELETE FROM `aluno` WHERE `id`='{$iId}'");
		$GLOBALS['MySQL']->res("DELETE FROM `{$entidade}` WHERE `id`='{$iId}'");
        return;
    }
    echo 'Error';exit;
}
?>