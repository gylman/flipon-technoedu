import { NgModule } from '@angular/core';

import { QnaPostComponent } from './qna-post.component';
import { QnaPostRoutingModule } from './qna-post-routing.module';
import { SharedModule } from '../../../shared/shared.module';



@NgModule({
  declarations: [QnaPostComponent],
  imports: [
    SharedModule,
    QnaPostRoutingModule
  ]
})
export class QnaPostModule { }
