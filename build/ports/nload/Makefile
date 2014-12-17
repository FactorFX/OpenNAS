# Created by: Olivier Tharan <olive@oban.frmug.org>
# $FreeBSD: head/net/nload/Makefile 340722 2014-01-22 17:00:46Z mat $

PORTNAME=		nload

COMMENT=	Console application which monitors network traffic in real time

MASTERDIR=	/usr/ports/net/nload

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"