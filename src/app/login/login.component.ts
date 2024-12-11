import { Component } from '@angular/core';
import { AccountService } from '../service/account.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})

export class LoginComponent {
  errorMessage: string = '';

  username: string = '';
  password: string = '';

  constructor(private databaseService: AccountService, private router: Router) { }

  login(): void {
    this.databaseService.getUserByUsername(this.username,this.password).subscribe(user => {
      if (user.length > 0) {
        // Connexion réussie
        console.log('Connexion réussie !');
        this.router.navigateByUrl('/'); // Routage vers la page d'index
      } else {
        // Identifiants invalides
       console.log('Identifiants invalides !');
      }
    });
  }
}
