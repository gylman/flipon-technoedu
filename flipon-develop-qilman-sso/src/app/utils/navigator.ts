import {Inject, Injectable, PLATFORM_ID} from '@angular/core';
import { Router } from '@angular/router';
import {isPlatformBrowser} from '@angular/common';
import {environment} from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class Navigator {
  constructor(
    @Inject(PLATFORM_ID) private platformId: object,
    public router: Router
  ) {
  }

  outerLink(link: string) {
    if (isPlatformBrowser(this.platformId)) {
      window.location.href = link;
    }
  }

  navigate(path: string) {
    this.router.navigate([path]).then();
  }

  home() {
    this.router.navigate(['/']).then();
  }

  intro() {
    this.router.navigate(['/intro']).then();
  }

  register() {
    this.router.navigate(['/auth/register']).then();
  }

  signIn() {
    this.router.navigate(['/auth/signin']).then();
  }

  admin() {
    this.router.navigate(['/admin']).then().catch(err => console.log(err));
  }

  adminCourses() {
    this.router.navigate(['/admin/courses']).then().catch(err => console.log(err));
  }

  adminRequests() {
    this.router.navigate(['/admin/requests']).then().catch(err => console.log(err));
  }

  adminUsers() {
    this.router.navigate(['/admin/users']).then().catch(err => console.log(err));
  }

  me() {
    this.router.navigate(['/me']).then();
  }

  courses() {
    this.router.navigate(['/me/courses']).then();
  }

  profile() {
    this.router.navigate(['/me/profile']).then();
  }

  password() {
    this.router.navigate(['/me/password']).then();
  }

  teachers() {
    this.router.navigate(['/teachers']).then();
  }

  externMentorBox() {
    this.router.navigate(['/extern/mentorbox']).then();
  }

  qna() {
    this.router.navigate(['/qna']).then();
  }

  review() {
    this.router.navigate(['/review']).then();
  }

  conference() {
    window.open(environment.technoeduConferenceRedirUrl, '_blank');
  }
}
