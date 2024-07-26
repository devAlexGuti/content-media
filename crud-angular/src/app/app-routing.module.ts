import { NgModule, Component } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ListarClienteComponent } from './componentes/listar-cliente/listar-cliente.component';
import { AgregarClienteComponent } from './componentes/agregar-cliente/agregar-cliente.component';
import { EditarClienteComponent } from './componentes/editar-cliente/editar-cliente.component';

import { ListarLibroComponent } from './componentes/listar-libro/listar-libro.component';
import { AgregarLibroComponent } from './componentes/agregar-libro/agregar-libro.component';
import { EditarLibroComponent } from './componentes/editar-libro/editar-libro.component';

import { TiendaLibroComponent } from './componentes/tienda-libro/tienda-libro.component';

import { CarritoComponent } from './componentes/carrito/carrito.component';

/* Vamos a crear a nuestras rutas en el arreglo*/
const routes: Routes = [
  {path: '',pathMatch:'full',redirectTo:''},
  {path: 'agregar-cliente', component:AgregarClienteComponent},
  {path: 'listar-cliente', component:ListarClienteComponent},
  {path: 'editar-cliente/:id', component:EditarClienteComponent},
  {path: 'agregar-libro', component:AgregarLibroComponent},
  {path: 'listar-libro', component:ListarLibroComponent},
  {path: 'editar-libro/:id', component:EditarLibroComponent},
  {path: 'listar-tienda', component:TiendaLibroComponent},
  {path: 'carrito-compra', component:CarritoComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
