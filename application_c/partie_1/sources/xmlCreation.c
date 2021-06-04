#include "../headers/xmlCreation.h"

#include <stdlib.h>
#include <stdio.h>
#include <time.h>



int initFile(char *town, int wharehouse_id){

	FILE *fd;
	time_t t;
    struct tm tm;
	int year;
	int month;
	int cpt=0;

	char init[110];
	sprintf(init, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r<wharehouse_movements wharehouse_id=\"%d\" town=\"%s\">\r\t<entrances>\r", wharehouse_id, town);

	t = time(NULL);
    tm = *localtime(&t);
    year = tm.tm_year - 100;
    month = tm.tm_mon - 1;

    if(month<10){
    	sprintf(DESTINATION_FILE, "0%d%s0%d%d.xml", wharehouse_id, town, month, year);
    }
    else{
    	sprintf(DESTINATION_FILE, "0%d%s%d%d.xml", wharehouse_id, town, month, year);
    }

	fd = fopen(DESTINATION_FILE, "w");

	if(fd == NULL){
		printf("impossible d'ouvrir le fichier\n");
        return 0;
	}

	while(init[cpt] != '\0'){
		fwrite(&init[cpt], sizeof(char), 1, fd);
		++cpt;
	}

	fclose(fd);
	return 1;
}


int writeEntrancesProduct(char **product, unsigned int num_field){

	FILE *fd;
	char content[180];
	int cpt=0;

	if(num_field != 4){
		printf("données non correct\n");
		return 0;
	}

	fd = fopen(DESTINATION_FILE, "a+");

	if(fd == NULL){
		printf("impossible d'ouvrir le fichier\n");
        return 0;
	}

	sprintf(content, "\t\t<product product_id=\"%s\" model_name=\"%s\" brand_name=\"%s\" accepted_date=\"%s\"/>\r", product[0], product[1], product[2], product[3]);

	while(content[cpt] != '\0'){
		fwrite(&content[cpt], sizeof(char), 1, fd);
		++cpt;
	}


	fclose(fd);
	return 1;
}


int writeDeparturesProduct(char **product, unsigned int num_field){

	FILE *fd;
	char content[180];
	int cpt=0;

	if(num_field != 4){
		printf("données non correct\n");
		return 0;
	}

	fd = fopen(DESTINATION_FILE, "a+");

	if(fd == NULL){
		printf("impossible d'ouvrir le fichier\n");
        return 0;
	}

	sprintf(content, "\t\t<product product_id=\"%s\" model_name=\"%s\" brand_name=\"%s\" payment_date=\"%s\"/>\r", product[0], product[1], product[2], product[3]);

	while(content[cpt] != '\0'){
		fwrite(&content[cpt], sizeof(char), 1, fd);
		++cpt;
	}


	fclose(fd);
	return 1;
}


int closeEntrances(){

	FILE *fd;
	char *content = "\t</entrances>\r\t<departures>\r";
	int cpt=0;

	fd = fopen(DESTINATION_FILE, "a+");

	if(fd == NULL){
		printf("impossible d'ouvrir le fichier\n");
        return 0;
	}

	while(content[cpt] != '\0'){
		fwrite(&content[cpt], sizeof(char), 1, fd);
		++cpt;
	}

	fclose(fd);
	return 1;
}


int closeFile(){

	FILE *fd;
	char *content = "\t</departures>\r</wharehouse_movements>";
	int cpt=0;

	fd = fopen(DESTINATION_FILE, "a+");

	if(fd == NULL){
		printf("impossible d'ouvrir le fichier\n");
        return 0;
	}

	while(content[cpt] != '\0'){
		fwrite(&content[cpt], sizeof(char), 1, fd);
		++cpt;
	}

	fclose(fd);
	return 1;
}