all: main run

main: sources/main.c sources/databaseConnection.c sources/xmlCreation.c sources/sendXml.c
	gcc -g -Wall -Wextra -pedantic sources/main.c sources/databaseConnection.c sources/xmlCreation.c sources/sendXml.c -o main -lmysqlclient -lcurl

run:
	sudo ./main 1

clean:
	sudo rm main *.xml

