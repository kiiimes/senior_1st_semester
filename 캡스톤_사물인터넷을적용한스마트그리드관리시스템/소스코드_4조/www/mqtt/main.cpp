#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>
#include <vector>
#include <iostream>
#include <string>
#include <string.h>

using std::vector;
using std::string;

#define BUFFER_SIZE 1024

void execute_cmd(const char * fmt, ...) {
	char cmd[BUFFER_SIZE];

	int ret = 0;
	va_list ap;

	va_start(ap, fmt);
	vsprintf(cmd, fmt, ap);
	system(cmd);
	va_end(ap);
}

int main(int argc, char ** argv){
	/*
		Job list
		solar
		external
		device
		solarGen
						*/

	bool ifdebug = false;

	if (argc > 2){
		if (strcmp(argv[1], "-d")) {
			ifdebug = true;
		}
	} 
	vector<string> topics{"solar", "external", "device", "solarGen", "consumption"};

	int idx = 0;
	for(auto &i : topics){
		string cmd = "nohup python3 sub.py %s > %s &";
		printf(cmd.c_str(), i.c_str(), ifdebug ? ("sub_"+i+".log").c_str() : "/dev/null");
		printf("\n");
		execute_cmd(cmd.c_str(), i.c_str(), ifdebug ? ("sub_"+i+".log").c_str() : "/dev/null");
	}
}


