import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Cliente } from '../models/cliente';
import { environment } from 'src/environments/environment';
import { Endereco } from '../models/endereco';

@Injectable({
  providedIn: 'root',
})
export class ClienteService {
  urlApi = environment.apiURL;
  viaCepUrl = 'https://viacep.com.br/ws/';

  constructor(private http: HttpClient) {}

  getAllClientes(): Observable<Cliente[]> {
    return this.http.get<Cliente[]>(`${this.urlApi}/cliente`);
  }

  getClienteById(id: number): Observable<Cliente> {
    return this.http.get<Cliente>(`${this.urlApi}/cliente/${id}`);
  }

  addCliente(cliente: Cliente): Observable<any> {
    return this.http.post(`${this.urlApi}/cliente/cadastro`, cliente);
  }

  updateCliente(cliente: Cliente): Observable<any> {
    const { id, ...clienteSemId } = cliente;
    return this.http.put(`${this.urlApi}/cliente/${id}`, clienteSemId);
  }

  removeCliente(id: number): Observable<any> {
    return this.http.delete(`${this.urlApi}/cliente/${id}`);
  }

  getEndereco(cep: string): Observable<Endereco> {
    return this.http.get<Endereco>(`${this.viaCepUrl}${cep}/json`);
  }
}
