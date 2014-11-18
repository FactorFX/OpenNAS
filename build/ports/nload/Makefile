# Created by: Olivier Tharan <olive@oban.frmug.org>
# $FreeBSD: head/net/nload/Makefile 340722 2014-01-22 17:00:46Z mat $

PORTNAME=		nload
PORTVERSION=	0.7.4

COMMENT=	Console application which monitors network traffic in real time

MASTERDIR=	/usr/ports/net/nload

MAN1=	nload.1

do-install:
	${CP} ${WRKSRC}/src/nload ${NAS4FREE_ROOTFS}/usr/local/bin/
	
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/docs/$$I.gz; gzip -c ${WRKSRC}/docs/$$I >${WRKSRC}/docs/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/docs/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/docs/$$I.gz); \
	done

post-install:
	${ECHO} "Do nothing"

.include "${MASTERDIR}/Makefile"