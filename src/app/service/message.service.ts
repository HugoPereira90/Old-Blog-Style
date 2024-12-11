import { Injectable } from '@angular/core';

import { Message } from '../../classes/Message';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MessageService {

  MessageArray : Message[] = []
  message!: Message
constructor(private http: HttpClient) {}


  getPlayer() : Message[] {

   this.http.get<Message[]>('http://localhost:3000/message').subscribe(
     rep => {
       console.log(rep);
       this.MessageArray = rep
     }
   )
   return this.MessageArray;
  }

  getMessageObservable(): Observable<Message[]> {
    return this.http.get<Message[]>('http://localhost:3000/message');
  }

  getPrdByIndex(prd_idx: number): Message {
   this.http.get<Message>('http://localhost:3000/products/'+ prd_idx)
   .subscribe(data => {
     console.log(data)
   this.message = data
   })
   return this.message
  }

  addMessage(message: Message): Observable<Message> {
    return this.http.post<Message>('http://localhost:3000/players', message);
  }
}
