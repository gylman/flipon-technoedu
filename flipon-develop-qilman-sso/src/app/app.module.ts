import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import {HttpClientJsonpModule, HttpClientModule} from '@angular/common/http';
import {FormsModule} from '@angular/forms';
import {AdminGuard} from './guard/admin-guard';
import {ExternGuard} from './guard/extern-guard';
import {BaseGuard} from './guard/base-guard';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {MatInputModule} from '@angular/material/input';
import { ClarityModule } from '@clr/angular';
import {StudentGuard} from './guard/student-guard';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule.withServerTransition({ appId: 'serverApp' }),
    AppRoutingModule,
    HttpClientModule,
    HttpClientJsonpModule,
    FormsModule,
    BrowserAnimationsModule,
    ClarityModule
  ],
  providers: [
    AdminGuard,
    BaseGuard,
    StudentGuard,
    ExternGuard
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
