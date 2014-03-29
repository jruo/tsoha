/*
 * JULKISET KETJUT
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
 * LUKEMATTIMIEN VIESTIEN LKM TOPICISSA
 */
select topicid, count(*) as newcount
from post
where postid not in (
    select postid
    from postread
    where memberid=1
)
group by topicid


/*
 * YKSITYISET KETJUT
 */

select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count, newcount.newcount
from        topic, post, member, (
                select topicid, count(*)
                from post
                group by topicid
            ) as count, (
                select topicid, count(*) as newcount
                from post
                where postid not in (
                    select postid
                    from postread
                    where memberid=2
                )
                group by topicid
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
    and     topic.topicid in (
                select topicid
                from topicvisible
                where membergroupid in (
                    select membergroupid
                    from memberofgroup
                    where memberid=2
                )
            )
    and     topic.public=0
order by    post.timesent desc;