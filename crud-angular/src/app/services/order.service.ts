import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Order } from './../models/order';
import { OrderDetail } from './../models/order-detail';

@Injectable({
  providedIn: 'root'
})
export class OrderService {
  private apiUrl = 'http://localhost:8000/api/orders';

  constructor(private http: HttpClient) { }

  getOrder(orderId: number): Observable<Order> {
    return this.http.get<Order>(`${this.apiUrl}/${orderId}`);
  }

  addBookToOrder(orderId: number, bookId: number, detailPrice: number, quantity: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/${orderId}/add-book`, { book_id: bookId, detail_price: detailPrice, quantity });
  }

  updateBookQuantity(orderId: number, bookId: number, quantity: number): Observable<any> {
    return this.http.put(`${this.apiUrl}/${orderId}/books/${bookId}`, { quantity });
  }

  deleteBookFromOrder(orderId: number, bookId: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${orderId}/books/${bookId}`);
  }

  checkout(orderId: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/${orderId}/checkout`, { payment_status: 'paid' });
  }
}
