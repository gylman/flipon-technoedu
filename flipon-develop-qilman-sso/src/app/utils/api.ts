import {Inject, Injectable, PLATFORM_ID} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {isPlatformBrowser} from '@angular/common';
import {Observable, Observer, throwError} from 'rxjs';
import {flatMap, map} from 'rxjs/operators';
import {SignInModel} from '../models/sign-in.model';
import {environment} from '../../environments/environment';
import * as dot from 'dot-object';
import {formdata} from './form';
import {InquiryModel} from '../models/inquiry.model';
import {FormGroup} from '@angular/forms';
import {ReviewModel} from '../models/review.model';

@Injectable({
  providedIn: 'root'
})
export class Api {
  constructor(
    @Inject(PLATFORM_ID) private platformId: object,
    private http: HttpClient
  ) {
  }

  request(path: string, method: string, data?: any, baseUrl: string = environment.baseUrl): Observable<any> {
    const url = baseUrl + path;
    return new Observable<string>((observer: Observer<string>) => {
      if (!isPlatformBrowser(this.platformId)) {
        observer.error(new Error());
        return;
      }

      const token = localStorage.getItem('token');
      if (token) {
        observer.next(token);
        observer.complete();
      } else {
        observer.error(new Error());
      }
    })
      .pipe(
        flatMap((token: string) => {
          const httpOptions = {
            headers: new HttpHeaders({
              'Content-Type': 'application/json',
              Authorization: 'Bearer ' + token
            }),
            params: method === 'GET' && data ? dot.dot(data) : {}
          };

          switch (method) {
            case 'GET':
              return this.http.get(url, httpOptions);
            case 'DELETE':
              return this.http.delete(url, httpOptions);
            case 'POST':
              return this.http.post(url, data, httpOptions);
            case 'PUT':
              return this.http.put(url, data, httpOptions);
            default:
              throw throwError(method);
          }
        })
      );
  }

  signIn(email: string, password: string): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    return this.http
      .post(environment.baseUrl + '/auth/signin', {email, password}, httpOptions)
      .pipe(map((x: any) => new SignInModel(x)))
      .pipe(map(signInModel => {
        if (isPlatformBrowser(this.platformId)) {
          localStorage.setItem('token', signInModel.token);
        }
      }));
  }

  sendSMS(recipient: string): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    return this.http
      .post(environment.baseUrl + '/auth/sms/send', {recipient}, httpOptions);
  }

  verifySMS(id: string, code: string): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    return this.http
      .post(environment.baseUrl + '/auth/sms/verify', {id, code}, httpOptions);
  }

  register(info: any, schoolCard?: File, profilePhoto?: File): Observable<any> {
    const data = formdata(info);
    if (schoolCard) { data.append('schoolCard', schoolCard, schoolCard.name); }
    if (profilePhoto) { data.append('profilePhoto', profilePhoto, profilePhoto.name); }

    return this.http
      .post(environment.baseUrl + '/auth/register', data, {});
  }

  getReviews(): Observable<Array<ReviewModel>> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    return this.http
      .get(environment.baseUrl + '/reviews', httpOptions)
      .pipe(map((x: Array<any>) => {
        return x.map(v => new ReviewModel(v));
      }));
  }

  getReview(id: string): Observable<ReviewModel> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    return this.http
      .get(environment.baseUrl + '/reviews/' + id, httpOptions)
      .pipe(map((x: any) => {
        return new ReviewModel(x);
      }));
  }

  getInquiries(phone: string, password: string): Observable<Array<InquiryModel>> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        Authorization: 'Basic ' + btoa(password)
      })
    };

    return this.http
      .get(environment.baseUrl + '/inquiries/' + phone, httpOptions)
      .pipe(map((x: Array<any>) => x.map(v => new InquiryModel(v))));
  }

  createInquiry(info: any): Observable<any> {
    return this.http
      .post(environment.baseUrl + '/inquiries', formdata(info), {});
  }
}
