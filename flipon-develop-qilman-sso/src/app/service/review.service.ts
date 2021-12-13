import { Injectable } from '@angular/core';
import { Api } from '../utils/api';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { ReviewModel } from '../models/review.model';

@Injectable({
  providedIn: 'root'
})
export class ReviewService {
  constructor(
    private api: Api
  ) {
  }

  createReview(info: any = {}): Observable<any> {
    return this.api
      .request('/reviews', 'POST', info);
  }

  updateReview(id: string, info: any = {}): Observable<any> {
    return this.api
      .request('/reviews/' + id, 'PUT', info);
  }

  getReviews(): Observable<Array<ReviewModel>> {
    return this.api.getReviews();
  }

  getReview(id: string): Observable<ReviewModel> {
    return this.api.getReview(id);
  }
}
