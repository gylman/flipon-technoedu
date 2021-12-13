import { Injectable } from '@angular/core';
import {FormGroup, FormBuilder, Validators, FormArray, FormControl} from '@angular/forms';

import { RegisterFormValidatorsService } from '../service/register-form-validators.service';
import {CourseSubject} from '../models/course.model';
import {filter} from 'rxjs/operators';

interface ICheckBoxItem {
  id?: string;
  selected: boolean;
  name: string;
}

@Injectable()
export class MeForm {
  private form: FormGroup;
  private timeSelected: Array<string> = [];

  constructor(
    private registerValidatorsService: RegisterFormValidatorsService,
    private fb: FormBuilder
  ) {}

  public get(type: string): FormGroup {
    this.form = this.fb.group({
      email: [null, [Validators.required, Validators.email]],
      password: [null, Validators.required],
      confirmPassword: null,
      name: [null, Validators.required],
      countryCode: ['+82', Validators.required],
      phone: [null, Validators.required],
      part: null,
      auth: this.fb.group({
        // smsId: [null, Validators.required]
        smsId: [null, []] // TODO temporarily disabled SMS verification for testing FIXME
      }),
      profile: this.fb.group({
        school: this.fb.group({
          name: [null, Validators.required],
          major: [null, Validators.required],
          // cardImage: [null, Validators.required]
        }),
        birthday: [null, Validators.required],
        introduction: [null, Validators.required],
        availableTime: [this.timeSelected, Validators.required],
        courseStyle: [null, Validators.required],
        parent: [null, Validators.required],
        subject: [null, Validators.required],
        isPublic: [true, Validators.required],
        address: this.fb.group({
          primary: [null, Validators.required],
          secondary: [null, Validators.required],
          code: [null, Validators.required]
        }),
        want: this.fb.group({
          courseStyle: [null, []],
          type: [null, []],
          subject: [null, []],
          timeInWeek: [null, []]
        }),
        hasMonitor: [null, Validators.required]
      }),
      payment: this.fb.group({
        bank: [null, Validators.required],
        num: [null, Validators.required],
        receipt: [null, []],
      }),
      agreement: [null, Validators.requiredTrue],
      privacy: [null, Validators.requiredTrue],
    }, {
      validator: this.registerValidatorsService.formValidator()
    });
    
    const profile = this.form.get('profile') as FormGroup;
    const school = profile.get('school') as FormGroup;
    const payment = this.form.get('payment') as FormGroup;

    if (type === '선생님') {
      this.form.addControl('type', new FormControl('Teacher'));
      profile.removeControl('parent');
      profile.removeControl('want');
      payment.removeControl('receipt');
    } else if (type === '학생') {
      this.form.addControl('type', new FormControl('Student'));
      school.removeControl('major');
      profile.removeControl('introduction');
      profile.removeControl('courseStyle');
      profile.removeControl('subject');
      profile.removeControl('isPublic');
      payment.removeControl('bank');
      payment.removeControl('num');
    }

    return this.form;
  }
}
