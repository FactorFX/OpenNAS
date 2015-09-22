# Created by: Denis Barov <dindin@dindin.ru>
# $FreeBSD: head/sysutils/sg3_utils/Makefile 372567 2014-11-14 18:04:02Z delphij $

PORTNAME=		sg3_utils

COMMENT=	Set of utilities that send SCSI commands to devices

MASTERDIR=	/usr/ports/sysutils/sg3_utils

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"