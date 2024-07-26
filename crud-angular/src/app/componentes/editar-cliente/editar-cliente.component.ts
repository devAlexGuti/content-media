import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ClienteService } from './../../services/cliente.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-editar-cliente',
  templateUrl: './editar-cliente.component.html',
  styleUrls: ['./editar-cliente.component.css']
})
export class EditarClienteComponent implements OnInit {

  formularioDeClientes: FormGroup;
  elID: any;
  cliente: any;

  tiposDeDocumento = [
    { value: 1, label: 'DNI' },
    { value: 2, label: 'RUC' },
    { value: 3, label: 'Carnet de extranjería' }
  ];

  constructor(
    private activeRoute: ActivatedRoute,
    private clienteService: ClienteService,
    public formulario: FormBuilder,
    private ruteador: Router
  ) {
    this.formularioDeClientes = this.formulario.group({
      doc_type: ['', Validators.required],
      doc_number: ['', Validators.required],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      phone: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
    });
  }

  ngOnInit(): void {
    this.elID = this.activeRoute.snapshot.paramMap.get('id');
    console.log(this.elID);

    this.clienteService.getCliente(this.elID).subscribe(
      (respuesta: any) => {
        console.log(respuesta);
        this.cliente = respuesta.client;
        this.patchFormValues();
      },
      error => {
        console.error('Error al obtener el cliente', error);
        Swal.fire('Error', 'No se pudo obtener el cliente', 'error');
      }
    );
  }

  patchFormValues(): void {
    this.formularioDeClientes.patchValue({
      doc_type: this.cliente.doc_type,
      doc_number: this.cliente.doc_number,
      first_name: this.cliente.first_name,
      last_name: this.cliente.last_name,
      phone: this.cliente.phone,
      email: this.cliente.email,
    });
  }

  enviarDatos(): void {
    if (this.formularioDeClientes.valid) {
      console.log('Datos del formulario:', this.formularioDeClientes.value);
      this.clienteService.updateCliente(this.elID, this.formularioDeClientes.value).subscribe(
        response => {
          console.log('Respuesta del servidor:', response);
          Swal.fire({
            title: 'Cliente actualizado',
            text: 'El cliente ha sido actualizado exitosamente.',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            this.ruteador.navigateByUrl('/listar-cliente');
          });
        },
        error => {
          console.error('Error al actualizar el cliente', error);
          Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al actualizar el cliente.',
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
