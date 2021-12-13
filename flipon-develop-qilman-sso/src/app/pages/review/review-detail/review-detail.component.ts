import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { POSTDATA } from '../../../shared/components/posting/posting.component';
import { ReviewModel } from '../../../models/review.model';
import { ReviewService } from '../../../service/review.service';
import { MeService } from '../../../service/me.service';
import { of } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Component({
  selector: 'app-review-detail',
  templateUrl: './review-detail.component.html',
  styleUrls: ['./review-detail.component.scss']
})
export class ReviewDetailComponent implements OnInit {

  reviewData: ReviewModel | null;
  public editReview = false;
  private prevReview: {
    title: string;
    content: string;
  } | null;
  public postData: POSTDATA = {
    title: '',
    content: '',
    attachment: null
  };

  // TODO: 글 작성자랑 me랑 같은지 비교하고 수정하기 버튼 보이기/ 안보이기 표시! 일단은 활성화, 비활성화로 먼저 확인하고 되면 ngIf로 처리하자.
  constructor(
    private reviewService: ReviewService,
    private router: Router,
    private route: ActivatedRoute,
    private meService: MeService
  ) { }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.reviewService.getReview(id)
        .pipe(catchError(err => of(null)))
        .subscribe((review: ReviewModel) => this.reviewData = review);
    }
    if (!this.meService.me) {
      this.meService
        .getMe()
        .pipe(catchError(err => of(null)));
    }
  }

  isAuthor(): boolean {
    if (this.reviewData && this.meService.me) {
      return this.reviewData.writer.id === this.meService.me.id;
    }
    return false;
  }

  goback = () => {
    this.router.navigate(['../'], { relativeTo: this.route.parent });
  }
  startEditReview() {
    if (this.reviewData) {
      this.prevReview = { ...this.reviewData };
      this.postData = { ...this.reviewData, attachment: null };
    }
    this.editReview = true;
  }

  onSubmit = (dataFromPosting: POSTDATA) => {
    if (this.reviewData) {
      this.reviewData.title = dataFromPosting.title;
      this.reviewData.content = dataFromPosting.content;
      this.reviewService.updateReview(this.reviewData.id, this.reviewData);
    }
    console.log(this.reviewData);
    // TODO: redirect to previous page.
    this.editReview = false;
  }
  onCancel = () => {
    if (this.reviewData) {
      if (this.prevReview !== null) {
        this.reviewData.title = this.prevReview.title;
        this.reviewData.content = this.prevReview.content;
      }
    }
    this.editReview = false;
  }
}
