# Created by: Dmitry Frolov <frol@nov.net>
# $FreeBSD: head/sysutils/ipmitool/Makefile 363340 2014-07-29 15:29:59Z sunpoet $

PORTNAME=		ipmitool

COMMENT=	CLI to manage IPMI systems

MASTERDIR=	/usr/ports/sysutils/ipmitool

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
