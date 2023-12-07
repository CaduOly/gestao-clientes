import { Component, OnInit } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { MessageService } from 'primeng/api';

@Component({
  selector: 'app-usuario',
  templateUrl: './usuario.component.html',
  styleUrls: ['./usuario.component.css'],
  providers: [MessageService],
})
export class UsuarioComponent implements OnInit {
  nome!: string;
  usuario!: string;
  senha!: string;

  constructor(private messageService: MessageService, private router: Router) {}

  ngOnInit(): void {}

  cadastrar() {
    const user = {
      nome: this.nome,
      usuario: this.usuario,
      senha: this.senha,
    };
    localStorage.setItem('user', JSON.stringify(user));
    this.show();
    setTimeout(() => this.router.navigate(['/clientes']), 1000);
  }

  show() {
    this.messageService.add({
      severity: 'success',
      summary: 'Sucesso',
      detail: 'Usuário cadastrado com sucesso',
    });
  }
}
