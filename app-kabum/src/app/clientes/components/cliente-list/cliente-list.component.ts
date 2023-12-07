import { Component, OnInit } from '@angular/core';
import { ConfirmationService, MessageService } from 'primeng/api';
import { Cliente } from '../../models/cliente';
import { ClienteService } from '../../service/cliente.service';
import { Table } from 'primeng/table';

@Component({
  selector: 'app-cliente-list',
  templateUrl: './cliente-list.component.html',
  styleUrls: ['./cliente-list.component.css'],
  providers: [MessageService, ConfirmationService],
})
export class ClienteListComponent implements OnInit {
  title = 'Clientes';

  clientes: Cliente[] = [];

  loading = true;
  totaldeRegistros = 0;

  constructor(
    private messageService: MessageService,
    private clienteService: ClienteService,
    private confirmationService: ConfirmationService
  ) {}
  ngOnInit(): void {
    this.loading = false;
    this.getClientes();
  }

  getClientes() {
    this.clienteService.getAllClientes().subscribe((response) => {
      this.clientes = [...response];

      this.totaldeRegistros = response.length;
    });
  }

  show() {
    this.messageService.add({
      severity: 'success',
      summary: 'Success',
      detail: 'Message Content',
    });
  }
  editarCliente(id: number): void {}

  deletarCliente(id: number): void {
    this.confirmationService.confirm({
      message: 'Deseja realmente DELETAR esse cliente?',
      header: 'DELETAR',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {
        this.clienteService.removeCliente(id).subscribe(
          () => {
            this.messageService.add({
              severity: 'success',
              summary: 'Deletado',
              detail: 'cliente deletado com sucesso!',
            });
            setTimeout(() => {
              return window.location.reload();
            }, 1000);
          },
          (erro) => {
            if (erro.status == 404) {
              this.messageService.add({
                severity: 'error',
                summary: 'Erro 404',
                detail: 'Página não encontrada.',
              });
            } else if (erro.status == 500) {
              this.messageService.add({
                severity: 'error',
                summary: 'Erro 500',
                detail: 'Houve um erro ao carregar ao informações.',
              });
            } else if (erro != null) {
              this.messageService.add({
                severity: 'error',
                summary: 'Erro ao deletar',
                detail:
                  'Estamos enfrentado alguns erros de sistema. Tente novamente mais tarde.',
              });
            }
            console.log(erro);
          }
        );
      },
    });
  }

  formatarCPF(cpf: string): string {
    if (!cpf) return '';
    const cpfLimpo = cpf.replace(/\D/g, '');
    return cpfLimpo.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
  }

  formatarTelefone(telefone: string): string {
    if (!telefone) return '';
    const numeros = telefone.replace(/\D/g, '');

    if (numeros.length === 11) {
      return `(${numeros.slice(0, 2)}) ${numeros.slice(2, 3)} ${numeros.slice(
        3,
        7
      )}-${numeros.slice(7)}`;
    } else {
      return numeros;
    }
  }

  clear(table: Table) {
    table.clear();
  }
}
