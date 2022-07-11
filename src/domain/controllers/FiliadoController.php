<?php

namespace Jp\SindicatoTrainees\domain\controllers;

use DateTimeInterface;
use DateTimeImmutable;
use Jp\SindicatoTrainees\infra\dao\FiliadoPdoDao;
use Jp\SindicatoTrainees\infra\DBConnector;
use Jp\SindicatoTrainees\domain\controllers\Controller;
use Jp\SindicatoTrainees\domain\models\Filiado;

/**
 * @version 1.0.0 Versionamento inicial da classe
 */
class FiliadoController extends Controller
{
	/*
	* @since 1.0.0 Definição do versionamento da função
	*
	* Retorna a lista de usuários cadastrados no sistema
	*
	* Cria uma conexão com o BD e usa o DAO para consultar os usuários no sistema.
	*
	* @author Joao Paulo joaopaulo@moobitech.com.br
	*
	* @return array
	*/
	public function getFiliados(): array
	{
		$rPdo = DBConnector::createConnection();
		$rDao = new FiliadoPdoDao($rPdo);
		$loFiliados = $rDao->getAll();
		return $loFiliados;
	}

	public function getFiliadoById(int $id)
	{
		$rPdo = DBConnector::createConnection();
		$rDao = new FiliadoPdoDao($rPdo);
		$oFiliado = $rDao->findById($id);
		return $oFiliado;
	}

	public function editarFiliado(
        int $id,
        string $nome,
        string $telefone,
        string $celular,
        int $empresa,
        int $cargo,
        int $situacao
    ) {
		$rPdo = DBConnector::createConnection();
		$rDao = new FiliadoPdoDao($rPdo);
		$oFiliado = new Filiado(
			$id, $nome, '', '', new DateTimeImmutable(), 0, $telefone,
			$celular, new DateTimeImmutable(), $empresa, $cargo, $situacao
		);
		if ($rDao->update($oFiliado)) {
			return json_encode([
				'status' => 200,
				'status_text' => 'Filiado editado.'
			]);
		}
		return json_encode([
			'status' => 500,
			'status_text' => 'Ops, algo deu errado...'
		]);
	}

	public function criarFiliado(
		string $sNome,
		string $sCPF,
		string $sRG,
		DateTimeInterface $oDataNascimento,
		int $iIdade,
		string $sTelefone,
		string $sCelular,
		DateTimeInterface $oDataUltimaAtualizacao,
		int $iEmpresa,
		int $iCargo,
		int $iSituacao
	) {
		$rPdo = DBConnector::createConnection();
		$rDao = new FiliadoPdoDao($rPdo);
		if ($rDao->insert(
					new Filiado(null, $sNome, $sCPF, $sRG, $oDataNascimento,
						$iIdade, $sTelefone, $sCelular, $oDataUltimaAtualizacao,
						$iEmpresa, $iCargo, $iSituacao)
					)
			){
			return json_encode([
				'status' => 200,
				'status_text' => 'Filiado adicionado.'
			]);
		}
		return json_encode([
			'status' => 500,
			'status_text' => 'Ops, algo deu errado...'
		]);
	}

	public function deletarFiliado(int $id)
	{
		$rPdo = DBConnector::createConnection();
		$rDao = new FiliadoPdoDao($rPdo);
		if ($rDao->delete($id)) {
			return json_encode([
				'status' => 200,
				'status_text' => 'success'
			]);
		}
		return json_encode([
			'status' => 500,
			'status_text' => 'Ops, algo deu errado...'
		]);
	}
}