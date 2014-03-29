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