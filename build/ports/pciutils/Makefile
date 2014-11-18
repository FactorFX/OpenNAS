# Created by: Samy Al Bahra <samy@kerneled.org>
# $FreeBSD: sysutils/pciutils/Makefile 333525 2013-11-11 17:17:51Z sunpoet $

PORTNAME=		pciutils
PORTVERSION=	3.2.1

COMMENT=	PCI configuration utilities

MASTERDIR=	/usr/ports/sysutils/pciutils

do-install:
	# Binaries
	cd ${WRKSRC}/ && ${INSTALL_PROGRAM} lspci setpci ${NAS4FREE_ROOTFS}/usr/local/bin/
	
	${INSTALL_SCRIPT} ${WRKSRC}/update-pciids.sh ${NAS4FREE_ROOTFS}/usr/local/sbin/
	
	# Pci database
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/pciids/
	gzip -9nc ${WRKSRC}/pci.ids > ${WRKSRC}/pci.ids.gz
	${INSTALL_DATA} ${WRKSRC}/pci.ids ${NAS4FREE_ROOTFS}/usr/local/share/pciids/
	${INSTALL_DATA} ${WRKSRC}/pci.ids.gz ${NAS4FREE_ROOTFS}/usr/local/share/pciids/
	
	rm -f ${WRKSRC}/pci.ids.gz
	
	# Manpages
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man8
	for I in lspci.8 setpci.8; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8/$$I.gz; \
			rm -f ${WRKSRC}/$$I.gz); \
	done

.include "${MASTERDIR}/Makefile"