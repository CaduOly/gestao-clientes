<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllClientes()
    {
        $stmt = $this->pdo->prepare("SELECT cliente.id_cliente, cliente.nome, cliente.cpf, cliente.rg, cliente.data_nascimento, cliente.telefone,
                                             endereco.id_endereco, endereco.cep, endereco.numero, endereco.logradouro, endereco.complemento, endereco.bairro, endereco.localidade, endereco.uf
                                      FROM cliente 
                                      LEFT JOIN endereco ON cliente.id_cliente = endereco.id_cliente");
        $stmt->execute();

        $clientesData = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clientesData[] = $row;
        }

        return $clientesData;
    }

    public function getClienteById($id)
    {
        $stmt = $this->pdo->prepare("SELECT cliente.id_cliente, cliente.nome, cliente.cpf, cliente.rg, cliente.data_nascimento, cliente.telefone,
                                             endereco.id_endereco, endereco.cep, endereco.numero, endereco.logradouro, endereco.complemento, endereco.bairro, endereco.localidade, endereco.uf
                                      FROM cliente 
                                      LEFT JOIN endereco ON cliente.id_cliente = endereco.id_cliente
                                      WHERE cliente.id_cliente = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $clienteData = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clienteId = $row['id_cliente'];
            $endereco = null;

            if ($row['id_endereco']) {
                $endereco = new Endereco(
                    $row['cep'],
                    $row['numero'],
                    $row['logradouro'],
                    $row['complemento'],
                    $row['bairro'],
                    $row['localidade'],
                    $row['uf'],
                    $clienteId
                );
                $endereco->setId($row['id_endereco']);
            }

            if (!isset($clienteData['id_cliente'])) {
                $clienteData = [
                    'id_cliente' => $clienteId,
                    'nome' => $row['nome'],
                    'cpf' => $row['cpf'],
                    'rg' => $row['rg'],
                    'data_nascimento' => $row['data_nascimento'],
                    'telefone' => $row['telefone'],
                    'enderecos' => [],
                ];
            }

            if ($endereco) {
                $clienteData['enderecos'][] = $endereco;
            }
        }

        return $clienteData ?: null;
    }

    public function addCliente(Cliente $cliente)
    {
        $stmt = $this->pdo->prepare("INSERT INTO cliente (nome, cpf, rg, data_nascimento, telefone) 
                                     VALUES (:nome, :cpf, :rg, :data_nascimento, :telefone)");

        $stmt->bindValue(':nome', $cliente->getNome());
        $stmt->bindValue(':cpf', $cliente->getCpf());
        $stmt->bindValue(':rg', $cliente->getRg());
        $stmt->bindValue(':data_nascimento', $cliente->getDataNascimento());
        $stmt->bindValue(':telefone', $cliente->getTelefone());

        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function insertEndereco(Endereco $endereco)
    {
        $stmt = $this->pdo->prepare("INSERT INTO endereco (cep, numero, logradouro, complemento, bairro, localidade, uf, id_cliente) 
                                     VALUES (:cep, :numero, :logradouro, :complemento, :bairro, :localidade, :uf, :id_cliente)");

        $stmt->bindValue(':cep', $endereco->getCep());
        $stmt->bindValue(':numero', $endereco->getNumero());
        $stmt->bindValue(':logradouro', $endereco->getLogradouro());
        $stmt->bindValue(':complemento', $endereco->getComplemento());
        $stmt->bindValue(':bairro', $endereco->getBairro());
        $stmt->bindValue(':localidade', $endereco->getLocalidade());
        $stmt->bindValue(':uf', $endereco->getUf());
        $stmt->bindValue(':id_cliente', $endereco->getClienteId());

        $stmt->execute();
    }

    public function updateCliente($id, Cliente $cliente)
    {
        $stmt = $this->pdo->prepare("UPDATE cliente SET nome=:nome, cpf=:cpf, rg=:rg, data_nascimento=:data_nascimento, telefone=:telefone WHERE id_cliente = :id");
        $stmt->bindValue(':nome', $cliente->getNome());
        $stmt->bindValue(':cpf', $cliente->getCpf());
        $stmt->bindValue(':rg', $cliente->getRg());
        $stmt->bindValue(':data_nascimento', $cliente->getDataNascimento());
        $stmt->bindValue(':telefone', $cliente->getTelefone());
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function updateEndereco($id, Endereco $endereco)
    {
        $stmt = $this->pdo->prepare("UPDATE endereco SET cep=:cep, numero=:numero, logradouro=:logradouro, complemento=:complemento, bairro=:bairro, localidade=:localidade, uf=:uf WHERE id_endereco = :id");

        $stmt->bindValue(':cep', $endereco->getCep());
        $stmt->bindValue(':numero', $endereco->getNumero());
        $stmt->bindValue(':logradouro', $endereco->getLogradouro());
        $stmt->bindValue(':complemento', $endereco->getComplemento());
        $stmt->bindValue(':bairro', $endereco->getBairro());
        $stmt->bindValue(':localidade', $endereco->getLocalidade());
        $stmt->bindValue(':uf', $endereco->getUf());
        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }

    public function removeCliente($id)
    {
        $this->removeEndereco($id);
        $stmt = $this->pdo->prepare("DELETE FROM cliente WHERE id_cliente = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function removeEndereco($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM endereco WHERE id_cliente = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}
