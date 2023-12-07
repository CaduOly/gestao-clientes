import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../../auth/auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css'],
})
export class HeaderComponent implements OnInit {
  showMenu: boolean = false;
  logged: boolean = false;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthService
  ) {
    this.authService.isLoggedIn().subscribe((loggedIn) => {
      this.logged = loggedIn;
    });
  }

  ngOnInit(): void {}

  handleMenu() {
    this.showMenu = !this.showMenu;
  }
}
