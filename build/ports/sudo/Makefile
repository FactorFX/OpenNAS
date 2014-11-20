# Created by: erich@rrnet.com
# $FreeBSD: head/security/sudo/Makefile 370967 2014-10-16 02:05:17Z wxs $

PORTNAME=	sudo
DISTVERSION=	1.8.11p1

MASTERDIR=	/usr/ports/security/sudo

COMMENT=	Allow others to run commands as root

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
