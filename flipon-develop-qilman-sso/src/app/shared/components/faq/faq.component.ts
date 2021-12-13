import {Component, OnInit} from '@angular/core';
import {faq} from '../../../../assets/static/faq-contents';

@Component({
  selector: 'app-faq',
  templateUrl: './faq.component.html',
  styleUrls: ['./faq.component.scss']
})
export class FaqComponent implements OnInit {

  public faqContents = faq;
  constructor() {}

  ngOnInit(): void {
  }

}
