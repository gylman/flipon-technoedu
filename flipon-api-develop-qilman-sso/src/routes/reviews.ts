import * as express from 'express';
import {parseQuery} from "../utils/query";
import {HttpError} from "../utils/http";
import {createReview, findReviewById, findReviews, updateReview} from "../controllers/review";
import {AdminMiddleware} from "../middleware/admin";
import * as passport from "passport";
const router = express.Router();

router.get('/', function(req, res, next) {
    const options = parseQuery(req);

    findReviews(options)
        .then(result => {
            res.json(result);
        })
        .catch(_ => next(new HttpError(500)));
});

router.post('/', [passport.authenticate('jwt', { session: false })], (req, res, next) => {
    req.body.writer = req.user?._id;

    createReview(req.body)
        .then(() => res.status(200).send())
        .catch(err => next(err));
});

router.get('/:id', function(req, res, next) {
    findReviewById(req.params.id)
        .then(result => {
            res.json(result);
        })
        .catch(_ => next(new HttpError(500)));
});

router.put('/:id', [passport.authenticate('jwt', { session: false }), AdminMiddleware], (req, res, next) => {
    const update = req.body;

    updateReview(req.params.id, update)
        .then(() => res.status(200).send())
        .catch(err => next(err));
});

export default router;
