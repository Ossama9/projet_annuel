#include "../headers/fonctions.h"
#include<stdio.h>

int main(void){

	downloadXML("https://world.openfoodfacts.org/api/v0/product/737628064502.json", "test.json");

	sendXML("https://enaq0wlextx63sp.m.pipedream.net", "test.json");

	return 0;
	
}