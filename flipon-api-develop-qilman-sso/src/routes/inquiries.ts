import * as express from 'express';
import {parseQuery} from "../utils/query";
import {HttpError} from "../utils/http";
import {createInquiry, findInquiries, updateInquiry} from "../controllers/inquiry";
import * as multer from "multer";
const router = express.Router();

const upload = multer({ storage: multer.memoryStorage() });

router.get('/', function(req, res, next) {
    const options = parseQuery(req);

    findInquiries(options)
        .then(result => {
            res.json(result);
        })
        .catch(_ => next(new HttpError(500)));
});

router.get('/:phone', function(req, res, next) {
    const auth = req.header('Authorization')?.split(' ')[1];
    if (!auth) { return next(new HttpError(401)); }

    const password = Buffer.from(auth, 'base64').toString()

    findInquiries({
        phone: req.params.phone,
        password
    })
        .then(result => {
            res.json(result);
        })
        .catch(_ => next(new HttpError(500)));
});

router.post('/', upload.single('photos'), (req, res, next) => {
    createInquiry(req.body)
        .then(() => res.status(200).send())
        .catch(err => next(err));
});

router.put('/:id', (req, res, next) => {
    const update = req.body;

    updateInquiry(req.params.id, update)
        .then(() => res.status(200).send())
        .catch(err => next(err));
});

export default router;
