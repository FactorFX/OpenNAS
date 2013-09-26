# Created by: Daniel Gerzo <danger@FreeBSD.org>
# $FreeBSD: sysutils/sysinfo/Makefile 316744 2013-04-28 20:01:07Z bapt $

PORTNAME=	sysinfo
PORTVERSION=	1.0.1
CATEGORIES=	sysutils
MASTER_SITES=	${MASTER_SITE_LOCAL} \
		http://danger.rulez.sk/projects/sysinfo/
MASTER_SITE_SUBDIR=danger

MAINTAINER=	danger@FreeBSD.org
COMMENT=	Utility used to gather system configuration information

NO_BUILD=	yes
WRKSRC=		${WRKDIR}/${PORTNAME}

MAN5=		sysinfo.conf.5
MAN8=		sysinfo.8

OPTIONS_DEFINE=	DMIDECODE PORTAUDIT
DMIDECODE_DESC=	Include information from the dmidecode tool
PORTAUDIT_DESC=	Include information from the portaudit tool

.include <bsd.port.options.mk>

.if ${PORT_OPTIONS:MDMIDECODE}
RUN_DEPENDS=	dmidecode:${PORTSDIR}/sysutils/dmidecode
.endif

.if ${PORT_OPTIONS:MPORTAUDIT}
RUN_DEPENDS+=	portaudit:${PORTSDIR}/ports-mgmt/portaudit
.endif

post-patch:
	@${REINPLACE_CMD} -e 's|common.subr|${DATADIR}/common.subr|g' ${WRKSRC}/sysinfo
	@${REINPLACE_CMD} -e 's|sysinfo.conf|${PREFIX}/etc/sysinfo.conf|g' \
		${WRKSRC}/sysinfo ${WRKSRC}/doc/sysinfo.conf.5
	@${REINPLACE_CMD} -e 's|APPDIR=.|APPDIR=${DATADIR}|g' \
		${WRKSRC}/sysinfo.conf ${WRKSRC}/doc/sysinfo.conf.5

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/sysinfo ${NAS4FREE_ROOTFS}/${PREFIX}/sbin
	${INSTALL_DATA} ${WRKSRC}/sysinfo.conf ${NAS4FREE_ROOTFS}/${PREFIX}/etc/sysinfo.conf

post-install:
	${MKDIR} ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo
	${INSTALL_DATA} ${WRKSRC}/common.subr ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo
	${INSTALL_DATA} ${WRKSRC}/LICENCE ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo
	(cd ${WRKSRC} && ${COPYTREE_BIN} modules ${NAS4FREE_ROOTFS}/${PREFIX}/share/sysinfo)

	gzip -c ${WRKSRC}/doc/sysinfo.conf.5 >${WRKSRC}/doc/sysinfo.conf.5.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/share/man/man5
	@$(INSTALL_DATA) ${WRKSRC}/doc/sysinfo.conf.5.gz ${NAS4FREE_ROOTFS}/usr/share/man/man5
	rm -f ${WRKSRC}/doc/sysinfo.conf.5.gz
	
	gzip -c ${WRKSRC}/doc/sysinfo.8 >${WRKSRC}/doc/sysinfo.8.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/share/man/man8
	@$(INSTALL_DATA) ${WRKSRC}/doc/sysinfo.8.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8
	rm -f ${WRKSRC}/doc/sysinfo.8.gz

.include <bsd.port.mk>
