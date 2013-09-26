# Created by: Andrew Pantyukhin <infofarmer@FreeBSD.org>
# $FreeBSD: sysutils/ncdu/Makefile 317888 2013-05-11 15:31:46Z pawel $

PORTNAME=	ncdu
PORTVERSION=	1.10
CATEGORIES=	sysutils
MASTER_SITES=	http://dev.yorhel.nl/download/

MAINTAINER=	pawel@FreeBSD.org
COMMENT=	Ncurses du(1)

LICENSE=	MIT

GNU_CONFIGURE=	yes
PLIST_FILES=	bin/${PORTNAME}
MAN1=		${PORTNAME}.1

do-install:
	@${INSTALL_PROGRAM} ${WRKSRC}/ncdu ${NAS4FREE_ROOTFS}/${PREFIX}/bin
	gzip -c ${WRKSRC}/${PORTNAME}.1 >${WRKSRC}/${PORTNAME}.1.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/share/man/man1
	@$(INSTALL_DATA) ${WRKSRC}/${PORTNAME}.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1
	rm -f ${WRKSRC}/${PORTNAME}.1.gz

.include <bsd.port.mk>
