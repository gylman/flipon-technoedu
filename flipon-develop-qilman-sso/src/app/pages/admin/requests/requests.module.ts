import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { RequestsRoutingModule } from './requests-routing.module';
import { RequestsComponent } from './requests.component';
import {MaterialModule} from '../../../material.module';
import {ClarityModule} from '@clr/angular';


@NgModule({
  declarations: [RequestsComponent],
  imports: [
    CommonModule,
    MaterialModule,
    ClarityModule,
    RequestsRoutingModule
  ]
})
export class RequestsModule { }
