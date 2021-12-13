// This file can be replaced during build by using the `fileReplacements` array.
// `ng build --prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

export const environment = {
  production: false,
  baseUrl: 'http://localhost:4100',
  s3Url: 'https://flipon-dev.s3.ap-northeast-2.amazonaws.com/',
  technoeduRedirUrl: 'http://localhost:3000/mypage/teachrich_redir.php',
  technoeduLogoutRedirUrl: 'http://localhost:3000/mypage/teachrich_logout_redir.php',
  technoeduConferenceRedirUrl: 'http://localhost:3000/mypage/teachrich_conference_redir.php'
};

/*
 * For easier debugging in development mode, you can import the following file
 * to ignore zone related error stack frames such as `zone.run`, `zoneDelegate.invokeTask`.
 *
 * This import should be commented out in production mode because it will have a negative impact
 * on performance if an error is thrown.
 */
// import 'zone.js/dist/zone-error';  // Included with Angular CLI.
