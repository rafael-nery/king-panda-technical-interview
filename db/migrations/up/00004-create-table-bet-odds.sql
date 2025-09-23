create table bet_odds
(
    id int auto_increment not null primary key,
    event_name varchar(255) not null,
    event_date datetime not null,
    market_type varchar(50) not null,
    selection varchar(100) not null,
    odds decimal(10,2) not null,
    status varchar(20) default 'active',
    created_at datetime default current_timestamp,
    updated_at datetime default current_timestamp on update current_timestamp,
    index idx_event_date (event_date),
    index idx_status (status),
    index idx_market_type (market_type)
);