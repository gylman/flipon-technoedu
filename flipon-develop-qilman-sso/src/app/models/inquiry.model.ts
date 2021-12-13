import {Attr, BaseModel} from './base.model';

export class InquiryModel extends BaseModel {
  @Attr('_id') public id: string;
  @Attr() public phone: string;
  @Attr() public title: string;
  @Attr() public content: string;
  @Attr() public answer: {
    content: string;
  } | undefined;
}
