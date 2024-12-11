import {
  Component,
  OnInit,
  Input,
} from '@angular/core';

import { Message } from '../../classes/Message';

@Component({
  selector: 'app-message',
  templateUrl: './message.component.html',
  styleUrls: ['./message.component.css']
})
export class MessageComponent {
  @Input() message!: Message;

  constructor() {};

  ngOnInit(): void {};
}
