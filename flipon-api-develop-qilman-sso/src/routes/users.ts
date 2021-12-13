import * as express from 'express';
import {findUsers, updateUser} from "../controllers/user";
import {HttpError} from "../utils/http";
import {parseQuery} from "../utils/query";
const router = express.Router();

router.get('/', (req, res, next) => {
    const options = parseQuery(req);

    findUsers(options)
        .then(result => {
            res.json(result);
        })
        .catch(_ => next(new HttpError(500)));
});

router.put('/:id', (req, res, next) => {
    const update = req.body;
    delete update.email;
    delete update.password;
    updateUser(req.params.id, update)
        .then(() => res.status(200).send())
        .catch(err => next(err));
});

export default router;
