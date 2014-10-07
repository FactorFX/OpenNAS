# New ports collection makefile for:	pdksh
# Date created:		23 May 1995
# Whom:			Thomas Gellekum <tg@FreeBSD.org>
#
# $FreeBSD: ports/shells/pdksh/Makefile,v 1.38 2012/11/17 06:01:23 svnexp Exp $
#

PORTNAME=		pdksh
PORTVERSION=	5.2.14p2

COMMENT=	The Public Domain Korn Shell

MASTERDIR=	/usr/ports/shells/pdksh

MAN1=		ksh.1

do-install:
	${INSTALL_PROGRAM} -v ${WRKSRC}/ksh ${NAS4FREE_ROOTFS}/bin/

	#manpages
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/share/man/man1
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/$$I.gz); \
	done

.include "${MASTERDIR}/Makefile"
