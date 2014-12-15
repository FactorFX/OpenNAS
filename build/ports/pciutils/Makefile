# Created by: Samy Al Bahra <samy@kerneled.org>
# $FreeBSD: sysutils/pciutils/Makefile 333525 2013-11-11 17:17:51Z sunpoet $

PORTNAME=		pciutils
PORTVERSION=	3.2.1

COMMENT=	PCI configuration utilities

MASTERDIR=	/usr/ports/sysutils/pciutils

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"