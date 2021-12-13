import { Component, OnInit } from '@angular/core';
import { QnaService } from '../../../service/qna.service';
import { Router, ActivatedRoute } from '@angular/router';
import { QnaModel } from '../../../models/qna.model';
import { POSTDATA } from '../../../shared/components/posting/posting.component';

@Component({
  selector: 'app-qna-detail',
  templateUrl: './qna-detail.component.html',
  styleUrls: ['./qna-detail.component.scss']
})
export class QnaDetailComponent implements OnInit {

  qnaData: QnaModel | undefined;
  public editAnswer = false;
  private prevAnswer: {
    title: string;
    content: string;
    attachment: File | null;
    date: Date;
    adminName: string;
  } | null;
  public postData: POSTDATA = {
    title: '',
    content: '',
    attachment: null
  };

  constructor(
    private qnaService: QnaService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit(): void {
    const id = parseInt(this.route.snapshot.paramMap.get('id') ?? '', 10);
    this.qnaData = this.qnaService.getQnaById(id);
  }

  goback = () => {
    this.router.navigate(['../'], { relativeTo: this.route.parent });
  }
  startEditAnswer() {
    if (this.qnaData) {
      if (!this.qnaData.answer) {
        this.qnaData.answer = {
          adminName: '',
          title: '',
          content: '',
          date: new Date(),
          attachment: null
        };
      } else {
        this.prevAnswer = { ...this.qnaData.answer };
      }
      this.postData = this.qnaData.answer;
    }
    this.editAnswer = true;
  }

  onSubmit = (dataFromPosting: POSTDATA) => {
    if (this.qnaData && this.qnaData.answer) {
      this.qnaData.answer = {
        ...dataFromPosting,
        date: new Date(),
        adminName: '관리자'
      };
    }
    console.log(this.qnaData);
    // TODO: redirect to previous page.
    this.editAnswer = false;
  }
  onCancel = () => {
    if (this.qnaData) {
      this.qnaData.answer = null;
      if (this.prevAnswer !== null) {
        this.qnaData.answer = this.prevAnswer;
      }
    }
    this.editAnswer = false;
  }
}
