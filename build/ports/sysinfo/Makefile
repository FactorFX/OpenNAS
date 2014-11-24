# Created by: Daniel Gerzo <danger@FreeBSD.org>
# $FreeBSD: sysutils/sysinfo/Makefile 316744 2013-04-28 20:01:07Z bapt $

PORTNAME=		sysinfo
PORTVERSION=	1.0.1

COMMENT=	Utility used to gather system configuration information

MASTERDIR=	/usr/ports/sysutils/sysinfo

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/sysinfo ${STAGEDIR}${PREFIX}/sbin
	@${MKDIR} ${STAGEDIR}${DATADIR}
	${INSTALL_DATA} ${WRKSRC}/common.subr ${STAGEDIR}${DATADIR}
	(cd ${WRKSRC} && ${COPYTREE_BIN} modules ${STAGEDIR}${DATADIR})
	${INSTALL_MAN} ${WRKSRC}/doc/sysinfo.conf.5 ${STAGEDIR}${MAN5PREFIX}/man/man5
	${INSTALL_MAN} ${WRKSRC}/doc/sysinfo.8 ${STAGEDIR}${MAN8PREFIX}/man/man8

.include "${MASTERDIR}/Makefile"
