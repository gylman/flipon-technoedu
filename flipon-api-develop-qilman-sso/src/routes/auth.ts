import * as express from 'express';
import {sign, verify} from "../utils/jwt";
import * as passport from "passport";
import {createReq, validate} from "../controllers/sms";
import {HttpError} from "../utils/http";
import * as multer from "multer";
import * as AWS from 'aws-sdk';
import {createUser, findUserByEmail} from "../controllers/user";
import {uploadFile} from "../utils/upload";
import {getTechnoEduId} from '../utils/technoedu';
const router = express.Router();

const upload = multer({ storage: multer.memoryStorage() });

router.post('/signin', passport.authenticate('local', { session: false }), async (req, res, next) => {
    if (req.user)
        res.status(200).json({token: await sign(req.user.id)});
    else
        next(new HttpError(402));
});

router.post('/register', upload.fields([{ name: 'profilePhoto' }, { name: 'schoolCard' }]), async (req, res, next) => {
    console.log('/register');
    console.log(req.body);

    const profilePhoto = req.files['profilePhoto']?.[0];
    const schoolCard = req.files['schoolCard']?.[0];

    const checkBody = async () => {
        const err = new HttpError(400);
        if (req.body.type !== 'Student' && req.body.type !== 'Teacher') {throw err;}
        if (req.body.type === 'Teacher' && !(profilePhoto && schoolCard)) { throw err; }
        if (!req.body.profile) { throw err; }

        req.body.status = {};
        req.body.profile = JSON.parse(req.body.profile)
        if (req.body.payment) req.body.payment = JSON.parse(req.body.payment)
        if (req.body.want) req.body.want = JSON.parse(req.body.want);
    }

    delete req.body.auth;

    checkBody()
        .then(async () => {
            if (req.body.type === 'Student') return;
            const key = await uploadFile('profile_photo', profilePhoto);
            if (!req.body.profile) throw new HttpError(400);
            req.body.profile.image = key;
        })
        .then(async () => {
            if (req.body.type === 'Student') return;
            const key = await uploadFile('school_card', schoolCard);
            if (!req.body.profile.school) throw new HttpError(400);
            req.body.profile.school.cardImage = key;
        })
        .then(() => createUser(req.body))
        .then(() => {
            console.log('Everything done! Responding with 200... :wave:');
            res.status(200).send()
        })
        .catch(err => {
            console.log(err);
            next(err)
        });
});

router.get('/check', (req, res, next) => {
    const email = req.body.email;
    if (!email) {
        next(new HttpError(400));
        return;
    }
    findUserByEmail(email)
        .then((user) => {
            res.status(user ? 409 : 200).send();
        })
        .catch((err) => next(err));
});

router.post('/sms/send', (req, res, next) => {
    const recipient = req.body.recipient;
    if (!recipient) { // TODO: validate phone number
        next(new HttpError(400));
        return;
    }
    createReq(recipient)
        .then((v) => {
            res.status(200).json({
                id: v.id
            });
        })
        .catch((err) => next(err));
});

router.post('/sms/verify', (req, res, next) => {
    const id = req.body.id;
    const code = req.body.code;
    if (!id || !code) {
        next(new HttpError(400));
        return;
    }
    validate(id, code)
        .then((valid) => {
            if (valid) {
                res.status(200).send();
            } else {
                next(new HttpError(400));
            }
        })
        .catch((err) => next(err));
});

router.post('/technoedu_verify', (req, res, next) => {
    const token = req.body.token;
    verify(token)
        .then((decoded) => {
            res.status(200).json({
                is_valid: true,
                user_id: getTechnoEduId(decoded.id)
            });
        })
        .catch((err) => {
            res.status(200).json({
                is_valid: false,
                err: err
            });
        });
});


export default router;
