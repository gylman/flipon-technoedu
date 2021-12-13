import {Injectable} from '@angular/core';
import {Api} from '../utils/api';
import {Observable} from 'rxjs';
import {FormGroup} from '@angular/forms';
import {map} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  constructor(
    private api: Api
  ) {
  }

  smsId: string;

  signIn(email: string, password: string): Observable<any> {
    return this.api.signIn(email, password);
  }

  register(info: any, schoolCard?: File, profilePhoto?: File): Observable<any> {
    return this.api.register(info, schoolCard, profilePhoto);
  }

  sendSMS(recipient: string): Observable<{id: string}> {
    return this.api
      .sendSMS(recipient)
      .pipe(map(result => this.smsId = result.id));
  }

  verifySMS(code: string, form: FormGroup): Observable<any> {
    return this.api
      .verifySMS(this.smsId, code)
      .pipe(map(() => form.get('auth')?.get('smsId')?.setValue(this.smsId)));
  }
}
