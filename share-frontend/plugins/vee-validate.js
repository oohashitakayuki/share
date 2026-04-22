import Vue from 'vue'
import { ValidationProvider, ValidationObserver, extend, localize } from 'vee-validate'
import * as originalRules from 'vee-validate/dist/rules'

let rule;
for (rule in originalRules) {
  extend(rule, {
    ...originalRules[rule],
  });
}

const ja = {
  "code": "ja",
  "messages": {
    "email": "{_field_}は「ユーザー名@ドメイン」形式で入力してください。",
    "max": "{_field_}は{length}文字以内で入力してください。",
    "min": "{_field_}は{length}文字以上で入力してください。",
    "required": "{_field_}を入力してください。",
  }
}

localize('ja', ja)

Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)