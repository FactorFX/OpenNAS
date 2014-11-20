# Created by: Andrew Pantyukhin <infofarmer@FreeBSD.org>
# $FreeBSD: sysutils/ncdu/Makefile 317888 2013-05-11 15:31:46Z pawel $

PORTNAME=		ncdu
PORTVERSION=	1.10

COMMENT=	Ncurses du(1)

MASTERDIR=	/usr/ports/sysutils/ncdu

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"

