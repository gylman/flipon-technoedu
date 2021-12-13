FROM node:14.2.0

WORKDIR /app

COPY package.json ./

RUN npm i --quiet

COPY . .

RUN npm run build:ssr

ENV PORT 80

EXPOSE 80

CMD ["npm", "run", "serve:ssr"]
