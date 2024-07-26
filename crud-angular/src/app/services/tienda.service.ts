import { Tienda } from './../models/tienda';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class TiendaService {
  private apiUrl = 'http://localhost:8000/api/books';

  constructor(private http: HttpClient) { }

  getTiendas(): Observable<Tienda[]> {
    return this.http.get<Tienda[]>(this.apiUrl);
  }

}
