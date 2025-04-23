FROM mysql:8.0

#COPY ./docker/production/mysql/init_sql.sh /usr/local/bin/init_sql.sh
#COPY ./backup.sql /tmp/backup.sql

COPY ./docker/production/mysql/init_sql.sh /docker-entrypoint-initdb.d/01-init.sh
COPY ./backup.sql  /docker-entrypoint-initdb.d/02-backup.sql

RUN chmod +x /docker-entrypoint-initdb.d/01-init.sh


#RUN chmod +x /usr/local/bin/init_sql.sh
#RUN chmod +x /tmp/backup.sql

#ENTRYPOINT ["/bin/bash", "-c", "/usr/local/bin/init_sql.sh"]

EXPOSE 3306



