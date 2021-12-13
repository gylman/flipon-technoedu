import { Injectable } from '@angular/core';
import { QnaModel, QnaCategory } from '../models/qna.model';

@Injectable({
  providedIn: 'root'
})
export class QnaService {

  constructor() { }

  mockData: QnaModel[] = [
    {
      category: QnaCategory.Teacher,
      title: 'Test Title',
      question: 'Test Question',
      answer: null,
      date: new Date(),
      attachment: null,
      password: '1234',
      userName: 'user1',
      qnaId: 1
    },
    {
      category: QnaCategory.Teacher,
      title: '15자 이상 긴 제목 15자 이상 긴 제목 15자 이상 긴 제목',
      question: 'Test Question',
      answer: null,
      date: new Date(),
      attachment: null,
      password: '1234',
      userName: 'user1',
      qnaId: 2
    },
    {
      category: QnaCategory.Enroll,
      title: 'Test Title2',
      question: 'Test Question2',
      answer: {
        adminName: '민준',
        title: 'Test Response',
        content: `Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eu ullamcorper tellus, ac accumsan metus. Donec iaculis
                finibus eros non porta. Vestibulum a lacus sed metus mollis volutpat. Morbi commodo tempor est, eu lobortis ipsum blandit a. Pellentesque
                libero sem, dictum ut mollis id, tempus a tortor. Nunc hendrerit, turpis vulputate dictum tempor, lorem lacus vestibulum nunc, eget
                elementum est quam at nisi. Nam consectetur nisi eu lobortis accumsan. Fusce sit amet dictum nisi, sed auctor enim. Sed vitae ultrices dolor.
                Nam et mattis nunc. Nam cursus vestibulum venenatis. Integer sed blandit sapien,`,
        date: new Date(),
        attachment: null
      },
      date: new Date(),
      attachment: null,
      password: '1234',
      userName: 'user2',
      qnaId: 3
    }
  ];

  getQnaByCategory(category: string): QnaModel[] {
    return this.mockData.filter(qna => qna.category === category);
  }

  getQnaById(qnaId: number): QnaModel | undefined {
    return this.mockData.find(qna => qna.qnaId === qnaId);
  }
}
