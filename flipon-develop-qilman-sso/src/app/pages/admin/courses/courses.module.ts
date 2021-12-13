import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CoursesRoutingModule } from './courses-routing.module';
import { CoursesComponent } from './courses.component';
import {ClarityModule} from '@clr/angular';
import {MaterialModule} from '../../../material.module';
import {FormsModule} from '@angular/forms';


@NgModule({
  declarations: [CoursesComponent],
  imports: [
    CommonModule,
    CoursesRoutingModule,
    ClarityModule,
    FormsModule
  ]
})
export class CoursesModule { }
