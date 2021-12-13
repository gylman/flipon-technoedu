import * as express from 'express';
import {HttpError} from "../utils/http";

export const StudentMiddleware = (req: express.Request, res: express.Response, next: any): void => {
    if (req.user?.type !== 'Student') {
        next(new HttpError(403));
        return;
    }
    next();
};
