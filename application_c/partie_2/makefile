all: main run

main: sources/main.c sources/fonctions.c
	gcc -g -Wall -Wextra -pedantic sources/main.c sources/fonctions.c -o main -lcurl

run:
	./main
	
