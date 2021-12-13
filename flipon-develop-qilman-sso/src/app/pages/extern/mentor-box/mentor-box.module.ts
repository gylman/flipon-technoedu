import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MentorBoxRoutingModule } from './mentor-box-routing.module';
import { MentorBoxComponent } from './mentor-box.component';
import { ClarityModule } from '@clr/angular';
import { FeedbackComponent } from './feedback/feedback.component';


@NgModule({
  declarations: [MentorBoxComponent, FeedbackComponent],
  imports: [
    CommonModule,
    MentorBoxRoutingModule,
    ClarityModule
  ]
})
export class MentorBoxModule { }
