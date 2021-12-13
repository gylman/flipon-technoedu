import * as moment from 'moment';

export class BaseModel {
  private attributes: any = {};
  private changes: any = {};

  constructor(attr: any = null) {
    this.setAttrs(attr);
  }

  public setAttrs(attrs: any) {
    this.attributes = attrs || {};
  }

  public set(key: string, value: any) {
    this.changes[key] = value;
  }

  public get(attr: string): any {
    return this.changes[attr] ?? this.attributes[attr];
  }

  public get origin(): any {
    return this.attributes;
  }

  public get createdAt(): Date {
    return moment(this.get('createdAt')).toDate();
  }

  public get pack(): any {
    const pack = (obj: any) => {
      switch (typeof obj) {
        case 'object':
          if (Array.isArray(obj)) {
            for (const [i, value] of obj.entries()) {
              obj[i] = pack(value);
            }
          } else if (obj instanceof BaseModel) {
            return obj.get('_id');
          } else {
            for (const key of Object.keys(obj)) {
              const value = obj[key];
              if (!value) { continue; }
              if (value instanceof BaseModel) {
                obj[key] = value.get('_id');
              } else {
                obj[key] = pack(value);
              }
            }
          }
          break;
      }
      return obj;
    };

    return pack(this.changes);
  }

  public clear() {
    this.changes = {};
  }
}

export function Attr(orig?: string) {
  return (target: object, name: string) => {
    Object.defineProperty(target, name, {
      get() { return this.get(orig ?? name); },
      set(value) { this.set(orig ?? name, value); },
      enumerable: true,
      configurable: true
    });
  };
}
