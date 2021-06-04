#include "../headers/databaseConnection.h"
#include "../headers/xmlCreation.h"

#include <mysql/mysql.h>
#include <stdio.h>
#include <string.h>


int connectDB(MYSQL *db){

	if (db == NULL)
    {
    	fprintf(stderr, "%s\n", mysql_error(db));
    	return 0;
  	}


	char *server = "localhost";
    char *user = "root";
    char *password = "";
    char *database = "ready_to_use";

    if (!mysql_real_connect(db, 
    						server,
        					user, 
        					password, 
        					database, 
        					0, 
        					NULL, 
        					0)
    ){
        fprintf(stderr, "%s\n", mysql_error(db));
        return 0;    
    }

	return 1;
}


// If program run without arguments

/*int findWharehouseList(MYSQL *db){

    MYSQL_RES *res;
    MYSQL_ROW row;
    char* query;
    int cpt=0;

    query = "SELECT wharehouse_id, town FROM wharehouse";

    if (mysql_query(db, query)) {
        fprintf(stderr, "%s\n", mysql_error(db));
        return 0;
    }

    res = mysql_store_result(db);

   while ((row = mysql_fetch_row(res)) != NULL){
        ++cpt;
        findEntrance(db, row);
    }

    mysql_free_result(res);

    return 1;
}
*/


int findWharehouse(MYSQL *db, int wharehouse_id){

	MYSQL_RES *res;
    MYSQL_ROW row;

    char query[54]; //60 plus tard
    sprintf(query, "SELECT town FROM WHAREHOUSE WHERE wharehouse_id = \"%d", wharehouse_id);
    strcat(query, "\";");

    if (mysql_query(db, query)) {
        fprintf(stderr, "%s\n", mysql_error(db));
        return 0;
    }

    res = mysql_store_result(db);

   	row = mysql_fetch_row(res);
    
   	if( !initFile(row[0], wharehouse_id)){
   		printf("initFile failed\n");
   		return 0;
   	}

    mysql_free_result(res);
    return 1;
}


int findEntrance(MYSQL *db, int wharehouse_id){

	MYSQL_RES *res;
    MYSQL_ROW row;
    int num_field;

    char query[380];
    sprintf(query, "SELECT PRODUCT.product_id, MODEL.name AS model_name, BRAND.name AS brand_name, SELL.accepted_date FROM PRODUCT INNER JOIN MODEL ON PRODUCT.model_id = MODEL.model_id INNER JOIN BRAND ON BRAND.brand_id = MODEL.brand_id INNER JOIN SELL ON MONTH(SELL.accepted_date) = MONTH(current_date) AND SELL.product_id = PRODUCT.product_id WHERE PRODUCT.wharehouse_id = \"%d",wharehouse_id);
    strcat(query, "\";");

    if (mysql_query(db, query)) {
        fprintf(stderr, "%s\n", mysql_error(db));
        return 0;
    }
    res = mysql_store_result(db);
    num_field = mysql_num_fields(res);

    while ((row = mysql_fetch_row(res))){
    		writeEntrancesProduct(row, num_field);
    }
    closeEntrances();

    mysql_free_result(res);
    return 1;
}


int findDeparture(MYSQL *db, int wharehouse_id){

	MYSQL_RES *res;
    MYSQL_ROW row;
    int num_field;

    char query[380];
    sprintf(query, "SELECT PRODUCT.product_id, MODEL.name AS model_name, BRAND.name AS brand_name, PURCHASE.payment_date FROM PRODUCT INNER JOIN MODEL ON PRODUCT.model_id = MODEL.model_id INNER JOIN BRAND ON BRAND.brand_id = MODEL.brand_id INNER JOIN PURCHASE ON MONTH(PURCHASE.payment_date) = MONTH(current_date) AND PURCHASE.product_id = PRODUCT.product_id WHERE PRODUCT.wharehouse_id = \"%d", wharehouse_id);
    strcat(query, "\";");

    if (mysql_query(db, query)) {
        fprintf(stderr, "%s\n", mysql_error(db));
        return 0;
    }

    res = mysql_store_result(db);
    num_field = mysql_num_fields(res);

    while ((row = mysql_fetch_row(res))){
    		writeDeparturesProduct(row, num_field);
    }
    closeFile();

    mysql_free_result(res);
    return 1;
}
