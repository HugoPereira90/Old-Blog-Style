import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { Message } from 'src/classes/Message';
import { MessageService } from '../service/message.service';

@Component({
  selector: 'app-addpost',
  templateUrl: './addpost.component.html',
  styleUrls: ['./addpost.component.css']
})
export class AddpostComponent {
  
  formData: Message = new Message(0, '', '', 0, '', 0, '');

  constructor(private messageservice: MessageService) { }

  submitForm(): void {
    this.formData.date = new Date().toISOString(); // Récupère la date actuelle


    this.messageservice.addMessage(this.formData).subscribe(
      (response) => {
        console.log('Message envoyé avec succès !', response);
        this.formData = new Message(0, '', '', 0,'', 0,''); // Réinitialise le formulaire
      },
      (error) => {
        console.error('Une erreur s\'est produite lors de l\'envoie du message :', error);
      }
    );
    
    this.formData = new Message(0, '', '', 0,'', 0,''); // Réinitialise le formulaire
  }

}
