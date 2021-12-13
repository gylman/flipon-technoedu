import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {BaseGuard} from '../../guard/base-guard';

const routes: Routes = [
  { path: 'mentorbox', loadChildren: () => import('./mentor-box/mentor-box.module').then(m => m.MentorBoxModule), canActivate: [BaseGuard]}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ExternRoutingModule { }
