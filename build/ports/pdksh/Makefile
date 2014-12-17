# New ports collection makefile for:	pdksh
# Date created:		23 May 1995
# Whom:			Thomas Gellekum <tg@FreeBSD.org>
#
# $FreeBSD: ports/shells/pdksh/Makefile,v 1.38 2012/11/17 06:01:23 svnexp Exp $
#

PORTNAME=		pdksh

COMMENT=	The Public Domain Korn Shell

MASTERDIR=	/usr/ports/shells/pdksh

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
