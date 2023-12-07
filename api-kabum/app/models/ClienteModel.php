<?php
require_once __DIR__ . '/EnderecoModel.php';
class ClienteModel implements JsonSerializable
{
    private $id_cliente;
    private $nome;
    private $cpf;
    private $rg;
    private $dataNascimento;
    private $telefone;
    private $enderecos = [];

    public function __construct($nome, $cpf, $rg, $dataNascimento, $telefone, $enderecos)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->enderecos = $enderecos;
    }

    public function getId()
    {
        return $this->id_cliente;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getEnderecos()
    {
        return $this->enderecos;
    }

    public function setEnderecos(array $enderecos)
    {
        $this->enderecos = $enderecos;
    }

    public function setEndereco(EnderecoModel $endereco)
    {
        $this->enderecos[] = $endereco;
    }

    public function setId($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id_cliente,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'data_nascimento' => $this->dataNascimento,
            'telefone' => $this->telefone,
            'enderecos' => $this->enderecos
        ];
    }
}
