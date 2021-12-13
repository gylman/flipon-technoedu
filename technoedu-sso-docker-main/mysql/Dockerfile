# FROM --platform=linux/amd64 mysql:5.7.30
FROM mysql:5.7.30

ENV MYSQL_ROOT_PASSWORD ""
ENV MYSQL_DATABASE "facelink"
ENV MYSQL_USER "mentorservice"
ENV MYSQL_PASSWORD "roskfl"
ENV MYSQL_ALLOW_EMPTY_PASSWORD "yes"
COPY facelink.sql /docker-entrypoint-initdb.d
