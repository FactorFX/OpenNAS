# Created by: David O'Brien (obrien@NUXI.com)
# $FreeBSD: head/security/nmap/Makefile 368003 2014-09-12 04:38:32Z ohauer $

PORTNAME=		nmap
DISTVERSION=	6.47

COMMENT=	Port scanning utility for large networks

MASTERDIR=	/usr/ports/security/nmap

do-install:
	${INSTALL_PROGRAM} ${WRKSRC}/nmap ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/ncat/ncat ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/nping/nping ${NAS4FREE_ROOTFS}/usr/local/bin
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/ncat/
	$(INSTALL_DATA) ${WRKSRC}/ncat/certs/ca-bundle.crt ${NAS4FREE_ROOTFS}/usr/local/share/ncat/
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-mac-prefixes ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-os-db ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-payloads ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-protocols ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-rpc ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-service-probes ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-services ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/docs/nmap.dtd ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/docs/nmap.xsl ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nse_main.lua ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/nmap/nselib
	${CP} -R ${WRKSRC}/nselib/* ${NAS4FREE_ROOTFS}/usr/local/share/nmap/nselib
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/nmap/scripts
	${CP} -R ${WRKSRC}/scripts/* ${NAS4FREE_ROOTFS}/usr/local/share/nmap/scripts
	
	# Manpages
	gzip -c ${WRKSRC}/docs/nmap.1 > ${WRKSRC}/docs/nmap.1.gz
	gzip -c ${WRKSRC}/ncat/docs/ncat.1 > ${WRKSRC}/ncat/docs/ncat.1.gz
	gzip -c ${WRKSRC}/nping/docs/nping.1 > ${WRKSRC}/nping/docs/nping.1.gz
	$(INSTALL_DATA) ${WRKSRC}/docs/nmap.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/
	$(INSTALL_DATA) ${WRKSRC}/ncat/docs/ncat.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/
	$(INSTALL_DATA) ${WRKSRC}/nping/docs/nping.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/
	rm -f ${WRKSRC}/docs/nmap.1.gz
	rm -f ${WRKSRC}/ncat/docs/ncat.1.gz
	rm -f ${WRKSRC}/nping/docs/nping.1.gz

post-install:
	${ECHO} "Do nothing"

.include "${MASTERDIR}/Makefile"
