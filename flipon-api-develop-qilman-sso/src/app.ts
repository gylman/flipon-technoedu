import * as mongoose from "mongoose";
mongoose.set('runValidators', true);
mongoose.plugin((schema, options) => {
    // schema.options.strict = 'throw';
    schema.post('validate', (err, doc, next) => {
        return next(new HttpError(400, err));
    });
})

import * as express from 'express';
import * as cookieParser from 'cookie-parser';
import * as cors from 'cors';
import * as path from 'path';
import * as logger from 'morgan';
import * as sentry from '@sentry/node';
import {IS_PRODUCTION} from "./config";
import * as passport from "passport";
import {Strategy as LocalStrategy} from "passport-local";
import {ExtractJwt, Strategy as JwtStrategy} from "passport-jwt";
import {findUserByCredentials, findUserById} from "./controllers/user";

import indexRouter from "./routes";
import {HttpError} from "./utils/http";
import * as AWS from "aws-sdk";
import {Error} from "mongoose";

AWS.config.update({
    accessKeyId: process.env.AWS_ACCESS_KEY_ID,
    secretAccessKey: process.env.AWS_SECRET_ACCESS_KEY
});

const app = express();

sentry.init({ dsn: IS_PRODUCTION ? 'https://43452fe166234ee1b8e9365cf3dffa57@sentry.io/1503634' : 'https://3b26b9476e354139b5d3789187c0615c@sentry.io/1503628' });
app.use(sentry.Handlers.requestHandler());

app.use(cors());
app.options('*', cors());

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

mongoose.connect(process.env.DB_URL ?? '', {
    useNewUrlParser: true
}).then(() => {
});

app.use(passport.initialize());

const jwtOptions = {
    jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_KEY ?? '',
    passReqToCallback: true
};

passport.use(new LocalStrategy({
    passwordField: 'password',
    usernameField: 'email'
}, (email, password, done): void => {
    findUserByCredentials(email, password)
        .then((user) => {
            if (user === undefined) {
                done(false, null);
            } else {
                done(null, user);
            }
        })
        .catch((err) => {
            done(err, null);
        });
}));

passport.use(new JwtStrategy(jwtOptions, (req, payload, done): void => {
    findUserById(payload.id)
        .then((user) => {
            if (!user) {
                done(false, null);
            } else {
                req.user = user;
                done(null, user);
            }
        })
        .catch((err) => {
            done(err, null);
        });
}));

app.use('/', indexRouter);

app.use(sentry.Handlers.errorHandler());

app.use((err: Error, req, res, next) => {
    let status;
    let message;
    if (err instanceof HttpError) {
        status = err.status;
        message = err.raw?.message
    }
    res.status(status ?? 500).send(message ?? '');
});

process.on('SIGINT', () => {
    mongoose.connection
        .close()
        .then(() => {
            process.exit(0);
        });
});

export default app;
