import * as express from 'express';
import {findUserById, updateUser} from "../controllers/user";
import {HttpError} from "../utils/http";
import {createCourse, findCourses} from "../controllers/course";
import {StudentMiddleware} from "../middleware/student";
import {NotAdminMiddleware} from "../middleware/not-admin";
const router = express.Router();

router.get('/', function(req, res, next) {
    findUserById(req.user?._id)
        .then((user) => {
            delete user?.status;
            res.status(200).json(user);
        })
        .catch(err => {
            next(new HttpError(500));
        })
});

router.put('/', NotAdminMiddleware, (req, res, next) => {
    const update = req.body;
    delete update.email;
    delete update.type;
    delete update.password;
    delete update.status;
    updateUser(req.params.id, update)
        .then(() => res.status(200).send())
        .catch(err => next(err));
});

router.get('/courses', NotAdminMiddleware, function(req, res, next) {
    const conditions: any = {};
    if (req.user?.type === 'Student') conditions.students = req.user?._id;
    if (req.user?.type === 'Teacher') conditions.teacher = req.user?._id;
    findCourses({conditions}) //TODO: Pagination
        .then(courses => {
            res.status(200).json(courses);
        })
        .catch(() => next(new HttpError(500)));
});

router.post('/courses', StudentMiddleware, function(req, res, next) {
    res.status(200).send();
    return;
    // if (!req.body.teacher) next(new HttpError(400));
    // createCourse([req.user!._id.toString()], req.body.teacher)
    //     .then(course => {
    //         res.status(200).json(course);
    //     })
    //     .catch(() => next(new HttpError(500)));
});

export default router;
