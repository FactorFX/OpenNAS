# New ports collection makefile for:	pdksh
# Date created:		23 May 1995
# Whom:			Thomas Gellekum <tg@FreeBSD.org>
#
# $FreeBSD: ports/shells/pdksh/Makefile,v 1.38 2012/11/17 06:01:23 svnexp Exp $
#

PORTNAME=	pdksh
PORTVERSION=	5.2.14p2
PORTREVISION=	5
CATEGORIES=	shells
MASTER_SITES=	http://gd.tuwien.ac.at/utils/shells/pdksh/ \
		ftp://ftp.lip6.fr/pub/unix/shells/pdksh/ \
		ftp://ftp.demon.net/pub/mirrors/pdksh/
DISTNAME=	${PORTNAME}-${PORTVERSION:C/p.*//}

PATCH_SITES=	${MASTER_SITES}
PATCHFILES=	${DISTNAME}-patches.1 ${DISTNAME}-patches.2
PATCH_DIST_STRIP=	-p2

MAINTAINER=	skreuzer@FreeBSD.org
COMMENT=	The Public Domain Korn Shell
LICENSE=	BSD

GNU_CONFIGURE=	yes
MAN1=		ksh.1

.include <bsd.port.options.mk>

.if defined(WITH_STATIC)
CONFIGURE_ENV+=	LDSTATIC=-static
.endif

post-patch:
	@(${ECHO_CMD} ",s/v${PORTVERSION:C/p.*//}/v${PORTVERSION:S/p/./}/"; \
		${ECHO_CMD} "wq") | ed -s ${WRKSRC}/version.c
	
do-install:
	${INSTALL_PROGRAM} -v ${WRKSRC}/ksh ${NAS4FREE_ROOTFS}/bin/

	#manpages
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) -d ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/$$I.gz); \
	done

.include <bsd.port.mk>
