# Created by: Samy Al Bahra <samy@kerneled.org>
# $FreeBSD: sysutils/pciutils/Makefile 333525 2013-11-11 17:17:51Z sunpoet $

PORTNAME=		pciutils
PORTVERSION=	3.2.1

COMMENT=	PCI configuration utilities

MASTERDIR=	/usr/ports/sysutils/pciutils

do-install:
	# Binaries
	cd ${WRKSRC}/ && ${INSTALL_PROGRAM} lspci setpci ${NAS4FREE_ROOTFS}/usr/local/bin/
	
	# Pci database
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/pciids/
	${INSTALL_SCRIPT} /usr/local/share/pciids/pci.ids ${NAS4FREE_ROOTFS}/usr/local/share/pciids/
	
	# Manpages
	for I in lspci.8 setpci.8; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8/$$I.gz; \
			rm -f ${WRKSRC}/$$I.gz); \
	done

.include "${MASTERDIR}/Makefile"