#ifndef XMLCREATION_H
#define XMLCREATION_H

int initFile(char *town, int wharehouse_id);
int writeEntrancesProduct(char **product, unsigned int num_field);
int writeDeparturesProduct(char **product, unsigned int num_field);
int closeEntrances();
int closeFile();

char DESTINATION_FILE[38];

#endif