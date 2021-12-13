import {Attr, BaseModel} from './base.model';

export class SignInModel extends BaseModel {
  @Attr() public token: string;
}
