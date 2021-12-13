import * as express from 'express';
import * as passport from "passport";
import authRouter from './auth';
import meRouter from './me';
import usersRouter from './users';
import coursesRouter from './courses';
import teachersRouter from './teachers';
import inquiriesRouter from './inquiries';
import reviewsRouter from './reviews';
import {HttpError} from "../utils/http";
import {assignRoom} from "../controllers/room";
import {AdminMiddleware} from "../middleware/admin";
import {StudentMiddleware} from "../middleware/student";
import {NotAdminMiddleware} from "../middleware/not-admin";

const router = express.Router();

router.get('/', async (req, res) => {
  res.status(200).send();
})

router.get('/health', async (req, res) => {
  res.status(200).send();
})

router.get('/test', async (req, res) => {
  res.status(200).json(await assignRoom());
})

router.use('/auth', authRouter);
router.use('/me', passport.authenticate('jwt', { session: false }), meRouter);
router.use('/users', [passport.authenticate('jwt', { session: false }), AdminMiddleware], usersRouter);
router.use('/courses', [passport.authenticate('jwt', { session: false }), AdminMiddleware], coursesRouter);
router.use('/teachers', [passport.authenticate('jwt', { session: false }), StudentMiddleware], teachersRouter);
router.use('/inquiries', inquiriesRouter);
router.use('/reviews', reviewsRouter);

router.all('*', (req, res, next) => {
  next(new HttpError(404));
});

export default router;
