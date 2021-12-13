import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ClarityModule } from '@clr/angular';

import { QnaListRoutingModule } from './qna-list-routing.module';
import { QnaListComponent } from './qna-list.component';



@NgModule({
  declarations: [QnaListComponent],
  imports: [
    CommonModule,
    ClarityModule,
    QnaListRoutingModule
  ]
})
export class QnaListModule { }
