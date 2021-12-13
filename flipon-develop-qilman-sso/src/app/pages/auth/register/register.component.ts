import { Component, OnInit } from '@angular/core';
import { FormGroup, FormArray } from '@angular/forms';

import { UserService } from '../../../service/user.service';
import { MeForm } from '../../../forms/me.form';
import { AGREEMENT_CONTENT, PRIVACY_POLICY } from '../../../../assets/static/agreements';
import { AuthService } from '../../../service/auth.service';
import {BaseComponent} from '../../../base.component';
import * as _ from 'lodash';
import {Navigator} from '../../../utils/navigator';

export enum Type {
  teacher = '선생님',
  student = '학생',
  none = ''
}

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent extends BaseComponent implements OnInit {
  public type = Type.none;
  Type = Type;
  public form: FormGroup;
  public availableBanks = ['국민은행', '기업은행', '농협은행', '신한은행', '산업은행', '우리은행', '한국씨티은행',
    '하나은행', 'SC은행', '경남은행', '광주은행', '대구은행', '부산은행', '산림조합중앙회',
    '카카오뱅크', '케이뱅크', '전북은행', '우체국', '수협은행', '저축은행'];
  public agreementContent = AGREEMENT_CONTENT;
  public agreementCheckboxDisabled = true;
  public privacyContent = PRIVACY_POLICY;
  public privacyCheckboxDisabled = true;
  schoolCard: File;
  profilePhoto: File;
  public isDragging = false;
  public isPhoneValid = false;
  dragStartRow: number; dragStartCol: number;
  dragEndRow: number; dragEndCol: number;

  get timeSelected(): Array<string> { return this.form.get('profile')?.get('availableTime')?.value; }
  set timeSelected(value: Array<string>) { this.form.get('profile')?.get('availableTime')?.setValue(value); }

  timeSelecting: Array<string> = [];

  constructor(
    private userService: UserService,
    private authService: AuthService,
    private navigator: Navigator,
    private meForm: MeForm
  ) {
    super();
  }

  ngOnInit(): void {
    // this.userService.signInSilently();
  }

  get hiddenType(): string {
    return Object.keys(Type).find(key => Type[key] === this.type)?.charAt(0) ?? '';
  }

  changeType(type: Type) {
    this.type = type;
    this.form = this.meForm.get(this.type);
    this.timeSelected = this.form.get('profile')?.get('availableTime')?.value;
  }

  pad(i: number): string {
    return String(i).padStart(2, '0');
  }

  get subjectsArray(): FormArray {
    return this.form.get('profile')?.get('subject') as FormArray;
  }

  enableAgreementCheckbox() {
    this.agreementCheckboxDisabled = false;
  }
  enablePrivacyCheckbox() {
    this.privacyCheckboxDisabled = false;
  }

  handleSchoolCard(files: FileList) {
    if (files && files.length) {
      this.schoolCard = files.item(0)!;
    }
  }
  handleProfilePhoto(files: FileList) {
    if (files && files.length) {
      this.profilePhoto = files.item(0)!;
    }
  }

  phoneValidation() {
    this.isPhoneValid = true;
  }

  isRightClick(e) {
    if (e.which) {
      return (e.which === 3);
    } else if (e.button) {
      return (e.button === 2);
    }
    return false;
  }

  rangeMouseDown(i, j, e) {
    if (this.isRightClick(e)) {
      return false;
    } else {
      this.isDragging = true;
      this.dragStartRow = i;
      this.dragStartCol = j;
      if (typeof e.preventDefault !== 'undefined') {
        e.preventDefault();
      }
      document.documentElement.onselectstart = () => false;
    }
  }
  rangeMouseUp(i, j, e) {
    if (this.isRightClick(e)) {
      return false;
    } else {
      this.isDragging = false;
      this.dragEndRow = i;
      this.dragEndCol = j;
      this.selectFinish();
      document.documentElement.onselectstart = () => true;
    }
  }
  selectFinish() {
    const startR = this.dragStartRow > this.dragEndRow ? this.dragEndRow : this.dragStartRow;
    const endR = this.dragStartRow < this.dragEndRow ? this.dragEndRow : this.dragStartRow;
    const startC = this.dragStartCol > this.dragEndCol ? this.dragEndCol : this.dragStartCol;
    const endC = this.dragStartCol < this.dragEndCol ? this.dragEndCol : this.dragStartCol;

    for (let i = startR; i <= endR; i = i + 1) {
      for (let j = startC; j <= endC; j = j + 1) {
        const target = `${i}-${j}`;
        this.timeSelecting = _.pull(this.timeSelecting, target);
        if (_.includes(this.timeSelected, target)) {
          this.timeSelected = _.pull(this.timeSelected, target);
        } else {
          this.timeSelected = _.union(this.timeSelected, [target]);
        }
      }
    }
  }
  rangeMouseMove(i, j) {
    if (this.isDragging) {
      this.selectRange(i, j);
    }
  }
  selectRange(curRow, curCol) {
    this.clearSelecting();
    const startR = this.dragStartRow > curRow ? curRow : this.dragStartRow;
    const endR = this.dragStartRow < curRow ? curRow : this.dragStartRow;
    const startC = this.dragStartCol > curCol ? curCol : this.dragStartCol;
    const endC = this.dragStartCol < curCol ? curCol : this.dragStartCol;
    for (let i = startR; i <= endR; i = i + 1) {
      for (let j = startC; j <= endC; j = j + 1) {
        this.timeSelecting = _.union(this.timeSelecting, [`${i}-${j}`]);
      }
    }
  }
  clearSelecting() {
    if (this.isDragging) {
      for (let i = 9; i < 24; i = i + 1) {
        for (let j = 0; j < 7; j = j + 1) {
          this.timeSelecting = _.pull(this.timeSelecting, `${i}-${j}`);
        }
      }
    }
  }
  mouseUpOutside() {
    this.clearSelecting();
    this.isDragging = false;
  }

  sendSMS(countryCode: string, phone: string) {
    this.authService
      .sendSMS(`${countryCode}${phone}`)
      .subscribe();
  }

  verifySMS(code: string) {
    if (!code) { return; }
    this.authService
      .verifySMS(code, this.form)
      .subscribe();
  }

  submit() {
    console.log('dd');
    this.form.markAllAsTouched();
    console.log('is it invalid?   this.form.invalid:', this.form.invalid);
    console.log('this.form:', this.form);
    if (this.form.invalid) { return; }
    if (this.form.value.type === 'Teacher' && (!this.schoolCard || !this.profilePhoto)) { return; }

    const info = this.form.value;
    delete info.confirmPassword;
    delete info.agreement;
    delete info.privacy;

    this.authService
      .register(info, this.schoolCard, this.profilePhoto)
      .subscribe(
        () => {
          console.log('Success registering user! Going to navigator.home()...');
          this.navigator.home()
        },
        error => {
          console.log(error);
        }
      );
  }

  timeIncludes(target: Array<string>, i: number, j: number): boolean {
    return _.includes(target, `${i}-${j}`);
  }
}
