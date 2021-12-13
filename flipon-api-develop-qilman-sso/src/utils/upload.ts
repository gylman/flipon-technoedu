import * as AWS from 'aws-sdk';
import * as crypto from 'crypto';
import {IS_PRODUCTION} from "../config";

export const uploadFile = async (folder: string, file: Express.Multer.File) => {
    const s3 = new AWS.S3();
    const filename = `${Date.now().toString(16)}.${crypto.createHash('md5').update(file.buffer).digest('hex')}.${file.mimetype.split('/')[1]}`;
    const key = `${folder}/${filename}`;

    const params = {
        Bucket: IS_PRODUCTION ? 'flipon' : 'flipon-dev',
        Key: key,
        Body: file.buffer,
        ACL: 'public-read',
        ContentEncoding: 'base64',
        ContentType: file.mimetype
    };

    await s3.upload(params).promise();

    return key;
};
