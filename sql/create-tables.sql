create table Member (
    memberID serial primary key,
    username varchar(20) not null unique,
    password varchar(128) not null,
    salt varchar(128) not null,
    admin int not null default 0,
    disabled int not null default 0
);

create table Topic (
    topicID serial primary key,
    title varchar(200) not null,
    public int not null
);

create table Post (
    postID serial primary key,
    memberID int references Member(memberID) on delete cascade,
    topicID int references Topic(topicID) on delete cascade,
    postNumber int not null,
    replyToNumber int,
    content text not null,
    timeSent int not null
);

create table MemberGroup (
    memberGroupID serial primary key,
    groupName varchar(100) not null unique
);

create table MemberInfo (
    memberID int primary key references Member(memberID) on delete cascade,
    timeRegistered int not null,
    email varchar(500),
    realName varchar(500),
    age int,
    gender int
);

create table PostRead (
    postID int references Post(postID) on delete cascade,
    memberID int references Member(memberID) on delete cascade,
    
    primary key (postID, memberID)
);

create table TopicVisible (
    topicID int references Topic(topicID) on delete cascade,
    memberGroupID int references MemberGroup(memberGroupID) on delete cascade,
    
    primary key (topicID, memberGroupID)
);

create table MemberOfGroup (
    memberID int references Member(memberID) on delete cascade,
    memberGroupID int references MemberGroup(memberGroupID) on delete cascade,
    
    primary key(memberID, memberGroupID)
);

insert into MemberGroup values (0, 'Kaikki jäsenet');
insert into Member (username, password, salt, admin) values ('admin', '9c6f98e2346f1b937ae1fab637dac7316ef87b4b8e718896ed6bb84576eb9f2d', '36d5d17640fc0336e0af2014afb23a91e4bc5032937ae1c3e8a6956aa04ec0eb', 1);
insert into MemberOfGroup values (1, 0);
insert into MemberInfo (memberID, timeRegistered) select 1, extract(epoch FROM now());