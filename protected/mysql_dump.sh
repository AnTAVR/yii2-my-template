#!/usr/bin/env sh

HOST='127.0.0.1'
USERNAME='tests'
DBNAME='tests'
PASSWORD='teststests'

DATE=$(date +%d%m%y,%T)
DUMPFILE=backup/${DBNAME}_${DATE}.sql

mysqldump --host=${HOST} --user=${USERNAME} --password=${PASSWORD} ${DBNAME} > ${DUMPFILE}
#mysql -h ${HOST} -u ${USERNAME} -p${PASSWORD} ${DBNAME} < ${DUMPFILE}
