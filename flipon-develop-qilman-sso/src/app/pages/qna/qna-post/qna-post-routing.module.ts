import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { QnaPostComponent } from './qna-post.component';

const routes: Routes = [{ path: '', component: QnaPostComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class QnaPostRoutingModule { }
