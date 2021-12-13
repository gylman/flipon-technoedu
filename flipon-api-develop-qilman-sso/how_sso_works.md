TODO fix the discrepancies in URLs, variable names, etc below

# Steps for `teachrich_redir.php`

1. teachrich.io Frontend
2. Get teachrich.io API response (has token)
3. Redir to https://technoedu.co.kr/mypage/teachrich_redir.php?token=<token>
4. Get teachrich.io API response
    Response contains:
    - token validation
    - username
    `TEACHRICH_API_URL = 'https://teachrich.io/api'`
    URL: `TEACHRICH_API + /auth/technoedu_verify`
    Request: `{ 'token': <token> }`
    Response: `{ 'is_valid': boolean, 'username': string }`
5. Mimic login.php behavior of setting `$_SESSION` variables
6. Redirect back to teachrich.io
    `TEACHRICH_REDIR_URL = 'https://teachrich.io/'`

# Steps for teachrich.io Frontend

1. On <login> click, Get teachrich.io/api/login response (has token)
2. If successful, redirect to technoedu.co.kr
    TECHNOEDU_REDIR_URL = 'https://technoedu.co.kr/mypage/teachrich_redir.php'
    URL: TECHNOEDU_REDIR_URL + '?token=' + token + '&r=' + redir_back_path
3. Done

# Steps for teachrich.io API

1. Verify username/password at /api/login
2. If successful, generate a token {
        'token': random string,
        'username': username,
        'expiry': 7 days from now
    }
    and store in MongoDB collection (technoedu_tokens) as a new document

3. Include token in response of /api/login


1. Verify token at /api/technoedu_verify by cross-checking MongoDB
    and check it didn't expire yet.
    Request: { 'token': <token> }
    Response: { 'is_valid': boolean, 'username': string }






# DEPLOYING TO DEV SERVER (technoedu.co.kr)

Build and deploy `flipon-develop` Angular app using:

    # Building
    pushd flipon-develop
    ng serve --base-href /teachrich-frontend  # builds Angular with given base
    popd

    # Deploying
    cp dist/flipon /var/www/teachrich-frontend

Accessible via: https://technoedu.co.kr/teachrich-frontend

--

Build and deploy `flipon-api-develop` Dockerfile using:

    pushd flipon-api-develop
    docker build -t flipon-api .
    docker image ls
    docker run -p 80:9914 flipon-api[:latest]
    popd

Accessible via: https://technoedu.co.kr:9914/

--

Build `var/www` by just pulling from GitHub:

    pushd var/www
    git push
    popd

Accessible via: https://technoedu.co.kr/


VIM VIM VIM VIM VIM:

    apt update > /dev/null && apt install -y vim > /dev/null

DOCKER:

Note: I'm running a Docker registry locally at localhost:5000.

    [ /var ]
    
    # Build
    docker image rm localhost:5000/technoedu-php; \
        docker build -t localhost:5000/technoedu-php .
    
    # Deploy
    docker container rm technoedu-php; \
        docker run \
            --name technoedu-php \
            --net technoedu \
            -p 3000:80 \
            -it localhost:5000/technoedu-php

    [ /docker/mysql ]
    
    # Build
    docker image rm localhost:5000/technoedu-mysql; \
        docker build -t localhost:5000/technoedu-mysql .
    
    # Deploy
    docker container rm technoedu-mysql; \
        docker run \
            --name technoedu-mysql \
            --net technoedu \
            -p 3306:3306 \
            -it localhost:5000/technoedu-mysql

    [ /flipon-api-develop ]

    # Build
    docker image rm localhost:5000/flipon-api; \
        docker build -t localhost:5000/flipon-api .

    # Deploy
    docker container rm flipon-api; \
        docker run \
            --name flipon-api \
            --net flipon \
            -p 4100:80 \
            -it localhost:5000/flipon-api

    [ /flipon-develop ]

    # Build
    docker image rm localhost:5000/flipon-frontend; \
        docker build -t localhost:5000/flipon-frontend .

    # Deploy
    docker container rm flipon-frontend; \
        docker run \
            --name flipon-frontend \
            --net flipon \
            -p 4000:80 \
            -it localhost:5000/flipon-frontend

    [ /docker/mongo ]

    # Build
    docker image rm localhost:5000/flipon-mongo; \
        docker build -t localhost:5000/flipon-mongo .

    # Deploy
    docker container rm flipon-mongo; \
        docker run \
            --name flipon-mongo \
            --net flipon \
            -p 27017:27017 \
            -it localhost:5000/flipon-mongo
