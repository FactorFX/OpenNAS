# Created by: Neil Blakey-Milner <nbm@rucus.ru.ac.za>
# $FreeBSD: head/ftp/curl/Makefile 370549 2014-10-09 15:24:43Z sunpoet $

PORTNAME=	curl
PORTVERSION=	7.38.0

COMMENT=	Non-interactive tool to get files from FTP, GOPHER, HTTP(S) servers

MASTERDIR=	/usr/ports/ftp/curl

MAN1=		curl.1

do-install:
	${INSTALL_PROGRAM} -v ${WRKSRC}/src/.libs/curl ${NAS4FREE_ROOTFS}/${PREFIX}/bin/
	${MKDIR} ${NAS4FREE_ROOTFS}/${PREFIX}/share/certs
	${CP} /usr/local/share/certs/ca-root-nss.crt ${NAS4FREE_ROOTFS}/${PREFIX}/share/certs

	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/man/man1
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/docs/$$I.gz; gzip -c ${WRKSRC}/docs/$$I >${WRKSRC}/docs/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/docs/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/docs/$$I.gz); \
	done

post-install:
	${ECHO} "Do nothing"

.include "${MASTERDIR}/Makefile"
