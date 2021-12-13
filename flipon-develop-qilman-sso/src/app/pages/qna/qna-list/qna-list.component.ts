import { Component, OnInit } from '@angular/core';
import { QnaService } from '../../../service/qna.service';
import { QnaModel, QnaCategory } from '../../../models/qna.model';
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-qna-list',
  templateUrl: './qna-list.component.html',
  styleUrls: ['./qna-list.component.scss'],
})
export class QnaListComponent implements OnInit {

  categories: string[] = [];
  selectedCategory = '';

  constructor(
    private qnaService: QnaService,
    private router: Router,
    private route: ActivatedRoute) {
    Object.keys(QnaCategory).filter(key => this.categories.push(QnaCategory[key]));
  }

  ngOnInit(): void {
    this.selectedCategory = QnaCategory.Teacher;
  }

  setCategory(selected: string) {
    this.selectedCategory = selected;
  }

  get qnas() {
    return this.qnaService.getQnaByCategory(this.selectedCategory);
  }
  moveDetail(qnaId: number) {
    this.router.navigate([qnaId], { relativeTo: this.route });
  }
  movePost() {
    this.router.navigate(['post'], { relativeTo: this.route });
  }
}
