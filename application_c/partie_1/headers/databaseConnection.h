#ifndef DATABASECONNECTION_H
#define DATABASECONNECTION_H

#include <mysql/mysql.h>

int connectDB(MYSQL *db);
int findWharehouseList(MYSQL *db);
int findWharehouse(MYSQL *db, int wharehouse_id);
int findEntrance(MYSQL *db, int wharehouse_id);
int findDeparture(MYSQL *db, int wharehouse_id);

#endif