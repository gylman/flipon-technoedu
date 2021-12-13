import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
  { path: '', loadChildren: () => import('./review-list/review-list.module').then(m => m.ReviewListModule) },
  { path: ':id', loadChildren: () => import('./review-detail/review-detail.module').then(m => m.ReviewDetailModule) }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ReviewRoutingModule { }
