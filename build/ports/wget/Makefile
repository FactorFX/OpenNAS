# Created by: Thomas Gellekum <tg@FreeBSD.org>
# $FreeBSD: head/ftp/wget/Makefile 366659 2014-08-30 18:18:14Z tijl $

PORTNAME=		wget
DISTVERSION=	1.15

COMMENT=	Retrieve files from the Net via HTTP(S) and FTP

MASTERDIR=	/usr/ports/ftp/wget

MAN1=		wget.1

do-install:
	${INSTALL_PROGRAM} -v ${WRKSRC}/src/wget ${NAS4FREE_ROOTFS}/${PREFIX}/bin/

	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/man/man1
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/doc/$$I.gz; gzip -c ${WRKSRC}/doc/$$I >${WRKSRC}/doc/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/doc/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/doc/$$I.gz); \
	done

post-install:
	${ECHO} "Do nothing"

.include "${MASTERDIR}/Makefile"
