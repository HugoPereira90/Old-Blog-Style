export class PrivateMessage {

    constructor(
        public ID : number,
        public date: string,
        public texte: string,
        public SenderID : number,
        public RecipientID : number
        ) {
        
        this.ID = ID;
        this.RecipientID = RecipientID;
        this.SenderID = SenderID;
        this.date = date;
        this.texte = texte;
    }
  }
  