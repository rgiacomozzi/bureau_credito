<?php
/**
 * Pessoa Controller
 */
class PessoaController
{
	private $PDO;

	public function __construct()
	{
		$this->PDO = new \PDO('mysql:host=localhost;dbname=bureau_credito', 'root', 'robsonrg');
		$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
	}

	public function lista()
	{
		return ['lista_pessoas'];
	}

	/** 
	 * Retorna dados da pessoa
	*/
	public function get($cpf) 
	{
		$sth = $this->PDO->prepare("SELECT * FROM pessoa WHERE cpf = :cpf");
		$sth->bindValue(':cpf', $cpf);
		$sth->execute();
		$result = $sth->fetch(\PDO::FETCH_ASSOC);

		return $result;
	}
}
