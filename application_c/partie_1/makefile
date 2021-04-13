all: main run

main: sources/main.c sources/createXML.c
	gcc -g -Wall -Wextra -pedantic sources/main.c sources/createXML.c -o main -lcurl

run:
	./main

clean:
	rm main test.json
