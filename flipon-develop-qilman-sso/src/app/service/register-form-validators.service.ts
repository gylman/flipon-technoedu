import { Injectable } from '@angular/core';
import { ValidatorFn, FormGroup, ValidationErrors, AbstractControl, FormControl } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class RegisterFormValidatorsService {

  constructor() { }

  formValidator(): ValidatorFn {
    return (control: FormGroup): ValidationErrors | null => {
      const errors: ValidationErrors = {};

      const password = control.get('password');
      const confirmPassword = control.get('confirmPassword');
      if (password && confirmPassword && password.value !== confirmPassword.value) {
        errors.passwordMismatch = {
          message: '비밀번호가 일치하지 않습니다.'
        }
      }

      return Object.keys(errors).length ? errors : null;
    };
  }

  // patternValidator(targetExp: RegExp): ValidatorFn {
  //   return (control: AbstractControl): ValidationErrors | null => {
  //     const match = targetExp.test(control.value);
  //     return match ? null : { wrongPattern: { message: "잘못된 입력입니다." } }
  //   };
  // }

  validateAllFormFields(formGroup: FormGroup) {
    Object.keys(formGroup.controls).forEach(field => {
      const control = formGroup.get(field);

      if (control instanceof FormControl) {
        control.markAsTouched({ onlySelf: true });
      } else if (control instanceof FormGroup) {
        this.validateAllFormFields(control);
      }
    });
  }
}
