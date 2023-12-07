import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { NgModule } from '@angular/core';

import { ClienteService } from '../clientes/service/cliente.service';
import { LoginService } from '../login/service/login.service';
import { HeaderComponent } from './components/header/header.component';
import { MenuComponent } from './components/menu/menu.component';

import { ButtonModule } from 'primeng/button';
import { PanelMenuModule } from 'primeng/panelmenu';

@NgModule({
  declarations: [HeaderComponent, MenuComponent],
  imports: [CommonModule, HttpClientModule, ButtonModule, PanelMenuModule],
  exports: [HeaderComponent, MenuComponent],
  providers: [ClienteService, LoginService],
})
export class CoreModule {}
