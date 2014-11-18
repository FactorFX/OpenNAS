# Created by: Daniel Gerzo <danger@FreeBSD.org>
# $FreeBSD: sysutils/sysinfo/Makefile 316744 2013-04-28 20:01:07Z bapt $

PORTNAME=		sysinfo
PORTVERSION=	1.0.1

MAN5=		sysinfo.conf.5
MAN8=		sysinfo.8

COMMENT=	Utility used to gather system configuration information

MASTERDIR=	/usr/ports/sysutils/sysinfo

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/sysinfo ${NAS4FREE_ROOTFS}/${PREFIX}/sbin
	${INSTALL_DATA} ${WRKSRC}/sysinfo.conf ${NAS4FREE_ROOTFS}/${PREFIX}/etc/sysinfo.conf

post-install:
	${MKDIR} ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo
	${INSTALL_DATA} ${WRKSRC}/common.subr ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo
	${INSTALL_DATA} ${WRKSRC}/LICENCE ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo
	(cd ${WRKSRC} && ${COPYTREE_BIN} modules ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo)

	gzip -c ${WRKSRC}/doc/sysinfo.conf.5 >${WRKSRC}/doc/sysinfo.conf.5.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/local/man/man5
	@$(INSTALL_DATA) ${WRKSRC}/doc/sysinfo.conf.5.gz ${NAS4FREE_ROOTFS}/usr/local/man/man5
	rm -f ${WRKSRC}/doc/sysinfo.conf.5.gz
	
	gzip -c ${WRKSRC}/doc/sysinfo.8 >${WRKSRC}/doc/sysinfo.8.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/local/man/man8
	@$(INSTALL_DATA) ${WRKSRC}/doc/sysinfo.8.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8
	rm -f ${WRKSRC}/doc/sysinfo.8.gz

.include "${MASTERDIR}/Makefile"
