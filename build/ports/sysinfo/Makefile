# Created by: Daniel Gerzo <danger@FreeBSD.org>
# $FreeBSD: sysutils/sysinfo/Makefile 316744 2013-04-28 20:01:07Z bapt $

PORTNAME=		sysinfo
PORTVERSION=	1.0.1

COMMENT=	Utility used to gather system configuration information

MASTERDIR=	/usr/ports/sysutils/sysinfo

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
