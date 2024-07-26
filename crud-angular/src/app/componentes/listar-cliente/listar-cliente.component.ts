import { Component, OnInit } from '@angular/core';
import { ClienteService } from '../../services/cliente.service';
import { Cliente } from '../../models/cliente';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-listar-cliente',
  templateUrl: './listar-cliente.component.html',
  styleUrls: ['./listar-cliente.component.css']
})
export class ListarClienteComponent implements OnInit {

  clientes: Cliente[]= [];

  constructor(private clienteService: ClienteService) { }

  ngOnInit(): void {
    this.clienteService.getClientes().subscribe(
      (data: any) => { // Ajusta la recepción de datos según la estructura de respuesta,Utilizamos 'any' para permitir cualquier estructura de datos
        this.clientes = data.clients; // Asegúrate de asignar solo los clientes
        console.log('Datos obtenidos del API REST:', this.clientes);
      },
      (error) => {
        console.error('Error al obtener los datos del API REST:', error);
      }
    );
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
        this.clienteService.deleteCliente(id).subscribe(
          (response) => {
            this.clientes.splice(iControl, 1);
            Swal.fire(
              'Eliminado!',
              'El cliente ha sido eliminado.',
              'success'
            );
          },
          (error) => {
            Swal.fire(
              'Error!',
              'Hubo un problema al eliminar el cliente.',
              'error'
            );
            console.error('Error al eliminar el cliente:', error);
          }
        );
      }
    });
  }

   // Función para obtener el tipo de documento
   getTipoDocumento(docType: number): string {
    switch (docType) {
      case 1: return 'DNI';
      case 2: return 'RUC';
      case 3: return 'Carnet de extranjería';
      default: return 'Desconocido';
    }
  }

}
