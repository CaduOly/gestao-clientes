import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private loggedIn = new BehaviorSubject<boolean>(false);

  constructor() {
    this.loggedIn.next(localStorage.getItem('token') ? true : false);
  }

  isLoggedIn() {
    return this.loggedIn.asObservable();
  }

  login(user: any) {
    // Gere um token de alguma maneira. Aqui estamos apenas gerando uma string aleatória.
    const token = Math.random().toString(36).substring(7);
    localStorage.setItem('token', token);
    this.loggedIn.next(true);
  }

  logout() {
    localStorage.removeItem('token');
    this.loggedIn.next(false);
  }
}
