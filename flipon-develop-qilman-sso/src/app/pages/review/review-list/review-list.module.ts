import { NgModule } from '@angular/core';
import { SharedModule } from '../../../shared/shared.module';
import { NgxPaginationModule } from 'ngx-pagination';

import { ReviewListRoutingModule } from './review-list-routing.module';
import { ReviewListComponent } from './review-list.component';

@NgModule({
  declarations: [ReviewListComponent],
  imports: [
    SharedModule,
    NgxPaginationModule,
    ReviewListRoutingModule
  ]
})
export class ReviewListModule { }
