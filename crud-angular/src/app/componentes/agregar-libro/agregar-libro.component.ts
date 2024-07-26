import { Libro } from './../../models/libro';
import { Component, OnInit } from '@angular/core';
import { FormGroup,FormBuilder  } from '@angular/forms';

import { LibroService } from 'src/app/services/libro.service';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-agregar-libro',
  templateUrl: './agregar-libro.component.html',
  styleUrls: ['./agregar-libro.component.css']
})
export class AgregarLibroComponent implements OnInit {

  formularioDeLibros:FormGroup;
  selectedFile: File | null = null;

  constructor(
      public formulario:FormBuilder,
      private libroService:LibroService,
      private ruteador: Router
  ) {
    this.formularioDeLibros=this.formulario.group({
      isbn:[''],
      name:[''],
      stock:[''],
      current_price:[''],
      image_book:['']
    });
  }

  ngOnInit():void {
  }
  onFileSelected(event: any): void {
    const file: File = event.target.files[0];
    if (file) {
      this.selectedFile = file;
    }
  }
  enviarDatos(): void {
    if (this.formularioDeLibros.valid && this.selectedFile) {
      const formData: FormData = new FormData();
      formData.append('isbn', this.formularioDeLibros.get('isbn').value);
      formData.append('name', this.formularioDeLibros.get('name').value);
      formData.append('stock', this.formularioDeLibros.get('stock').value);
      formData.append('current_price', this.formularioDeLibros.get('current_price').value);
      formData.append('image_book', this.selectedFile, this.selectedFile.name);

      this.libroService.createLibro(formData).subscribe(
        response => {
          console.log('Respuesta del servidor:', response);
          Swal.fire({
            title: 'Libro creado',
            text: 'El libro ha sido creado exitosamente.',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            this.ruteador.navigateByUrl('/listar-libro');
          });
        },
        error => {
          console.error('Error al crear el libro', error);
          Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al crear el libro.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      );
    } else {
      console.error('Formulario no válido o archivo de imagen no seleccionado');
    }
  }
}



