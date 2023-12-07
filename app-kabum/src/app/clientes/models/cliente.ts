import { Endereco } from './endereco';

export class Cliente {
  id!: number;
  nome?: string;
  data_nascimento?: Date | string;
  cpf?: string;
  rg?: string;
  telefone?: string;
  enderecos?: Endereco[] = [];
}
