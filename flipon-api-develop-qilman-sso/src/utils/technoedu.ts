import axios from 'axios';
import { User } from '../models/user';
// import {TECHNOEDU_CREATE_USER_URL} from '../config';

const TECHNOEDU_CREATE_USER_URL = 'http://technoedu-php/mypage/teachrich_clone_user.php';
const TECHNOEDU_SECRET_API_KEY = 'somecryptographicallysecurerandomstring';

export function createTechnoEduUser(user: User, user_part: string) {
    let user_id = getTechnoEduId(user._id);

    let payload = {
        'user_id': user_id,
        'user_part': user_part,
        'api_key': TECHNOEDU_SECRET_API_KEY
    };

    console.log('Cloning user... Connecting to technoedu...');
    axios
        .post(TECHNOEDU_CREATE_USER_URL, payload)
        .then(res => {
            console.log('Response from: ' + TECHNOEDU_CREATE_USER_URL);
            console.log(`statusCode: ${res.status}`);
            console.log(res);
        })
        .catch(error => {
            console.error(error);
        });
    console.log('Cloning user done!');
}

/*
 * Converts TeachRich user id, which is an email, to TechnoEdu user id.
 */
export function getTechnoEduId(email: any) {
    // return email.replace('@', '_AT_');
    return email;
}
