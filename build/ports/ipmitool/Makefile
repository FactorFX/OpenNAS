# Created by: Dmitry Frolov <frol@nov.net>
# $FreeBSD: head/sysutils/ipmitool/Makefile 363340 2014-07-29 15:29:59Z sunpoet $

PORTNAME=		ipmitool
PORTVERSION=	1.8.14

COMMENT=	CLI to manage IPMI systems

MASTERDIR=	/usr/ports/sysutils/ipmitool

do-install:
	${INSTALL_PROGRAM} ${WRKSRC}/src/ipmitool ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/src/ipmievd ${NAS4FREE_ROOTFS}/usr/local/sbin
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/ipmitool/
	${INSTALL_SCRIPT} ${WRKSRC}/contrib/oem_ibm_sel_map ${NAS4FREE_ROOTFS}/usr/local/share/ipmitool/
	
	# Manpages
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man1/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man8/
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz
	gzip -c ${WRKDIR}/${DISTNAME}/doc/ipmitool.1 >${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz
	$(INSTALL_DATA) ${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/ipmitool.1.gz
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmitool.1.gz 
	
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz
	gzip -c ${WRKDIR}/${DISTNAME}/doc/ipmievd.8 >${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz
	$(INSTALL_DATA) ${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8/ipmievd.8.gz
	rm -f ${WRKDIR}/${DISTNAME}/doc/ipmievd.8.gz

.include "${MASTERDIR}/Makefile"
