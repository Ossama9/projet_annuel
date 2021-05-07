#include "../headers/databaseConnection.h"
#include "../headers/xmlCreation.h"
#include "../headers/sendXml.h"

#include <mysql/mysql.h>
#include<stdio.h>
#include <stdlib.h>

int main(int argc, char **argv){

	MYSQL *db = mysql_init(NULL);
	//char ***wharehouseList = (char***)malloc(sizeof(char**));

	if(argc == 0){
		printf("erreur1\n");
		exit(1);
	}
	

	if (!connectDB(db)) {
		printf("connectDB failed\n");
		exit(1);
	}

	if (!findWharehouse(db, atoi(argv[1]))) {
		printf("findWharehouse failed\n");
		exit(1);
	}

/*	If program run without arguments

	if (!findWharehouseList(db)) {
		printf("findWharehouseList failed\n");
		exit(1);
	}
*/
	if (!findEntrance(db, atoi(argv[1]))) {
		printf("findEntrance failed\n");
		exit(1);
	}

	if (!findDeparture(db, atoi(argv[1]))) {
		printf("findDeparture failed\n");
		exit(1);
	}


	sendXML("https://enaq0wlextx63sp.m.pipedream.net", DESTINATION_FILE);

	mysql_close(db);

	return 1;
}
