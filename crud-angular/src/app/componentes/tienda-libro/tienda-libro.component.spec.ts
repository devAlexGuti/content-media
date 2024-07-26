import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TiendaLibroComponent } from './tienda-libro.component';

describe('TiendaLibroComponent', () => {
  let component: TiendaLibroComponent;
  let fixture: ComponentFixture<TiendaLibroComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TiendaLibroComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TiendaLibroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
