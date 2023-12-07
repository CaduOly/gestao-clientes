import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import {
  FormBuilder,
  FormGroup,
  Validators,
  FormArray,
  ValidatorFn,
  AbstractControl,
  ValidationErrors,
} from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import {
  ConfirmEventType,
  ConfirmationService,
  MessageService,
} from 'primeng/api';
import { Cliente } from '../../models/cliente';
import { Endereco } from '../../models/endereco';
import { ClienteService } from '../../service/cliente.service';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-cliente',
  templateUrl: './cliente.component.html',
  styleUrls: ['./cliente.component.css'],
  providers: [MessageService, ConfirmationService, DatePipe],
})
export class ClienteComponent implements OnInit {
  title = 'Cadastrar Cliente';
  clienteForm!: FormGroup;
  cliente = new Cliente();
  clienteLazyLoad: Cliente[] = [];
  loading = false;
  editandoEndereco = false;

  consultarButton = 'Consultar CEP';

  constructor(
    private clienteService: ClienteService,
    private fb: FormBuilder,
    private http: HttpClient,
    private messageService: MessageService,
    private confirmationService: ConfirmationService,
    private router: Router,
    private route: ActivatedRoute,
    private datePipe: DatePipe
  ) {}

  ngOnInit() {
    const id: number = this.route.snapshot.params['id'];
    if (id) {
      this.loading = true;
      this.title = 'Alterar cliente';
      this.getCliente(id);
    }
    this.initializeForm();
  }

  private initializeForm() {
    this.clienteForm = this.fb.group({
      nome: ['', Validators.required],
      cpf: ['', Validators.required],
      rg: ['', Validators.required],
      dataNascimento: ['', Validators.required],
      telefone: ['', Validators.required],
      cep: [''],
      enderecos: this.fb.array([]),
    });

    const enderecosFormArray = this.clienteForm.get('enderecos') as FormArray;
    enderecosFormArray.setValidators(this.atLeastOneEnderecoValidator());
  }

  private initializeEnderecoForm(): FormGroup {
    return this.fb.group({
      cep: ['', Validators.required],
      numero: [''],
      logradouro: ['', Validators.required],
      complemento: [''],
      bairro: ['', Validators.required],
      localidade: ['', Validators.required],
      uf: ['', Validators.required],
    });
  }

  private atLeastOneEnderecoValidator(): ValidatorFn {
    return (formArray: AbstractControl): ValidationErrors | null => {
      const hasAtLeastOneEndereco =
        formArray && formArray.value && formArray.value.length > 0;
      return hasAtLeastOneEndereco ? null : { atLeastOneEndereco: true };
    };
  }
  getCliente(id: number) {
    this.clienteService.getClienteById(id).subscribe((response) => {
      if (!response) {
        this.title = 'Erro ao encontrar cliente';
        this.messageService.add({
          severity: 'error',
          summary: 'Id inexistente:',
          detail: 'Não encontramos o cliente',
        });
      }

      this.cliente = { ...response };
      if (this.cliente && response.enderecos) {
        this.fillClienteForm();
        this.fillEnderecosFormArray(response.enderecos);

        if (this.cliente.enderecos!.length > 0) {
          this.consultarButton = 'Adicionar outro endereço';
        }
        setTimeout(() => {
          this.loading = false;
        }, 1000);
      }
    });
  }

  private fillClienteForm() {
    this.clienteForm.patchValue({
      nome: this.cliente.nome,
      cpf: this.cliente.cpf,
      rg: this.cliente.rg,
      dataNascimento: this.datePipe.transform(
        this.cliente.data_nascimento,
        'dd/MM/yyyy'
      ),
      telefone: this.cliente.telefone,
      cep: '',
    });
  }

  private fillEnderecosFormArray(enderecos: Endereco[]) {
    const enderecosFormArray = this.clienteForm.get('enderecos') as FormArray;
    enderecosFormArray.clear();

    if (enderecos && enderecos.length > 0) {
      enderecos.forEach((endereco) => {
        enderecosFormArray.push(this.createEnderecoFormGroup(endereco));
      });
    }
  }

  private createEnderecoFormGroup(endereco: Endereco): FormGroup {
    return this.fb.group({
      cep: [endereco.cep, Validators.required],
      numero: [endereco.numero],
      logradouro: [endereco.logradouro, Validators.required],
      complemento: [endereco.complemento],
      bairro: [endereco.bairro, Validators.required],
      localidade: [endereco.localidade, Validators.required],
      uf: [endereco.uf, Validators.required],
    });
  }

  get enderecos(): FormArray {
    return this.clienteForm.get('enderecos') as FormArray;
  }

  removerEndereco(index: number) {
    this.enderecos.removeAt(index);
  }

