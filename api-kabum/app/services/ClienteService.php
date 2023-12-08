<?php
require_once __DIR__ . '/../repositories/ClienteRepository.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteService
{
    private $repository;

    public function __construct(ClienteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllClientes()
    {
        $clientesData = $this->repository->getAllClientes();
        $clientes = [];

        foreach ($clientesData as $row) {
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

            if (!isset($clientes[$clienteId])) {
                $clientes[$clienteId] = new Cliente(
                    $row['nome'],
                    $row['cpf'],
                    $row['rg'],
                    $row['data_nascimento'],
                    $row['telefone'],
                    []
                );
                $clientes[$clienteId]->setId($clienteId);
            }

            if ($endereco) {
                $clientes[$clienteId]->setEndereco($endereco);
            }
        }

        return array_values($clientes);
    }


    public function getClienteById($id)
    {
        $clienteData = $this->repository->getClienteById($id);

        if (!$clienteData) {
            return null;
        }

        $enderecos = isset($clienteData['enderecos']) ? $clienteData['enderecos'] : [];
        $cliente = new Cliente($clienteData['nome'], $clienteData['cpf'], $clienteData['rg'], $clienteData['data_nascimento'], $clienteData['telefone'], $enderecos);
        $cliente->setId($clienteData['id_cliente']);

        if (!empty($clienteData['cep']) && !empty($clienteData['numero']) && !empty($clienteData['logradouro']) && !empty($clienteData['bairro']) && !empty($clienteData['localidade']) && !empty($clienteData['uf'])) {
            $endereco = new Endereco($clienteData['cep'], $clienteData['numero'], $clienteData['logradouro'], $clienteData['complemento'], $clienteData['bairro'], $clienteData['localidade'], $clienteData['uf'], $clienteData['id_cliente']);
            $endereco->setId($clienteData['id_endereco']);
            $cliente->setEndereco($endereco);
        }

        return $cliente;
    }


    public function addCliente($data)
    {
        $cliente = new Cliente($data['nome'], $data['cpf'], $data['rg'], $data['data_nascimento'], $data['telefone'], $data['enderecos']);
        $clienteId = $this->repository->addCliente($cliente);
        $cliente->setId($clienteId);

        if (!empty($data['enderecos'])) {
            foreach ($data['enderecos'] as $enderecoData) {
                if (is_array($enderecoData)) {
                    $endereco = new Endereco(
                        $enderecoData['cep'],
                        $enderecoData['numero'],
                        $enderecoData['logradouro'],
                        $enderecoData['complemento'],
                        $enderecoData['bairro'],
                        $enderecoData['localidade'],
                        $enderecoData['uf'],
                        $cliente->getId()
                    );
                    $this->repository->insertEndereco($endereco, $clienteId);
                }
            }
        }
    }



    public function updateCliente($id, $data)
    {
        $cliente = new Cliente($data['nome'], $data['cpf'], $data['rg'], $data['data_nascimento'], $data['telefone'], $data['enderecos']);


        $this->repository->updateCliente($id, $cliente);
        $this->repository->removeEndereco($id);

        foreach ($data['enderecos'] as $enderecoData) {
            $endereco = new Endereco(
                $enderecoData['cep'],
                $enderecoData['numero'],
                $enderecoData['logradouro'],
                $enderecoData['complemento'],
                $enderecoData['bairro'],
                $enderecoData['localidade'],
                $enderecoData['uf'],
                $enderecoData['id_cliente'],

            );
            $this->repository->insertEndereco($endereco);
        }



        $clienteAtualizado = $this->repository->getClienteById($id);
        return $clienteAtualizado;
    }

    public function removeCliente($id)
    {
        $this->repository->removeCliente($id);
    }
}
