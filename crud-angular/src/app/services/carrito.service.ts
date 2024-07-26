import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { OrderDetail } from 'src/app/models/order-detail';

@Injectable({
  providedIn: 'root'
})
export class CarritoService {
  private apiUrl = 'http://localhost:8000/api/orders';

  constructor(private http: HttpClient) { }

  // Obtiene los detalles del carrito
  getOrderDetails(): Observable<OrderDetail[]> {
    const orderId = 1; // Ajusta este valor según cómo determines el ID del pedido
    return this.http.get<OrderDetail[]>(`${this.apiUrl}/${orderId}/details`);
  }

  // Actualiza la cantidad de un libro en el carrito
  updateOrderDetail(orderDetailId: number, data: { quantity: number }): Observable<any> {
    const orderId = 1; // Ajusta este valor según cómo determines el ID del pedido
    return this.http.put(`${this.apiUrl}/${orderId}/books/${orderDetailId}`, data);
  }

  // Elimina un libro del carrito
  removeOrderDetail(orderDetailId: number): Observable<any> {
    const orderId = 1; // Ajusta este valor según cómo determines el ID del pedido
    return this.http.delete(`${this.apiUrl}/${orderId}/books/${orderDetailId}`);
  }

  // Finaliza el proceso de checkout
  checkout(data: { total: number; doc_number: string; last_name: string; payment_status: string }): Observable<any> {
    const orderId = 1; // Ajusta este valor según cómo determines el ID del pedido
    return this.http.post(`${this.apiUrl}/${orderId}/checkout`, data);
  }
}
