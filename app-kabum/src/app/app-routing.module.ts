import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClienteModule } from './clientes/cliente.module';
import { LoginModule } from './login/login.module';
import { UsuarioModule } from './usuario/usuario.module';
import { AuthGuard } from './core/guards/auth.guard';

const routes: Routes = [
  {
    path: '',
    pathMatch: 'full',
    redirectTo: 'home',
  },
  {
    path: 'home',
    loadChildren: () => ClienteModule,
    canActivate: [AuthGuard],
  },
  {
    path: 'login',
    loadChildren: () => LoginModule,
  },
  {
    path: 'cadastro',
    loadChildren: () => UsuarioModule,
  },
  {
    path: 'clientes',
    loadChildren: () => ClienteModule,
    canActivate: [AuthGuard],
  },
  {
    path: '**',
    redirectTo: 'home',
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
