# Created by: Dmitry Frolov <frol@nov.net>
# $FreeBSD: sysutils/ipmitool/Makefile 327772 2013-09-20 23:05:58Z bapt $

PORTNAME=	ipmitool
PORTVERSION=	1.8.12
PORTREVISION=	6
CATEGORIES=	sysutils
MASTER_SITES=	SF

MAINTAINER=	spolyack@collaborativefusion.com
COMMENT=	CLI to manage IPMI systems

USES=		tar:bzip2 gmake
USE_OPENSSL=	yes
GNU_CONFIGURE=	yes
CONFIGURE_ARGS+=--enable-intf-lan --enable-intf-lanplus \
		--disable-intf-imb --disable-intf-lipmi --disable-intf-bmc
PLIST_FILES=	bin/ipmitool man/man1/ipmitool.1.gz man/man8/ipmievd.8.gz \
		sbin/ipmievd share/ipmitool/oem_ibm_sel_map \
		${PERIODIC_DIR}/400.status-ipmi
PLIST_DIRS=	share/ipmitool
PLIST_DIRSTRY=	${PERIODIC_DIR} etc/periodic
SUB_FILES=	status-ipmi.sh
PORTDOCS=	AUTHORS COPYING ChangeLog README

PERIODIC_DIR=	etc/periodic/daily

OPTIONS_DEFINE=	FREEIPMI
FREEIPMI_DESC=	Enable support for freeipmi

.if defined(WITH_DEBUG)
CFLAGS+=	-ggdb -Wall
.endif

.if exists(/usr/include/sys/ipmi.h)
CONFIGURE_ARGS+=	--enable-intf-open
.else
CONFIGURE_ARGS+=	--disable-intf-open
.endif

post-install:
	@${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/${PERIODIC_DIR}
	@${INSTALL_SCRIPT} ${WRKDIR}/status-ipmi.sh ${NAS4FREE_ROOTFS}/usr/local/${PERIODIC_DIR}/400.status-ipmi

do-install:
	${INSTALL_PROGRAM} ${WRKSRC}/src/.libs/ipmitool ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/src/.libs/ipmievd ${NAS4FREE_ROOTFS}/usr/local/sbin
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/ipmitool/
	${INSTALL_SCRIPT} ${WRKSRC}/contrib/oem_ibm_sel_map ${NAS4FREE_ROOTFS}/usr/local/share/ipmitool/
	
	# Manpages
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz
	gzip -c ${WRKDIR}/${DISTNAME}/doc/ipmitool.1 >${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz
	$(INSTALL_DATA) ${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/ipmitool.1.gz
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz 
	
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz
	gzip -c ${WRKDIR}/${DISTNAME}/doc/ipmievd.8 >${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz
	$(INSTALL_DATA) ${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8/ipmievd.8.gz
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz

.include <bsd.port.mk>
