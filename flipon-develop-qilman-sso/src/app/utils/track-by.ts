import {BaseModel} from '../models/base.model';

export const trackBy = <T extends BaseModel>(index: number, item: T): number => item.get('_id');
