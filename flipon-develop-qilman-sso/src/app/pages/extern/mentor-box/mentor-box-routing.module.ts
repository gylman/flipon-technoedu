import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MentorBoxComponent } from './mentor-box.component';

const routes: Routes = [{ path: '', component: MentorBoxComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MentorBoxRoutingModule { }
