import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClienteListComponent } from './components/cliente-list/cliente-list.component';
import { ClienteComponent } from './components/cliente/cliente.component';

const routes: Routes = [
  {
    path: '',
    component: ClienteListComponent,
  },
  {
    path: 'novo',
    component: ClienteComponent,
  },
  {
    path: ':id',
    component: ClienteComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ClienteRoutingModule {}
