# New ports collection makefile for:	zfs-stats
# Date created:		2010-10-20
# Whom:			Martin Matuska <mm@FreeBSD.org>
#
# $FreeBSD: ports/sysutils/zfs-stats/Makefile,v 1.9 2012/11/17 06:01:51 svnexp Exp $
#

PORTNAME=		zfs-stats

COMMENT=		Display human-readable ZFS statistics

MASTERDIR=		/usr/ports/sysutils/zfs-stats

STAGEDIR=	${NAS4FREE_ROOTFS}

fix-perl-things:
	echo 'Ignore some fix for perl'

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/zfs-stats ${NAS4FREE_ROOTFS}${PREFIX}/bin/zfs-stats
	${INSTALL_SCRIPT} ${WRKSRC}/zfs-mon ${NAS4FREE_ROOTFS}${PREFIX}/bin/zfs-mon

.include "${MASTERDIR}/Makefile"