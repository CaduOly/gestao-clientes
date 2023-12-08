<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/controllers/ClienteController.php';

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertJson;

class ClienteTest extends TestCase
{
    private $clienteController;
    private $clienteServiceMock;
    private $clientesMockData;

    protected function setUp(): void
    {
        $this->clienteServiceMock = $this->createMock(ClienteService::class);
        $this->clienteController = new ClienteController($this->clienteServiceMock);
        $this->clientesMockData = [
            [
                "id" => 1,
                "nome" => "João Silva",
                "cpf" => "123.456.789-01",
                "rg" => "9876543",
                "data_nascimento" => "1980-01-15",
                "telefone" => "555-1234",
                "enderecos" => [
                    [
                        "id" => 1,
                        "cep" => "12345-678",
                        "logradouro" => "Rua Teste 1",
                        "numero" => "101",
                        "complemento" => "Apt 2",
                        "bairro" => "Bairro Teste",
                        "localidade" => "Cidade Teste",
                        "uf" => "DF",
                        "id_cliente" => "1"
                    ],
                ]
            ],
            [
                "id" => 2,
                "nome" => "Maria Oliveira",
                "cpf" => "987.654.321-09",
                "rg" => "1234567",
                "data_nascimento" => "1995-05-20",
                "telefone" => "555-5678",
                "enderecos" => [
                    [
                        "id" => 3,
                        "cep" => "54321-876",
                        "logradouro" => "Rua Teste 2",
                        "numero" => "202",
                        "complemento" => "Casa",
                        "bairro" => "Outro Bairro",
                        "localidade" => "Outra Cidade",
                        "uf" => "SP",
                        "id_cliente" => "2"
                    ],
                ]
            ],
        ];
    }

    public function testGetAllClientes()
    {
        //Arrange
        $this->clienteServiceMock->expects($this->once())
            ->method('getAllClientes')
            ->willReturn($this->clientesMockData);

        $clienteController = new ClienteController($this->clienteServiceMock);

        //Act
        ob_start();
        $clienteController->getAllClientes();
        $response = ob_get_clean();
        $decodedResponse = json_decode($response, true);

        //Assert
        $this->assertJson($response);
        $this->assertNotNull($decodedResponse);
        $this->assertCount(2, $decodedResponse);
    }

    public function testGetClienteByIdValido()
    {
        //arrange
        $this->clienteServiceMock->expects($this->once())
            ->method('getClienteById')
            ->willReturnCallback(function ($id) {
                foreach ($this->clientesMockData as $clienteData) {
                    if ($clienteData['id'] == $id) {
                        return $clienteData;
                    }
                }
                return null;
            });

        $clienteController = new ClienteController($this->clienteServiceMock);
        $id = 1;
        //Act
        ob_start();
        $clienteController->getClienteById($id);
        $response = ob_get_clean();

        $decodedResponse = json_decode($response, true);
        //Assert
        $this->assertArrayHasKey('id', $decodedResponse);
        $this->assertSame($id, $decodedResponse['id']);
        $this->assertJson($response);
        $this->assertNotNull($decodedResponse);
    }


    public function testAddClientEValido()
    {
        //Arrange
        $data = [
            'nome' => 'Cliente Teste',
            'cpf' => '12345678900',
            'rg' => '1234567',
            'data_nascimento' => '1990-01-01',
            'telefone' => '123456789',
            'enderecos' => [
                [
                    'cep' => '12345-678',
                    'logradouro' => 'Rua Teste',
                    'numero' => '123',
                    'complemento' => 'Apt 1',
                    'bairro' => 'Bairro Teste',
                    'localidade' => 'Cidade Teste',
                    'uf' => 'UF',
                    'id_cliente' => '1'
                ]
            ]
        ];
        //Act
        ob_start();
        $this->clienteController->addCliente($data);
        $response = ob_get_clean();

        $expectedResponse = json_encode(["message" => "Cliente adicionado com sucesso"]);
        $decodedResponse = json_decode($response, true);

        //Assert
        $this->assertNotNull($decodedResponse);
        $this->assertArrayHasKey('message', $decodedResponse);
        $this->assertEquals('Cliente adicionado com sucesso', $decodedResponse['message']);
    }

    public function testUpdateCliente()
    {
        //Arrange
        $id = 1;
        $data = new Cliente(
            $id,
            'Cliente Teste editado',
            '77036386432',
            '1234567',
            '1990-01-01',
            '123456789',
            [
                new Endereco(
                    1,
                    'Rua editada',
                    '123',
                    'Apt 1',
                    'Bairro Teste',
                    'Cidade Teste',
                    'UF',
                    1
                )
            ]
        );


        $this->clienteServiceMock->expects($this->once())
            ->method('updateCliente')
            ->with($id, $data)
            ->willReturn($data);

        //Act
        ob_start();

        $this->clienteController->updateCliente($id, $data);

        $response = ob_get_clean();
        $expectedResponse = json_encode($data);

        //Assert
        $this->assertJson($response);
        $this->assertSame($expectedResponse, $response);
    }

    public function testRemoveCliente()
    {
        //Arrange
        $id = 1;

        $this->clienteServiceMock->expects($this->once())
            ->method('removeCliente')
            ->with($id);
        //Act
        $this->expectOutputString('');
        http_response_code(204);

        $this->clienteController->removeCliente($id);
        //Assert
        $this->assertEmpty(ob_get_contents());
        $this->assertEquals(204, http_response_code());
    }
}
