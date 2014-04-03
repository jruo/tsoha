insert into Member (username, password, salt, admin) values ('admin', '9c6f98e2346f1b937ae1fab637dac7316ef87b4b8e718896ed6bb84576eb9f2d', '36d5d17640fc0336e0af2014afb23a91e4bc5032937ae1c3e8a6956aa04ec0eb', 1);
insert into Member (username, password, salt) values ('Matti Meikäläinen', '7f4f43dd926273c755ddda392176351dac037fbc412dcabb6e1c484d751e97f4', '3114992e30462844cedfe79fef3042499597b9212a79b47176d7dabe09a1abec');
insert into Member (username, password, salt) values ('Maija Meikäläinen', 'ea8f711a400710d537082d6b374b8207f0fa748884d993eb5e5d67c70740b2d2', 'ecce9117785a281368f4ac162f3b8a20df20e0fb3284ea6834b44145d039e624');

insert into MemberOfGroup values (1, 0);
insert into MemberOfGroup values (2, 0);
insert into MemberOfGroup values (3, 0);

insert into MemberInfo (memberID, timeRegistered, email, realName, age, gender) values (1, 1396099080, 'admin@example.com', 'Ad Min', 20, 1);
insert into MemberInfo (memberID, timeRegistered, email, realName, age, gender) values (2, 1396099400, 'mmeikalainen@example.com', 'Matti Meikäläinen', 24, 1);
insert into MemberInfo (memberID, timeRegistered, email, realName, age, gender) values (3, 1396099401, 'maij.meika@example.com', 'Maija Meikäläinen', 23, 0);

insert into MemberGroup (groupName) values ('Matin ja Maijan ryhmä');

insert into MemberOfGroup values (2, 1);
insert into MemberOfGroup values (3, 1);

insert into Topic (title, public) values ('Ensimmäinen julkinen viestiketju', 1);
insert into Topic (title, public) values ('Foorumin sisäinen viestiketju', 0);
insert into Topic (title, public) values ('Toinen julkinen viestiketju...', 1);
insert into Topic (title, public) values ('Ja vielä kolmas julkinen', 1);
insert into Topic (title, public) values ('Matin ja Maijan viestiketju', 0);

insert into TopicVisible values (1, 0);
insert into TopicVisible values (2, 0);
insert into TopicVisible values (3, 0);
insert into TopicVisible values (4, 0);
insert into TopicVisible values (5, 1);

insert into Post (memberID, topicID, content, timeSent, postNumber, replyToNumber) values (1, 1, 'Tervetuloa foorumille :)', 1396099427, 1, NULL);
insert into Post (memberID, topicID, content, timeSent, postNumber, replyToNumber) values (1, 2, 'Tervetuloa foorumille, tämän alueen viestiketjut näkyvät vain rekisteröidyille jäsenille.', 1396099493, 1, NULL);
insert into Post (memberID, topicID, content, timeSent, postNumber, replyToNumber) values (1, 3, 'Joo jotain viestiä', 1396099691, 1, NULL);
insert into Post (memberID, topicID, content, timeSent, postNumber, replyToNumber) values (2, 4, 'Matin viesti', 1396099999, 1, NULL);
insert into Post (memberID, topicID, content, timeSent, postNumber, replyToNumber) values (2, 4, 'Matin uudempi viesti', 1396100200, 2, 1);
insert into Post (memberID, topicID, content, timeSent, postNumber, replyToNumber) values (3, 5, 'Maijan viesti matille', 1396100199, 1, NULL);