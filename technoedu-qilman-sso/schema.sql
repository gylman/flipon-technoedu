-- General
CREATE USER 'mentorservice'@'localhost' IDENTIFIED BY 'roskfl';
CREATE DATABASE facelink;

-- Tables
USE facelink;
CREATE TABLE board_faq (
    user_id INT AUTO_INCREMENT,
    title VARCHAR(255),
    content VARCHAR(10000),
    reg_datetime DATETIME,
    hits INT DEFAULT 0
);
CREATE TABLE board_notice (
    user_id,
    title,
    content,
    reg_datetime
);
CREATE TABLE board_qna (
    title,
    content,
    user_name,
    phone,
    email,
    reg_datetime
);
CREATE TABLE user_friend (
    user_id,
    friend_id
);
CREATE TABLE user_group (
    user_id,
    group_name    
);
CREATE TABLE group_friend (
    group_id,
    friend_id
);
CREATE TABLE room_member (
    room_id,
    user_id
);
CREATE TABLE user_note (
    to_user_id,
    from_user_id,
    message,
    reg_datetime
);
CREATE TABLE user_basic (
    id,
    pw,
    name,
    email,
    allow_mailing,
    phone,
    birthday,
    sex,
    part,
    depart,
    reg_datetime
);
CREATE TABLE room_list (
    user_id,
    start_datetime,
    end_datetime,
    max_member,
    title,
    pw,
    layout_type,
    resolution,
    record,
    invite_msg,
    mcu_id,
    reg_datetime
);
CREATE TABLE guest_user (
    userID,
    userPW,
    userNAME,
    created
);
CREATE TABLE emailCheck (
    id,
    email,
    created
);
