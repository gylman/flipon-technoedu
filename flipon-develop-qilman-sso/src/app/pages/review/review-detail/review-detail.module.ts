import { NgModule } from '@angular/core';

import { ReviewDetailRoutingModule } from './review-detail-routing.module';
import { ReviewDetailComponent } from './review-detail.component';
import { SharedModule } from '../../../shared/shared.module';

@NgModule({
  declarations: [ReviewDetailComponent],
  imports: [
    ReviewDetailRoutingModule,
    SharedModule
  ]
})
export class ReviewDetailModule { }
