import {
  Component,
  OnInit,
} from '@angular/core';

import { Message } from '../../classes/Message';
import { MessageService } from '../service/message.service';


@Component({
  selector: 'app-list-message',
  templateUrl: './list-message.component.html',
  styleUrls: ['./list-message.component.css']
})
export class ListMessageComponent {
  MessageArray: Message[] = [];


  constructor(private service : MessageService) {
    this.service.getMessageObservable().subscribe(rep => {
      console.log(rep);
      this.MessageArray = rep
    })
  };

  ngOnInit(): void {};
}
