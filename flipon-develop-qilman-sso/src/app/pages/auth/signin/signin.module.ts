import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SigninRoutingModule } from './signin-routing.module';
import { SigninComponent } from './signin.component';
import {FormsModule} from '@angular/forms';
import {ClarityModule} from '@clr/angular';


@NgModule({
  declarations: [SigninComponent],
    imports: [
        CommonModule,
        SigninRoutingModule,
        FormsModule,
        ClarityModule
    ]
})
export class SigninModule { }
