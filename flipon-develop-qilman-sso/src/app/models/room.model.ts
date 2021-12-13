import {Attr, BaseModel} from './base.model';

export class RoomModel extends BaseModel {
  @Attr() public number: number;
}
