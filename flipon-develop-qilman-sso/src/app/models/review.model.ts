import { Attr, BaseModel } from './base.model';
import {UserModel} from './user.model';

export class ReviewModel extends BaseModel {
  @Attr('_id') public id: string;
  @Attr() public title: string;
  @Attr() public content: string;
  @Attr() public writer: UserModel;
}
