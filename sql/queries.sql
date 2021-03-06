/*
 * LISTAA JULKISET KETJUT (Vieras, ei tietoa lukemattomista viesteistä)
 */

select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count
from        topic, post, member, (
                select topicid, count(*)
                from post
                group by topicid
            ) as count
where       topic.topicid=post.topicid
    and     member.memberid=post.memberid
    and     topic.topicid=count.topicid
    and     post.timesent=(
                select max(post.timesent)
                from post
                where post.topicid=topic.topicid
            )
    and     topic.public=1
order by    post.timesent desc;



/*
 * LUKEMATIEN VIESTIEN LKM TOPICISSA
 */

select distinct post.topicid, newcount.newcount
from post
left join (
    select topicid, count(*) as newcount
    from post
    where postid not in (
        select postid
        from postread
        where memberid=?
    )
    group by topicid
) as newcount
on post.topicid=newcount.topicid



/*
 * LISTAA JULKISET KETJUT (Jäsen, sisältää kyselyn lukemattomille viesteille)
 */
 
select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count, newcount.newcount
from        topic, post, member, (
                select topicid, count(*)
                from post
                group by topicid
            ) as count, (
                select post.topicid, newcount.newcount
                from post
                left join (
                    select topicid, count(*) as newcount
                    from post
                    where postid not in (
                        select postid
                        from postread
                        where memberid=?
                    )
                    group by topicid
                ) as newcount
                on post.topicid=newcount.topicid
            ) as newcount
where       topic.topicid=post.topicid
    and     member.memberid=post.memberid
    and     topic.topicid=count.topicid
    and     topic.topicid=newcount.topicid
    and     post.timesent=(
                select max(post.timesent)
                from post
                where post.topicid=topic.topicid
            )
    and     topic.public=1
order by    post.timesent desc;




/*
 * LISTAA SISÄISET KETJUT
 */

select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count, newcount.newcount
from        topic, post, member, (
                select topicid, count(*)
                from post
                group by topicid
            ) as count, (
                select distinct post.topicid, newcount.newcount
                from post
                left join (
                    select topicid, count(*) as newcount
                    from post
                    where postid not in (
                        select postid
                        from postread
                        where memberid=?
                    )
                    group by topicid
                ) as newcount
                on post.topicid=newcount.topicid
            ) as newcount
where       topic.topicid=post.topicid
    and     member.memberid=post.memberid
    and     topic.topicid=count.topicid
    and     topic.topicid=newcount.topicid
    and     post.timesent=(
                select max(post.timesent)
                from post
                where post.topicid=topic.topicid
            )
    and     (
                topic.topicid in (
                    select topicid
                    from topicvisible
                    where membergroupid in (
                        select membergroupid
                        from memberofgroup
                        where memberid=?
                    )
                )
                or
                ? in (
                    select memberid
                    from member
                    where admin=1
                )
            )
    and     topic.public=0
order by    post.timesent desc;



/*
 * HAE KÄYTTÄJÄN TIEDOT
 */

select      member.username, member.memberid, memberinfo.timeregistered, memberinfo.email, memberinfo.realname, memberinfo.age, memberinfo.gender, postcount.postcount
from        member, memberinfo, (
                select member.memberid, postcount.postcount
                from member
                left join (
                    select memberid, count(*) as postcount
                    from post
                    group by memberid
                ) as postcount
                on member.memberid=postcount.memberid
                where member.memberid=?
            ) as postcount
where       member.memberid=?
    and     member.memberid=memberinfo.memberid
    and     member.memberid=postcount.memberid;
 

 
 
/*
 * HAE VIESTIKETJUN VIESTIT
 */
 
select      post.postid, post.memberid, post.topicid, post.content, post.timesent, member.username, read.read
from        post
inner join  member
    on      post.memberid=member.memberid
left join   (
                select postid, 1 as read
                from postread
                where memberid=?
            ) as read
    on      post.postid=read.postid
where       post.topicid=?
order by    post.postnumber asc;
   

   
/*
 * HAE KETJUT, JOIHIN KÄYTTÄJÄLLÄ ON OIKEUS
 */
select      topicid
from        topic
where       topicid in (
                select topic.topicid
                from topic, topicvisible, memberofgroup
                where topic.topicid=topicvisible.topicid
                    and topicvisible.membergroupid=memberofgroup.membergroupid
                    and memberid=?
            )
    or      public=1
    or      ? in (
                select memberid
                from member
                where admin=1
            );



/*
 * MERKITSE VIESTIT LUETUKSI
 */

insert into postread
    select  postid, ? as memberid
    from    post
    where   topicid=?
        and     postid not in (
                    select postid
                    from postread
                    where memberid=?
                );

 

 
/*
 * LUO UUSI VIESTI
 */

insert into post (memberid, topicid, postnumber, replytonumber, content, timesent)
    select ?, ?, max(postnumber) + 1, ?, ?, ?
    from post
    where topicid=?;



/*
 * HAE KÄYTTÄJÄN RYHMÄT
 */

select      membergroup.membergroupid, membergroup.groupname
from        membergroup, memberofgroup
where       membergroup.membergroupid=memberofgroup.membergroupid
    and     memberid=?;


/*
 * POISTA TYHJÄT VIESTIKETJUT
 */

delete from topic
where topicid in (
    select topicid
    from (
        select topic.topicid, coalesce(postcount, 0) as postcount
        from topic
        left join (
            select topicid, count(*) as postcount
            from post
            group by topicid
        ) as postcount
        on topic.topicid=postcount.topicid
    ) as topicpostcount
    where postcount=0
);

/*
 * HAE JÄSENRYHMIEN JÄSENMÄÄRÄT
 */
 
select membergroup.groupname, membergroup.membergroupid, membercount.membercount
from membergroup
left join (
    select count(membergroupid) as membercount, membergroupid
    from memberofgroup
    group by membergroupid
) as membercount
on membergroup.membergroupid=membercount.membergroupid
order by membergroup.membergroupid asc;



/*
 * HAE KÄYTTÄJÄN RYHMÄT JA NIIDEN JÄSENMÄÄRÄT
 */
 
 
select      membergroup.membergroupid, membergroup.groupname, membercount.membercount
from        membergroup
inner join  memberofgroup
    on      membergroup.membergroupid=memberofgroup.membergroupid
        and memberid=1
left join (
            select count(membergroupid) as membercount, membergroupid
            from memberofgroup
            group by membergroupid
) as membercount
    on      membergroup.membergroupid=membercount.membergroupid
order by    membergroupid asc