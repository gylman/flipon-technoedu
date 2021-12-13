import { Component, OnInit } from '@angular/core';
import { ReviewService } from '../../../service/review.service';
import { ReviewModel } from '../../../models/review.model';
import { Router, ActivatedRoute } from '@angular/router';
import { POSTDATA } from '../../../shared/components/posting/posting.component';
import { Observable, of } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { MeService } from '../../../service/me.service';

@Component({
  selector: 'app-review-list',
  templateUrl: './review-list.component.html',
  styleUrls: ['./review-list.component.scss'],
})
export class ReviewListComponent implements OnInit {

  page = 1;
  reviews$: Observable<ReviewModel[]>;
  postReview = false;
  postData: POSTDATA;
  password: string;

  constructor(
    private reviewService: ReviewService,
    private router: Router,
    private route: ActivatedRoute,
    private meService: MeService) { }

  ngOnInit(): void {
    this.reviews$ = this.reviewService.getReviews();
    if (!this.meService.me) {
      this.meService
        .getMe()
        .pipe(catchError(err => of(null)));
    }
  }

  moveDetail(reviewId: number) {
    this.router.navigate([reviewId], { relativeTo: this.route });
  }

  startReviewPosting() {
    this.postData = {
      title: '',
      content: '',
      attachment: null
    };
    this.postReview = true;
  }
  onSubmit = (dataFromPosting: POSTDATA) => {
    const newReviewData = {
      ...dataFromPosting,
      writer: this.meService.me
    };
    this.reviewService.createReview(newReviewData);
    this.postReview = false;
  }
  onCancel = () => {
    this.postReview = false;
  }
  get myId(): string {
    if (this.meService.me) {
      return this.meService.me.id;
    }
    return '';
  }
}

