import { Component, OnInit, Input, PLATFORM_ID, Inject } from '@angular/core';
import { isPlatformBrowser, isPlatformServer } from '@angular/common';

export interface POSTDATA {
  title: string;
  content: string;
  attachment: File | null;
}

@Component({
  selector: 'app-posting',
  templateUrl: './posting.component.html',
  styleUrls: ['./posting.component.scss']
})
export class PostingComponent implements OnInit {

  @Input() postData: POSTDATA;
  @Input() onSubmit: (dataFromPosting: POSTDATA) => void;
  @Input() onCancel: () => void;
  @Input() submitText: string;
  @Input() cancelText: string;
  @Input() disableCondition: boolean;
  public Editor;
  public isBrowser = false;
  public config = {
    placeholder: '내용을 입력해주세요'
  };

  constructor(
    @Inject(PLATFORM_ID) private platformId: object
  ) {
    if (isPlatformBrowser(this.platformId)) {
      const ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
      this.Editor = ClassicEditor;
      this.isBrowser = true;
    } else if (isPlatformServer(this.platformId)) {
      // console.log('NONONONONONONONONONONONONONONONONONONONONONONONONONO');
      this.isBrowser = false;
    }
  }

  ngOnInit(): void {
  }

  handleAttachment(files: FileList) {
    if (files && files.length) {
      this.postData.attachment = files.item(0);
    }
  }

}
