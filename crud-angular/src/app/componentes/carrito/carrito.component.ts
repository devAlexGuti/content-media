import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-carrito',
  templateUrl: './carrito.component.html',
  styleUrls: ['./carrito.component.css']
})
export class CarritoComponent implements OnInit {
  order: any = {}; // Estructura de la orden
  orderDetails: any[] = []; // Detalles de la orden

  constructor(private http: HttpClient, private router: Router) { }

  ngOnInit(): void {
    this.loadOrder();
  }

  loadOrder(): void {
    const orderId = 1; // ID de la orden actual, puedes hacerlo dinámico si es necesario
    this.http.get<any>(`http://localhost:7700/api/orders/${orderId}`).subscribe(order => {
      this.order = order;
      this.loadOrderDetails(orderId);
    });
  }

  loadOrderDetails(orderId: number): void {
    this.http.get<any[]>(`http://localhost:7700/api/order-details/${orderId}`).subscribe(details => {
      this.orderDetails = details;
    });
  }

  updateQuantity(bookId: number, quantity: number): void {
    const orderId = this.order.id;
    this.http.put(`http://localhost:7700/api/orders/${orderId}/books/${bookId}`, { quantity })
      .subscribe(() => {
        this.loadOrderDetails(orderId);
      });
  }

  deleteBook(bookId: number): void {
    const orderId = this.order.id;
    this.http.delete(`http://localhost:7700/api/orders/${orderId}/books/${bookId}`)
      .subscribe(() => {
        this.loadOrderDetails(orderId);
      });
  }

  checkout(): void {
    const orderId = this.order.id;
    this.http.post(`http://localhost:7700/api/orders/${orderId}/checkout`, { payment_status: 'paid' })
      .subscribe(() => {
        Swal.fire('Compra completada', '', 'success');
        this.router.navigate(['/']); // Redirigir a otra página si es necesario
      });
  }
}
