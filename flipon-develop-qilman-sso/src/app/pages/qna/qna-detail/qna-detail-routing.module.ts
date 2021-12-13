import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { QnaDetailComponent } from './qna-detail.component';

const routes: Routes = [{ path: '', component: QnaDetailComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class QnaDetailRoutingModule { }
