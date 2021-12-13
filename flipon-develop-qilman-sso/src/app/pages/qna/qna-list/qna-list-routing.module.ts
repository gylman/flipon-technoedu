import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { QnaListComponent } from './qna-list.component';

const routes: Routes = [{ path: '', component: QnaListComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class QnaListRoutingModule { }
