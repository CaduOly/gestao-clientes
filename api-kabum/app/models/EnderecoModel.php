<?php
class EnderecoModel implements JsonSerializable
{
    private $id_endereco;
    private $cep;
    private $numero;
    private $logradouro;
    private $complemento;
    private $bairro;
    private $localidade;
    private $uf;
    private $id_cliente;

    public function __construct($cep, $numero, $logradouro, $complemento, $bairro, $localidade, $uf, $id_cliente)
    {

        $this->cep = $cep;
        $this->numero = $numero;
        $this->logradouro = $logradouro;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->localidade = $localidade;
        $this->uf = $uf;
        $this->id_cliente = $id_cliente;
    }

    public function getId()
    {
        return $this->id_endereco;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function getLocalidade()
    {
        return $this->localidade;
    }

    public function getUf()
    {
        return $this->uf;
    }

    public function getClienteId()
    {
        return $this->id_cliente;
    }

    public function setId($id_endereco)
    {
        $this->id_endereco = $id_endereco;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function setLocalidade($localidade)
    {
        $this->localidade = $localidade;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    public function setClienteId($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }
    public function jsonSerialize()
    {
        // Retorne um array associativo com os dados do endereço que devem ser codificados em JSON
        return [
            'id' => $this->id_endereco,
            'cep' => $this->cep,
            'numero' => $this->numero,
            'logradouro' => $this->logradouro,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'localidade' => $this->localidade,
            'uf' => $this->uf,
            'id_cliente' => $this->id_cliente
        ];
    }
}
