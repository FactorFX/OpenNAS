# New ports collection makefile for:	zfs-stats
# Date created:		2010-10-20
# Whom:			Martin Matuska <mm@FreeBSD.org>
#
# $FreeBSD: ports/sysutils/zfs-stats/Makefile,v 1.9 2012/11/17 06:01:51 svnexp Exp $
#

PORTNAME=		zfs-stats
PORTVERSION=	1.2.2

COMMENT=		Display human-readable ZFS statistics

MASTERDIR=		/usr/ports/sysutils/zfs-stats

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/zfs-stats ${NAS4FREE_ROOTFS}/${PREFIX}/bin/zfs-stats
	${INSTALL_SCRIPT} ${WRKSRC}/zfs-mon ${NAS4FREE_ROOTFS}/${PREFIX}/bin/zfs-mon
	${INSTALL_PROGRAM} /usr/bin/dc ${NAS4FREE_ROOTFS}/usr/bin
	${INSTALL_PROGRAM} /sbin/kldstat ${NAS4FREE_ROOTFS}/sbin
	${INSTALL_PROGRAM} /usr/bin/sed ${NAS4FREE_ROOTFS}/usr/bin
	${INSTALL_PROGRAM} /sbin/sysctl ${NAS4FREE_ROOTFS}/sbin
	${INSTALL_PROGRAM} /usr/bin/vmstat ${NAS4FREE_ROOTFS}/usr/bin

.include "${MASTERDIR}/Makefile"