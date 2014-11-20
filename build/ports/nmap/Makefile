# Created by: David O'Brien (obrien@NUXI.com)
# $FreeBSD: head/security/nmap/Makefile 368003 2014-09-12 04:38:32Z ohauer $

PORTNAME=		nmap
DISTVERSION=	6.47

COMMENT=	Port scanning utility for large networks

MASTERDIR=	/usr/ports/security/nmap

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
