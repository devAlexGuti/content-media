import { Component, OnInit } from '@angular/core';
import { Tienda } from './../../models/tienda';
import { TiendaService } from './../../services/tienda.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-tienda-libro',
  templateUrl: './tienda-libro.component.html',
  styleUrls: ['./tienda-libro.component.css']
})
export class TiendaLibroComponent implements OnInit {

  tiendas: Tienda[] = [];
  apiUrl = 'http://localhost:8000/';

  constructor(private libroService: TiendaService) { }

  ngOnInit(): void {
    this.libroService.getTiendas().subscribe(
      (data: any) => {
        this.tiendas = data.books;
        console.log('Datos obtenidos del API REST:', this.tiendas);
      },
      (error) => {
        console.error('Error al obtener los datos del API REST:', error);
      }
    );
  }

  loadLibros(): void {
    this.libroService.getTiendas().subscribe(
      (data: any[]) => this.tiendas = data,
      error => console.error('Error al cargar los libros', error)
    );
  }

  getImageUrl(imageName: string): string {
    return `${this.apiUrl}${imageName}`;
  }

  agregarAlCarrito(tienda: Tienda): void {
    // Aquí iría la lógica para agregar al carrito
    // Por ejemplo, podrías tener un carritoService que maneje esto
    // Por simplicidad, estamos utilizando una alerta aquí.
    Swal.fire({
      icon: 'success',
      title: '¡Libro agregado!',
      text: `${tienda.name} ha sido agregado al carrito.`,
      showConfirmButton: false,
      timer: 1500
    });
  }

}
