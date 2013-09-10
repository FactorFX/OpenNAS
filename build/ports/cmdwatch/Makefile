# New ports collection makefile for:	cmdwatch
# Date created:	8-28-2002
# Whom:		bjohnson@wedgie.org
#
# $FreeBSD: ports/sysutils/cmdwatch/Makefile,v 1.10 2012/11/17 06:01:26 svnexp Exp $
#

PORTNAME=	cmdwatch
PORTVERSION=	0.2.0
PORTREVISION=	2
CATEGORIES=	sysutils
MASTER_SITES=	http://www.chruetertee.ch/files/download/

MAINTAINER=	beat@FreeBSD.org
COMMENT=	Watches the output from a command at specified intervals

MAN1=		cmdwatch.1
PLIST_FILES=	bin/cmdwatch

do-install:
	${INSTALL_PROGRAM} -v ${WRKSRC}/cmdwatch ${NAS4FREE_ROOTFS}/${PREFIX}/bin/
	
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/share/man/man1
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/$$I.gz); \
	done

.include <bsd.port.mk>
