import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { LibroService } from './../../services/libro.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-editar-libro',
  templateUrl: './editar-libro.component.html',
  styleUrls: ['./editar-libro.component.css']
})
export class EditarLibroComponent implements OnInit {

  formularioDeLibros: FormGroup;
  elID: any;
  libro:any;

  constructor(
    private activeRoute: ActivatedRoute,
    private libroService: LibroService,
    public formulario: FormBuilder,
    private ruteador: Router
  ) {
    this.formularioDeLibros = this.formulario.group({
      isbn: ['', Validators.required],
      name: ['', Validators.required],
      stock: ['', Validators.required],
      current_price: ['', Validators.required]
    });
  }

  ngOnInit(): void {
    this.elID = this.activeRoute.snapshot.paramMap.get('id');
    console.log(this.elID);

    this.libroService.getLibro(this.elID).subscribe(
      (respuesta:any) => {
        console.log(respuesta);
        this.libro = respuesta.book;
        this.patchFormValues();
      },
      error => {
        console.error('Error al obtener el libro', error);
        Swal.fire('Error', 'No se pudo obtener el libro', 'error');
      }
    );
  }
  patchFormValues(): void {
    this.formularioDeLibros.patchValue({
      isbn: this.libro.isbn,
      name: this.libro.name,
      stock: this.libro.stock,
      current_price: this.libro.current_price
    });
  }

  enviarDatos(): void {
    if (this.formularioDeLibros.valid) {
      console.log('Datos del formulario:', this.formularioDeLibros.value);
      this.libroService.updateLibro(this.elID, this.formularioDeLibros.value).subscribe(
        response => {
          console.log('Respuesta del servidor:', response);
          Swal.fire({
            title: 'Libro actualizado',
            text: 'El libro ha sido actualizado exitosamente.',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
          this.ruteador.navigateByUrl('/listar-libro');
        });
      },
        error => {
          console.error('Error al actualizar el libro', error);
          Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al actualizar el libro.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      );
    } else {
      console.error('Formulario no válido');
    }
  }
}
