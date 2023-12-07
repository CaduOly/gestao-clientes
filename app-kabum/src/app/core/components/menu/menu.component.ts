import { Component, OnInit, EventEmitter, Output } from '@angular/core';
import { MenuItem } from 'primeng/api';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.css'],
})
export class MenuComponent implements OnInit {
  @Output() menuClick = new EventEmitter<void>();
  items: MenuItem[] = [];
  user!: string;

  ngOnInit() {
    this.definirUsuario();
    this.items = [
      { label: 'Olá ' + this.user },
      {
        label: 'Clientes',
        icon: 'pi pi-fw pi-file',
        items: [
          {
            label: 'Adicionar',
            icon: 'pi pi-fw pi-plus',
            routerLink: '/clientes/novo',
            command: () => {
              this.menuClick.emit();
            },
          },
          {
            label: 'Listar',
            icon: 'pi pi-fw pi-list',
            routerLink: '/clientes',
            command: () => {
              this.menuClick.emit();
            },
          },
        ],
      },
      {
        label: 'Sair',
        command: () => {
          localStorage.removeItem('token');
          window.location.reload();
        },
      },
    ];
  }

  definirUsuario() {
    const userString = localStorage.getItem('user');

    if (userString !== null) {
      const userObject = JSON.parse(userString);
      this.user = userObject.nome;
    }
  }
}
