# Created by: Dmitry Frolov <frol@nov.net>
# $FreeBSD: sysutils/ipmitool/Makefile 327772 2013-09-20 23:05:58Z bapt $

PORTNAME=	ipmitool
PORTVERSION=	1.8.12
PORTREVISION=	4
CATEGORIES=	sysutils
MASTER_SITES=	SF

MAINTAINER=	spolyack@collaborativefusion.com
COMMENT=	CLI to manage IPMI systems

USE_BZIP2=	yes
USE_GMAKE=	yes
USE_OPENSSL=	yes
GNU_CONFIGURE=	yes
CONFIGURE_ARGS+=--enable-intf-lan --enable-intf-lanplus \
		--disable-intf-imb --disable-intf-lipmi --disable-intf-bmc
PLIST_FILES=	bin/ipmitool sbin/ipmievd share/ipmitool/oem_ibm_sel_map \
		${PERIODIC_DIR}/400.status-ipmi
PLIST_DIRS=	share/ipmitool
PLIST_DIRSTRY=	${PERIODIC_DIR} etc/periodic
SUB_FILES=	status-ipmi.sh
PORTDOCS=	AUTHORS COPYING ChangeLog README
DISTNAME=	${PORTNAME}-${PORTVERSION}

MAN1+=		${PORTNAME}.1
MAN8+=		ipmievd.8

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

NO_STAGE=	yes
.include <bsd.port.options.mk>

.if empty(PORT_OPTIONS:MDOCS)
EXTRA_PATCHES+=	${PATCHDIR}/extra-patch-Makefile.in
.endif

.if ${PORT_OPTIONS:MFREEIPMI}
LIB_DEPENDS+=	freeipmi:${PORTSDIR}/sysutils/freeipmi
CPPFLAGS+=	-I${LOCALBASE}/include
LDFLAGS+=	-L${LOCALBASE}/lib
CONFIGURE_ARGS+=	--enable-intf-free
.else
CONFIGURE_ARGS+=	--disable-intf-free
.endif

post-install:
	@${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/${PERIODIC_DIR}
	@${INSTALL_SCRIPT} ${WRKDIR}/status-ipmi.sh ${NAS4FREE_ROOTFS}/usr/local/${PERIODIC_DIR}/400.status-ipmi

do-install:
	${INSTALL_PROGRAM} ${WRKSRC}/src/ipmitool ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/src/ipmievd ${NAS4FREE_ROOTFS}/usr/local/sbin
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/ipmitool/
	${INSTALL_SCRIPT} ${WRKSRC}/contrib/oem_ibm_sel_map ${NAS4FREE_ROOTFS}/usr/local/share/ipmitool/
	
	# Manpages
	for I in ${MAN1}; \
		do (rm -f ${WRKDIR}/${DISTNAME}/doc/$$I.gz; gzip -c ${WRKDIR}/${DISTNAME}/doc/$$I >${WRKDIR}/${DISTNAME}/doc/$$I.gz; \
			$(INSTALL_DATA) ${WRKDIR}/${DISTNAME}/doc/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKDIR}/${DISTNAME}/doc/$$I.gz); \
	done
	for I in ${MAN8}; \
		do (rm -f ${WRKDIR}/${DISTNAME}/doc/$$I.gz; gzip -c ${WRKDIR}/${DISTNAME}/doc/$$I >${WRKDIR}/${DISTNAME}/doc/$$I.gz; \
			$(INSTALL_DATA) ${WRKDIR}/${DISTNAME}/doc/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8/$$I.gz; \
			rm -f ${WRKDIR}/${DISTNAME}/doc/$$I.gz); \
	done

.include <bsd.port.mk>
