import * as express from 'express';
import {findUsers} from "../controllers/user";
import {HttpError} from "../utils/http";
import {parseQuery} from "../utils/query";
const router = express.Router();

router.get('/', (req, res, next) => {
    const options = parseQuery(req);

    options.conditions.type = 'Teacher'
    options.conditions['status.isAccepted'] = true
    options.conditions['status.isAvailable'] = true

    findUsers(options)
        .then(result => {
            result.items?.forEach(value => {
                delete value.status;
            });
            res.json(result);
        })
        .catch(_ => next(new HttpError(500)));
});

export default router;
