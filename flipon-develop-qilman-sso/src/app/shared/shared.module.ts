import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, COMPOSITION_BUFFER_MODE } from '@angular/forms';
import { ClarityModule } from '@clr/angular';
import { CKEditorModule } from '@ckeditor/ckeditor5-angular';

import { FaqComponent } from './components/faq/faq.component';
import { PostingComponent } from './components/posting/posting.component';

@NgModule({
  imports: [CommonModule, ClarityModule, CKEditorModule, FormsModule],
  declarations: [FaqComponent, PostingComponent],
  exports: [CommonModule, FormsModule, ClarityModule, CKEditorModule,
    FaqComponent, PostingComponent],
  providers: [
    {
      provide: COMPOSITION_BUFFER_MODE,
      useValue: false
    },
  ],
})
export class SharedModule { }
