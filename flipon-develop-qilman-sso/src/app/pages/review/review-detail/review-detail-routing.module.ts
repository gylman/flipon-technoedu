import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ReviewDetailComponent } from './review-detail.component';

const routes: Routes = [{ path: '', component: ReviewDetailComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ReviewDetailRoutingModule { }
