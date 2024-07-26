import { Cliente } from './../../models/cliente';
import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ClienteService } from 'src/app/services/cliente.service';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-agregar-cliente',
  templateUrl: './agregar-cliente.component.html',
  styleUrls: ['./agregar-cliente.component.css']
})
export class AgregarClienteComponent implements OnInit {

  formularioDeClientes: FormGroup;

  tiposDeDocumento = [
    { value: 1, label: 'DNI' },
    { value: 2, label: 'RUC' },
    { value: 3, label: 'Carnet de extranjería' }
  ];

  constructor(
    public formulario: FormBuilder,
    private clienteService: ClienteService,
    private ruteador: Router
  ) {
    this.formularioDeClientes = this.formulario.group({
      doc_type: ['', Validators.required],
      doc_number: ['', [Validators.required, Validators.maxLength(8), Validators.minLength(8)]],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      phone: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]]
    });
  }

  ngOnInit(): void {
    this.formularioDeClientes.get('doc_type').valueChanges.subscribe(value => {
      const docNumberControl = this.formularioDeClientes.get('doc_number');
      if (value === 1) { // DNI
        docNumberControl.setValidators([Validators.required, Validators.maxLength(8), Validators.minLength(8)]);
      } else if (value === 2) { // RUC
        docNumberControl.setValidators([Validators.required, Validators.maxLength(11), Validators.minLength(11)]);
      } else if (value === 3) { // Carnet de extranjería
        docNumberControl.setValidators([Validators.required]);
      }
      docNumberControl.updateValueAndValidity();
    });
  }

  enviarDatos(): void {
    if (this.formularioDeClientes.valid) {
      console.log('Datos del formulario:', this.formularioDeClientes.value);
      this.clienteService.createCliente(this.formularioDeClientes.value).subscribe(
        response => {
          console.log('Respuesta del servidor:', response);
          Swal.fire({
            title: 'Cliente creado',
            text: 'El cliente ha sido creado exitosamente.',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            this.ruteador.navigateByUrl('/listar-cliente');
          });
        },
        error => {
          console.error('Error al crear el cliente', error);
          Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al crear el cliente.',
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
