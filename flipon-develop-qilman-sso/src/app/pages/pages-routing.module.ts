import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AdminGuard } from '../guard/admin-guard';
import { ExternGuard } from '../guard/extern-guard';
import { BaseGuard } from '../guard/base-guard';
import { PagesComponent } from './pages.component';
import { StudentGuard } from '../guard/student-guard';

const routes: Routes = [
  { path: '', loadChildren: () => import('./home/home.module').then(m => m.HomeModule), canActivate: [ExternGuard] },
  { path: 'extern', loadChildren: () => import('./extern/extern.module').then(m => m.ExternModule) },
  {
    path: '',
    component: PagesComponent,
    children: [
      { path: 'admin', loadChildren: () => import('./admin/admin.module').then(m => m.AdminModule), canActivate: [AdminGuard] },
      { path: 'auth', loadChildren: () => import('./auth/auth.module').then(m => m.AuthModule) },
      { path: 'intro', loadChildren: () => import('./intro/intro.module').then(m => m.IntroModule) },
      { path: 'teachers', loadChildren: () => import('./teachers/teachers.module').then(m => m.TeachersModule), canActivate: [StudentGuard] },
      { path: 'me', loadChildren: () => import('./me/me.module').then(m => m.MeModule), canActivate: [BaseGuard] },
      { path: 'qna', loadChildren: () => import('./qna/qna.module').then(m => m.QnaModule) },
      { path: 'review', loadChildren: () => import('./review/review.module').then(m => m.ReviewModule) }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PagesRoutingModule {
}
