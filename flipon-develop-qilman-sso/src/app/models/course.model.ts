import {Attr, BaseModel} from './base.model';
import {RoomModel} from './room.model';
import {UserModel} from './user.model';

export enum CourseStatus {
  Cancelled = 'CANCELLED',
  Requested = 'REQUESTED',
  Active = 'ACTIVE',
  Terminated = 'TERMINATED'
}

export enum CourseSubject {
  MATH = '수학',
  ENGLISH = '영어',
}

export class CourseModel extends BaseModel {
  @Attr('_id') public id: string;
  @Attr() public name: string;
  @Attr() public subject: string;
  @Attr() public students: Array<UserModel>;
  @Attr() public teacher: UserModel;
  @Attr() public room: RoomModel;
  @Attr() public status: CourseStatus;

  get studentsName(): string {
    return (this.students ?? []).map(v => v.name).join(', ');
  }
}
