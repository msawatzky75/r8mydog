drop table ratings;
drop table posts;
drop table users;

create table users(
userid		integer(11)		not null,
email		varchar(100)	not null,
fname		varchar(25)		not null,
lname		varchar(25)				,
img			varchar(50)				,
passhash	varchar(255)	not null,
admin		boolean			not null,
primary key (userid)
);

create table posts(
postid		integer(11)		not null,
userid		integer(11)		not null,
title		varchar(50)		not null,
description	varchar(200)			,
img			varchar(50)				,
primary key (postid),
foreign key (userid) references users(userid)
);

create table ratings(
ratingid	integer(11)		not null,
userid		integer(11)		not null,
postid		integer(11)		not null,
title		varchar(50)		not null,
description	varchar(200)			,
img			varchar(50)				,
primary key (ratingid),
foreign key (postid) references posts(postid),
foreign key (userid) references users(userid)
);
