import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
  { path: 'board/post', loadChildren: () => import('./qna-post/qna-post.module').then(m => m.QnaPostModule) },
  { path: 'board/:id', loadChildren: () => import('./qna-detail/qna-detail.module').then(m => m.QnaDetailModule) },
  { path: 'board', loadChildren: () => import('./qna-list/qna-list.module').then(m => m.QnaListModule) },
  { path: '', loadChildren: () => import('./qna-guide/qna-guide.module').then(m => m.QnaGuideModule) }
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class QnaRoutingModule { }
