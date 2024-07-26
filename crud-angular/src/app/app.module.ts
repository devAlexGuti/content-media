import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

// FormsModule nos sirve para trabajar con la parte de formularios //
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

//HttpClientModule, nos permite trabajar con las interacciones entre la bd o API
import {HttpClientModule} from '@angular/common/http';

// Servicios
import { ClienteService } from './services/cliente.service';
import { LibroService } from './services/libro.service';
import { TiendaService } from './services/tienda.service';
import { OrderService } from './services/order.service';
import { CarritoService } from './services/carrito.service';

// Componentes
import { ListarClienteComponent } from './componentes/listar-cliente/listar-cliente.component';
import { AgregarClienteComponent } from './componentes/agregar-cliente/agregar-cliente.component';
import { EditarClienteComponent } from './componentes/editar-cliente/editar-cliente.component';

import { ListarLibroComponent } from './componentes/listar-libro/listar-libro.component';
import { AgregarLibroComponent } from './componentes/agregar-libro/agregar-libro.component';
import { EditarLibroComponent } from './componentes/editar-libro/editar-libro.component';

import { TiendaLibroComponent } from './componentes/tienda-libro/tienda-libro.component';

import { CarritoComponent } from './componentes/carrito/carrito.component';

@NgModule({
  declarations: [
    AppComponent,
    ListarClienteComponent,
    AgregarClienteComponent,
    EditarClienteComponent,
    ListarLibroComponent,
    AgregarLibroComponent,
    EditarLibroComponent,
    TiendaLibroComponent,
    CarritoComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [ClienteService, LibroService, TiendaService, CarritoService],
  bootstrap: [AppComponent]
})
export class AppModule { }
