import {Attr, BaseModel} from './base.model';
import {environment} from '../../environments/environment';

export class UserModel extends BaseModel {
  @Attr('_id') public id: string;
  @Attr() public type: string;
  @Attr() public email: string;
  @Attr() public name: string;
  @Attr() public phone: string;
  @Attr() public countryCode: string;

  @Attr() public status: {
    isAccepted: boolean;
    isAvailable: boolean;
    mentorBox: string | null;
  };

  @Attr() public profile: {
    school: {
      name: string;
      major: string | undefined;
      cardImage: string | undefined;
    }

    address: {
      primary: string;
      code: string;
      secondary: string;
    }

    birthday: string;
    image: string | undefined;
    introduction: string | undefined;
    courseStyle: string | undefined;
    parent: string | undefined;
    subject: string[] | undefined;
    isPublic: boolean | undefined;
    availableTime: string[];

    want: {
      courseStyle: string;
      type: string;
      subject: string[];
      timeInWeek: string;
    };

    hasMonitor: boolean;
    hasSpace: boolean;
  };

  @Attr() public payment: {
    bank: string | undefined;
    num: string | undefined;
    receipt: string | undefined;
  };

  @Attr() public notification: [{
    action: string | undefined;
    title: string | undefined;
    content: string | undefined;
    isShown: boolean;
  }];

  isStudent(): boolean {
    return this.type === 'Student';
  }

  isTeacher(): boolean {
    return this.type === 'Teacher';
  }

  isAdmin(): boolean {
    return this.type === 'Admin' || this.type === 'Super';
  }

  get profileImage(): string {
    return environment.s3Url + this.profile.image;
  }

  get schoolCardImage(): string {
    return environment.s3Url + this.profile.school.cardImage;
  }

  get hasNewNotification(): boolean {
    return this.notification.find(v => !v.isShown) !== undefined;
  }

  get fullPhone(): string {
    return `${this.countryCode} ${this.phone}`;
  }

  get typeString(): string {
    switch (this.type) {
      case 'Student': return '학생';
      case 'Teacher': return '선생님';
      default: return '관리자';
    }
  }
}

