import { NgModule } from '@angular/core';

import { QnaDetailRoutingModule } from './qna-detail-routing.module';
import { QnaDetailComponent } from './qna-detail.component';
import { SharedModule } from '../../../shared/shared.module';



@NgModule({
  declarations: [QnaDetailComponent],
  imports: [
    QnaDetailRoutingModule,
    SharedModule
  ]
})
export class QnaDetailModule { }
