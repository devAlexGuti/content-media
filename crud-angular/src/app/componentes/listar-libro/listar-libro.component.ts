import { Component, OnInit } from '@angular/core';
import { LibroService } from '../../services/libro.service';
import { Libro } from '../../models/libro';
import Swal from 'sweetalert2';

declare var $: any;

@Component({
  selector: 'app-listar-libro',
  templateUrl: './listar-libro.component.html',
  styleUrls: ['./listar-libro.component.css']
})
export class ListarLibroComponent implements OnInit {

  libros: Libro[]= [];
  apiUrl = 'http://localhost:8000/';

  constructor(private libroService: LibroService) { }

  ngOnInit(): void {
    this.libroService.getLibros().subscribe(
      (data: any) => { // Ajusta la recepción de datos según la estructura de respuesta,Utilizamos 'any' para permitir cualquier estructura de datos
        this.libros = data.books; // Asegúrate de asignar solo los libros
        console.log('Datos obtenidos del API REST:', this.libros);
      },
      (error) => {
        console.error('Error al obtener los datos del API REST:', error);
      }
    );
  }
  loadLibros(): void {
    this.libroService.getLibros().subscribe(
      (data: any[]) => this.libros = data,
      error => console.error('Error al cargar los libros', error)
    );
  }

  getImageUrl(imageName: string): string {
    return `${this.apiUrl}${imageName}`;
  }
  borrarRegistro(id:any, iControl:any)
  {
    console.log(id);
    console.log(iControl);

    Swal.fire({
      title: '¿Estás seguro?',
      text: "No podrás revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminarlo!'
    }).then((result) => {
      if (result.isConfirmed) {
        this.libroService.deleteLibro(id).subscribe(
          (response) => {
            this.libros.splice(iControl, 1);
            Swal.fire(
              'Eliminado!',
              'El libro ha sido eliminado.',
              'success'
            );
          },
          (error) => {
            Swal.fire(
              'Error!',
              'Hubo un problema al eliminar el libro.',
              'error'
            );
            console.error('Error al eliminar el libro:', error);
          }
        );
      }
    });
  }

}
