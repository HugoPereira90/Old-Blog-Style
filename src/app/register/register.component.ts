import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AccountService } from '../service/account.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})

export class RegisterComponent {
  username: string = '';
  password: string = '';
  successMessage: string = '';
  errorMessage: string = '';

  constructor(private router: Router, private databaseService: AccountService) { }

//   register(): void {
//     if (this.username && this.password) {
//       // Vérifier si l'utilisateur existe déjà
//       const existingUser = this.databaseService.getUserByUsername(this.username, this.password);

//       if (existingUser) {
//         this.errorMessage = 'Cet utilisateur existe déjà.';
//       } else {
//         // Générer un nouvel ID pour l'utilisateur
//         const newUserId = this.generateNewUserId();

//         // Créer un nouvel objet user avec les données saisies
//         const newUser = {
//           ID: newUserId,
//           username: this.username,
//           password: this.password,
//           photo: '../assets/Images/profil.png'
//         };

//         // Ajouter le nouvel utilisateur à la table "user"
//         this.databaseService.addUser(newUser).subscribe(() => {
//           this.successMessage = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
//         }, error => {
//           this.errorMessage = 'Une erreur s\'est produite lors de la création du compte.';
//         });
//       }
//     } else {
//       this.errorMessage = 'Veuillez remplir tous les champs.';
//     }
//   }

//   private generateNewUserId(): number {
//     let newUserId = 0;
//     this.databaseService.getLastUserId().subscribe((lastUserId: number) => {
//       newUserId = lastUserId + 1;
//     });
  
//     return newUserId;
//   }
}
