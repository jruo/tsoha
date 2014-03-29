/*
 * JULKISET KETJUT
 */

select      topic.topicid, topic.title, member.username, member.memberid, post.timesent
from        topic, post, member 
where       topic.topicid=post.topicid
    and     member.memberid=post.memberid
    and     post.timesent=(
                select max(post.timesent)
                from post
                where post.topicid=topic.topicid
            )
    and     topic.public=1
order by    post.timesent desc;




/*
 * YKSITYISET KETJUT
 */

select      topic.topicid, topic.title, member.username, member.memberid, post.timesent
from        topic, post, member 
where       topic.topicid=post.topicid
    and     member.memberid=post.memberid
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
                    where memberid=3
                )
            )
    and     topic.public=0
order by    post.timesent desc;