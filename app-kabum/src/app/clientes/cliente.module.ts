import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ClienteRoutingModule } from './cliente-routing.module';
import { ClienteListComponent } from './components/cliente-list/cliente-list.component';

import { ClienteComponent } from './components/cliente/cliente.component';

import { ButtonModule } from 'primeng/button';
import { CardModule } from 'primeng/card';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { DataViewModule } from 'primeng/dataview';
import { InputMaskModule } from 'primeng/inputmask';
import { InputTextModule } from 'primeng/inputtext';
import { MessageModule } from 'primeng/message';
import { ProgressBarModule } from 'primeng/progressbar';
import { TableModule } from 'primeng/table';
import { ToastModule } from 'primeng/toast';

@NgModule({
  declarations: [ClienteListComponent, ClienteComponent],
  imports: [
    CommonModule,
    ClienteRoutingModule,
    FormsModule,
    ReactiveFormsModule,

    ToastModule,
    ButtonModule,
    InputTextModule,
    InputMaskModule,
    MessageModule,
    TableModule,
    DataViewModule,
    ProgressBarModule,
    ConfirmDialogModule,
    CardModule,
  ],
})
export class ClienteModule {}
