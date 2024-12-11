export class Message {

    constructor(
        public ID : number,
        public pseudo: string,
        public date: string,
        public themeID: number,
        public texte: string,
        public OwnerID : number,
        public image ?: string,) {
        
        this.OwnerID = OwnerID;
        this.pseudo = pseudo;
        this.date = date;
        this.themeID = themeID;
        this.image = image;
        this.texte = texte;
    }
  }
  