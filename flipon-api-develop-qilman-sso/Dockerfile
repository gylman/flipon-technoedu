FROM node:14.2.0

WORKDIR /usr/app

EXPOSE 80

ENV PORT 80
# TODO move these ENV files to config files?
ENV DB_URL 'mongodb://flipon-mongo/flipon-api'
ENV JWT_KEY 'someinsecurekey'

COPY package.json package-lock.json ./

RUN npm i --quiet

COPY . .

RUN npm install typescript pm2 -g

RUN tsc

CMD ["pm2-runtime", "./dist/bin/www.js"]
