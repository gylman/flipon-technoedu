import { Component, OnInit } from '@angular/core';
import {Navigator} from '../../../utils/navigator';
import {AuthService} from '../../../service/auth.service';
import {ActivatedRoute} from '@angular/router';
import {MeService} from '../../../service/me.service';
import {environment} from '../../../../environments/environment';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss']
})
export class SigninComponent implements OnInit {

  constructor(
    public navigator: Navigator,
    private activatedRoute: ActivatedRoute,
    private authService: AuthService,
    private meService: MeService
  ) { }

  email = '';
  password = '';

  fail = false;

  ngOnInit(): void {
    this.meService
      .getMe()
      .subscribe(
        () => this.onSuccess(),
        () => {}
      );
  }

  signIn(): void {
    if (!this.validate()) { return; }
    this.authService.signIn(this.email, this.password)
      .subscribe(
        value => {
          this.fail = false;
          this.onSuccess();
        },
        error => { this.fail = true; }
      );
  }

  onSuccess(): void {
    // Redirect to TechnoEdu to sign in there as well
    const queryParamMap = this.activatedRoute.snapshot.queryParamMap;
    const r = queryParamMap.get('r') ?? '';
    const token = localStorage.getItem('token') ?? '';
    window.location.href = environment.technoeduRedirUrl
      + `?token=${token}&r=${r}`;
    
    // if (queryParamMap.has('r')) {
    //   this.navigator.navigate(queryParamMap.get('r') ?? '');
    // } else { this.navigator.home(); }
  }

  validate(): boolean {
    if (!this.email) { return false; }
    if (!this.password) { return false; }
    return true;
  }
}
