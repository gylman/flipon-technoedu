import {MsgStatus, SMSModel} from '../models/sms';
import {randomBytes} from "crypto";
import {HttpError} from "../utils/http";

const accountSid = 'AC3afd5b3943310ce17788a843edce3031';

const MSG_BODY = (code: string) => {
    return `인증번호는 [${code}]입니다.`;
};

interface CreatedSMS {
    code: string;
    id: string;
}

/**
 * @description 6자리 랜덤 코드를 생성
 */
export function createCode(): string {
    const buffer = randomBytes(6);
    let ret = '';
    for (let i = 0; i < 6; i++) {
        ret += Math.floor(Number(buffer[i]) / 25.6).toString();
    }
    return ret;
}

export async function createReq(recipient: string): Promise<CreatedSMS> {
    const code = createCode();
    const model = await (
        new SMSModel({
            authCode: code
        }).save()
    );
    await send(recipient, code);
    model.status = MsgStatus.Sent;
    await model.save();
    return {
        code,
        id: model._id
    };
}

/**
 * @description 사용자가 입력한 SMS 코드에 대해서 맞는지 검증
 * @param id SMS 인증 ID
 * @param code 입력으로 주어진 코드
 */
export async function validate(id: string, code: string): Promise<boolean> {
    const item = await SMSModel.findById(id);
    if (item === null || item.status !== MsgStatus.Sent) {
        return false;
    }
    if (item.authCode !== code) {
        return false;
    }

    // Code correct
    item.status = MsgStatus.Authorized;
    await item.save();
    return true;
}

/**
 * @description 확인된 SMS 인증을 사용, 즉 만료처리 함
 * @param id 사용할 SMS 인증 ID
 */
export async function useForAuth(id: string): Promise<boolean> {
    const item = await SMSModel.findById(id);
    if (item === null || item.status !== MsgStatus.Authorized) {
        return false;
    }
    item.status = MsgStatus.Used;
    await item.save();
    return true;
}

/**
 * @description 인증 코드를 SMS로 전송
 * @param recipient 수신자 전화번호
 * @param code 인증코드 (6자리 숫자))
 * @returns 성공 여부
 */
export async function send(recipient: string, code: string) {
    const API_KEY = process.env.TWILIO_KEY;
    const SMS_SENDER = process.env.SMS_SENDER;
    const body = MSG_BODY(code);

    const client = require('twilio')(accountSid, API_KEY);

    await client.messages
        .create({
            body: body,
            from: SMS_SENDER,
            to: recipient
        })
        .catch((err) => { throw new HttpError(500, err.message) });

    // const response = await axios.post(`https://api-sms.cloud.toast.com/sms/v2.1/appKeys/${API_KEY}/sender/sms`, {
    //   body,
    //   recipientList: [
    //     { recipientNo: recipient }
    //   ],
    //   sendNo: SMS_SENDER
    // });
    // if (response.status !== 200 || response.data.isSuccessful !== true) {
    //   return false;
    // } else {
    //   return true;
    // }

    return true;
}
