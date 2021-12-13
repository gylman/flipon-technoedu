import * as express from 'express';
import {HttpError} from "../utils/http";
import {createCourse, findCourses, updateCourse} from "../controllers/course";
import {parseQuery} from "../utils/query";
const router = express.Router();

router.get('/', (req, res, next) => {
    const options = parseQuery(req);

    findCourses(options)
        .then(result => {
            res.json(result);
        })
        .catch((err) => next(new HttpError(500, err)));
});

router.post('/', (req, res, next) => {
    createCourse(req.body)
        .then(course => {
            res.status(200).json(course);
        })
        .catch((err) => next(new HttpError(500, err)));
});

router.put('/:id', (req, res, next) => {
    const update = req.body;
    updateCourse(req.params.id, update)
        .then(() => res.status(200).send())
        .catch((err) => next(new HttpError(500, err)));
});

export default router;