  getCep() {
    const newCep = this.clienteForm.get('cep')?.value?.replace(/[^0-9]/g, '');
    this.editandoEndereco = true;
    try {
      this.clienteService.getEndereco(newCep).subscribe((response) => {
        if (!response.erro) {
          const enderecoFormGroup = this.initializeEnderecoForm();
          enderecoFormGroup.patchValue({
            cep: response.cep,
            logradouro: response.logradouro,
            bairro: response.bairro,
            localidade: response.localidade,
            uf: response.uf,
          });
          this.consultarButton = 'Adicionar outro endereço';
          this.enderecos.push(enderecoFormGroup);
        } else {
          this.handleCepError();
        }
      });
    } catch (error) {}
  }

  adicionarEndereco() {
    this.enderecos.push(this.fb.group(new Endereco()));
  }

  private formatarClienteParaEnvio(): Cliente {
    const clienteFormValue = this.clienteForm.value;
    return {
      id: this.cliente.id,
      nome: clienteFormValue.nome,
      cpf: clienteFormValue.cpf.replace(/\D/g, ''),
      rg: clienteFormValue.rg.replace(/\D/g, ''),
      data_nascimento: this.formatarDataParaEnvio(
        clienteFormValue.dataNascimento
      ),
      telefone: clienteFormValue.telefone.replace(/\D/g, ''),
      enderecos: clienteFormValue.enderecos.map((endereco: any) => ({
        id: endereco.id,
        cep: endereco.cep,
        numero: endereco.numero,
        logradouro: endereco.logradouro,
        complemento: endereco.complemento,
        bairro: endereco.bairro,
        localidade: endereco.localidade,
        uf: endereco.uf,
        id_cliente: this.cliente.id,
      })),
    };
  }

  salvar() {
    this.confirmationService.confirm({
      message: 'Deseja SALVAR esse Cliente?',
      header: 'SALVAR',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {
        this.getIsEditando() ? this.getAlterar() : this.addCliente();
      },
      reject: (type: any) => this.handleReject(type),
    });
  }

  getAlterar() {
    const formattedCliente = this.formatarClienteParaEnvio();
    this.clienteService.updateCliente(formattedCliente).subscribe(
      (response) => this.handleAlterarSuccess(),
      (erro) => this.handleAlterarError(erro)
    );
  }

  addCliente() {
    const formattedCliente = this.formatarClienteParaEnvio();
    this.clienteService.addCliente(formattedCliente).subscribe(
      (response) => this.handleAddClienteSuccess(),
      (erro) => this.handleAddClienteError(erro)
    );
  }

  private handleCepError() {
    this.messageService.add({
      severity: 'error',
      summary: 'Erro 404',
      detail: 'Não encontramos nenhum CEP correspondente',
    });
  }

  private handleReject(type: any) {
    switch (type) {
      case ConfirmEventType.REJECT:
        this.handleRejectError('Você rejeitou a operação.');
        break;
      case ConfirmEventType.CANCEL:
        this.messageService.add({
          severity: 'warn',
          summary: 'Cancelado',
          detail: 'Você cancelou a operação.',
        });
        break;
    }
  }

  private handleRejectError(detail: string) {
    this.messageService.add({
      severity: 'error',
      summary: 'Rejeitado',
      detail: detail,
    });
  }

  private handleAlterarError404() {
    this.messageService.add({
      severity: 'error',
      summary: 'Erro 404',
      detail: 'Página não encontrada.',
    });
  }

  private handleAlterarSuccess() {
    this.messageService.add({
      severity: 'success',
      summary: 'Alteração ',
      detail: 'cliente alterado com sucesso!',
    });
    setTimeout(() => this.router.navigate(['/clientes']), 1000);
  }

  private handleAlterarError(erro: any) {
    if (erro.status == 404) {
      this.handleAlterarError404();
    } else if (erro.status == 500) {
      this.handleAlterarError500();
    } else if (erro != null) {
      this.handleAlterarErrorSystem();
    }
    console.log(erro);
  }

  private handleAlterarError500() {
    this.messageService.add({
      severity: 'error',
      summary: 'Erro 500',
      detail: 'Houve um erro ao carregar ao informações.',
    });
  }

  private handleAlterarErrorSystem() {
    this.messageService.add({
      severity: 'error',
      summary: 'Erro de sistema',
      detail:
        'Estamos enfrentado alguns erros de sistema. Tente novamente mais tarde.',
    });
  }

  private handleAddClienteSuccess() {
    this.messageService.add({
      severity: 'success',
      summary: 'Inclusão ',
      detail: 'cliente adicionado com sucesso!',
    });
    setTimeout(() => this.router.navigate(['/clientes']), 1000);
  }

  private handleAddClienteError(erro: any) {
    if (erro != null) {
      this.messageService.add({
        severity: 'error',
        summary: 'Erro de sistema',
        detail:
          'Estamos enfrentado alguns erros de sistema. Tente novamente mais tarde.',
      });
      console.log(erro);
    }
  }

  getIsEditando() {
    return Boolean(this.cliente.id);
  }

  private formatarDataParaEnvio(data: string): string {
    const [dia, mes, ano] = data.split('/');
    return `${ano}/${mes}/${dia}`;
  }
}
