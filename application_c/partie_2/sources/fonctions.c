#include <stdlib.h>
#include <stdio.h>
#include <dirent.h>
#include <string.h>
#include <time.h>
#include <sys/stat.h>

#include "../headers/fonctions.h"

#define DESTINATION_MAX_LENGTH 16
#define FILE_MAX_LENGTH 25  //nom de la ville max 10 charactères


char destination_path[DESTINATION_MAX_LENGTH];


int createNewFile(){

    time_t t;
    struct tm tm;
    int year;
    int month;
    DIR *d;
    FILE *fd;
    char repo[8];


    t = time(NULL);
    tm = *localtime(&t);
    year = tm.tm_year + 1900;
    month = tm.tm_mon + 1;

    sprintf(repo, "year%d", year);


    d = opendir(repo); 
    if (!d){
        mkdir(repo, 0777);
    }


    sprintf(destination_path, "%s/%d.xml", repo, month);
    
    
    fd = fopen(destination_path, "w");

    if(fd == NULL)
        return 0;

    closedir(d);
    fclose(fd);
    return 1;
}


int concatFiles(){

	struct dirent *file; 
    DIR *d;
    FILE *fd;
    FILE *fd_new;
    char* current_file;
    char c;
    char init[38] = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

    d = opendir("files");

    if (d){
        if(createNewFile()){

            fd_new = fopen(destination_path, "w");
            if(fd_new == NULL)
                return 0;


            fwrite(&init, sizeof(char), 38, fd_new);

            while ((file = readdir(d)) != NULL ){
                if( file->d_name[0] != '.' ){

                    current_file = malloc(FILE_MAX_LENGTH * sizeof(char));
                    strcpy(current_file, "files/");
                    strcat(current_file, file->d_name);

                    fd = fopen(current_file, "r");
                    if(fd == NULL)
                        return 0;

                    fseek(fd, 38, SEEK_SET); //on saute les 2 première balise

                    while(fread(&c, sizeof(char), 1, fd),!feof(fd))
                        fwrite(&c, sizeof(char), 1, fd_new);

                    free(current_file);
                    fclose(fd);
                }
            }
            fclose(fd_new);
            return 1;
        }
        else
            return 0;
    closedir(d);
    }
    else
        return 0;
}