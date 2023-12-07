import { Component, OnInit } from '@angular/core';
import { MessageService } from 'primeng/api';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/core/auth/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [MessageService],
})
export class LoginComponent implements OnInit {
  usuario!: string;
  senha!: string;
  logged: boolean = false;

  constructor(
    private messageService: MessageService,
    private router: Router,
    private authService: AuthService
  ) {
    this.authService.isLoggedIn().subscribe((loggedIn) => {
      this.logged = loggedIn;
    });
  }

  ngOnInit(): void {}

  entrar() {
    let user = localStorage.getItem('user');
    console.log('user', user);
    if (user) {
      let userData = JSON.parse(user);
      console.log('userData', userData);
      if (
        userData &&
        userData.usuario === this.usuario &&
        userData.senha === this.senha
      ) {
        setTimeout(() => {
          this.showSuccess();
          this.authService.login(userData);
          this.router.navigate(['/']);
        }, 1300);
      } else {
        this.showError();
      }
    } else {
      this.showError();
    }
  }

  showSuccess() {
    this.messageService.add({
      severity: 'success',
      summary: 'Sucesso',
      detail: 'Bem vindo',
    });
  }

  showError() {
    this.messageService.add({
      severity: 'error',
      summary: 'Erro',
      detail: 'Usuário ou senha incorretos',
    });
  }
}
