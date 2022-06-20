create table sflogserver
(
    sflogserver_id varchar(36)  not null
        primary key,
    apx_id         varchar(100) not null,
    app_id         varchar(100) null,
    activity       varchar(200) null,
    category       varchar(100) null,
    message        text         null,
    trace          text         null,
    user_agent     varchar(200) null,
    userx          varchar(100) null,
    ipx            varchar(20)  null,
    datetimex      datetime     null,
    queryx         varchar(500) null,
    datax          mediumtext   null,
    i_ip           varchar(20)  null,
    i_datetime     datetime     null,
    i_user_agent   varchar(200) null,
    i_query        varchar(500) null
);