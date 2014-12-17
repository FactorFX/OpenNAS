# Created by: Samy Al Bahra <samy@kerneled.org>
# $FreeBSD: sysutils/pciutils/Makefile 333525 2013-11-11 17:17:51Z sunpoet $

PORTNAME=		pciutils

COMMENT=	PCI configuration utilities

MASTERDIR=	/usr/ports/sysutils/pciutils

STAGEDIR=	${NAS4FREE_ROOTFS}

MAN.8= lspci.8 setpci.8

do-install:
	${CP} ${WRKSRC}/lspci ${NAS4FREE_ROOTFS}/usr/local/bin
	${CP} ${WRKSRC}/setpci ${NAS4FREE_ROOTFS}/usr/local/bin
	${CP} ${WRKSRC}/update-pciids.sh ${NAS4FREE_ROOTFS}/usr/local/bin

	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man8
	for I in ${MAN.8}; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8/$$I.gz;); \
	done

.include "${MASTERDIR}/Makefile"