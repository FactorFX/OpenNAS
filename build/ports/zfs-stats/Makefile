# New ports collection makefile for:	zfs-stats
# Date created:		2010-10-20
# Whom:			Martin Matuska <mm@FreeBSD.org>
#
# $FreeBSD: ports/sysutils/zfs-stats/Makefile,v 1.9 2012/11/17 06:01:51 svnexp Exp $
#

PORTNAME=	zfs-stats
PORTVERSION=	1.2.2
CATEGORIES=	sysutils
MASTER_SITES=	http://cloud.github.com/downloads/mmatuska/zfs-stats/

MAINTAINER=	mm@FreeBSD.org
COMMENT=	Display human-readable ZFS statistics

LICENSE=	BSD

USE_PERL5=	yes

NO_BUILD=	yes

post-patch:
	@${REINPLACE_CMD} -e "s|/usr/bin/env -iS perl|${PERL}|g" ${WRKSRC}/zfs-stats

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/zfs-stats ${NAS4FREE_ROOTFS}/${PREFIX}/bin/zfs-stats
	${INSTALL_SCRIPT} ${WRKSRC}/zfs-mon ${NAS4FREE_ROOTFS}/${PREFIX}/bin/zfs-mon
	${INSTALL_PROGRAM} /usr/bin/dc ${NAS4FREE_ROOTFS}/usr/bin
	${INSTALL_PROGRAM} /sbin/kldstat ${NAS4FREE_ROOTFS}/sbin
	${INSTALL_PROGRAM} /usr/bin/sed ${NAS4FREE_ROOTFS}/usr/bin
	${INSTALL_PROGRAM} /sbin/sysctl ${NAS4FREE_ROOTFS}/sbin
	${INSTALL_PROGRAM} /usr/bin/vmstat ${NAS4FREE_ROOTFS}/usr/bin
	
	${INSTALL_PROGRAM} /usr/bin/perl ${NAS4FREE_ROOTFS}/usr/bin
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/lib/perl5/${PERL_VER}
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/lib/perl5/site_perl/${PERL_VER}
	${CP} -R /usr/local/lib/perl5/${PERL_VER}/* ${NAS4FREE_ROOTFS}/usr/local/lib/perl5/${PERL_VER}/
	${CP} -R /usr/local/lib/perl5/site_perl/${PERL_VER}/* ${NAS4FREE_ROOTFS}/usr/local/lib/perl5/site_perl/${PERL_VER}/
.include <bsd.port.mk>
