create table bets
(
    id int auto_increment not null primary key,
    user_id binary(16) not null,
    bet_odds_id int not null,
    stake decimal(10,2) not null,
    potential_return decimal(10,2) not null,
    status varchar(20) default 'pending',
    placed_at datetime default current_timestamp,
    settled_at datetime null,
    foreign key (user_id) references users(userid),
    foreign key (bet_odds_id) references bet_odds(id),
    index idx_user_id (user_id),
    index idx_bet_odds_id (bet_odds_id),
    index idx_status (status),
    index idx_placed_at (placed_at)
);