# New ports collection makefile for:	cmdwatch
# Date created:	8-28-2002
# Whom:		bjohnson@wedgie.org
#
# $FreeBSD: ports/sysutils/cmdwatch/Makefile,v 1.10 2012/11/17 06:01:26 svnexp Exp $
#

PORTNAME=	cmdwatch
PORTVERSION=	0.2.0

COMMENT=	Watches the output from a command at specified intervals

MASTERDIR=	/usr/ports/sysutils/cmdwatch

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
