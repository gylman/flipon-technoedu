import {NgModule} from '@angular/core';
import {SharedModule} from '../../../shared/shared.module';


import {QnaGuideRoutingModule} from './qna-guide-routing.module';
import {QnaGuideComponent} from './qna-guide.component';



@NgModule({
  declarations: [QnaGuideComponent],
  imports: [
    SharedModule,
    QnaGuideRoutingModule
  ]
})
export class QnaGuideModule {}
