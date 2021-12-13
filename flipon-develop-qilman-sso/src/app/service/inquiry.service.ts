import {Injectable} from '@angular/core';
import {Api} from '../utils/api';
import {Observable} from 'rxjs';
import {InquiryModel} from '../models/inquiry.model';

@Injectable({
  providedIn: 'root'
})
export class InquiryService {
  constructor(
    private api: Api
  ) {
  }

  getInquiries(phone: string, password: string): Observable<Array<InquiryModel>> {
    return this.api.getInquiries(phone, password);
  }

  createInquiry(info: any = {}): Observable<any> {
    return this.api.createInquiry(info);
  }
}
