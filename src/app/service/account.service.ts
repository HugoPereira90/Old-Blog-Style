import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class AccountService {
  private dbUrl = 'http://localhost:3000';

  constructor(private http: HttpClient) { }

  getUserByUsername(username: string, password: string): Observable<any> {
    return this.http.get<any>(`http://localhost:3000/user?username=${username}&password=${password}`);
  }
}
