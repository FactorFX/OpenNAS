# Created by: Henrik Brix Andersen <brix@FreeBSD.org>
# $FreeBSD: head/sysutils/usbutils/Makefile 356165 2014-06-01 19:22:21Z brix $

PORTNAME=		usbutils
PORTVERSION=	0.86

COMMENT=		Utility for listing USB devices

MASTERDIR=	/usr/ports/sysutils/usbutils

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
