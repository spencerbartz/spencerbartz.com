#ifndef SOCKETUTILS_H
#define SOCKETUTILS_H

// define INADDR_NONE if not already defined by system
#ifndef INADDR_NONE
#define INADDR_NONE 0xffffffff
#endif 

#include <sys/types.h>
#include <sys/socket.h>
#include <sys/errno.h>

#include <netinet/in.h>
#include <arpa/inet.h>

#include <netdb.h>
#include <string.h>
#include <stdlib.h>

#include <netinet/in.h>
#include <stdio.h>
#include <unistd.h>

#define MAX_MSG 5096

// Function prototypes
extern int connectTCP(const char *host, const char *service);
extern int connectUDP(const char *host, const char *service);
extern int passiveTCP(const char *service, int qlen);
extern int passiveUDP(const char *service);
extern int connectsock(const char *host, const char *service, const char *transport);
extern int passivesock(const char *service, const char *transport, int qlen);
extern char * port_to_proto(int port);

#endif

