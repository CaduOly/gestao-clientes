<?php
require_once __DIR__ . '/../services/ClienteService.php';

class ClienteController
{
    private $service;

    public function __construct(ClienteService $service)
    {
        $this->service = $service;
    }

    public function getAllClientes()
    {
        $clientes = $this->service->getAllClientes();
        header('Content-Type: application/json');
        echo json_encode($clientes);
    }

    public function addCliente($data)
    {
        // Verificar se todos os campos necessários estão presentes
        if (!isset($data['nome'], $data['cpf'], $data['rg'], $data['data_nascimento'], $data['telefone'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Dados do cliente incompletos']);
            return;
        }

        // Verificar se o cliente tem pelo menos um endereço
        if (empty($data['enderecos'])) {
            http_response_code(400);
            echo json_encode(['message' => 'O cliente deve ter pelo menos um endereço']);
            return;
        }

        // Verificar se todos os endereços têm todos os campos necessários
        foreach ($data['enderecos'] as $endereco) {
            if (!isset($endereco['cep'], $endereco['numero'], $endereco['logradouro'], $endereco['bairro'], $endereco['localidade'], $endereco['uf'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Dados do endereço incompletos']);
                return;
            }
        }

        // Se todas as verificações passarem, adicione o cliente
        $this->service->addCliente($data);
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Cliente adicionado com sucesso']);
    }


    public function getClienteById($id)
    {
        $cliente = $this->service->getClienteById($id);

        if ($cliente) {
            header('Content-Type: application/json');
            echo json_encode($cliente);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Cliente não encontrado']);
        }
    }

    public function updateCliente($id, $data)
    {
        $cliente = $this->service->updateCliente($id, $data);
        if ($cliente) {
            header('Content-Type: application/json');
            echo json_encode($cliente);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Cliente não encontrado']);
        }
    }

    public function removeCliente($id)
    {
        $this->service->removeCliente($id);
        http_response_code(204);
    }
}
