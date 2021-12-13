import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {QnaGuideComponent} from './qna-guide.component';

const routes: Routes = [{path: '', component: QnaGuideComponent}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class QnaGuideRoutingModule {}
