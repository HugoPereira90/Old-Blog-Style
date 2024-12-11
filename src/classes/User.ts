export class User {

    constructor(
        public ID : number,
        public username: string,
        public password: string,
        public photo : string,
        public email : string,) { 
        this.photo = photo;
        this.password = password;
        this.username = username;
        this.photo = photo;
        this.email = email;
    }
}