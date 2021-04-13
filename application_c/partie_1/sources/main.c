#include "../headers/createXML.h"
#include<stdio.h>

int main(void){

	printf("%d\n",downloadXML("https://world.openfoodfacts.org/api/v0/product/737628064502.json", "test.json"));

	return 0;
	
}