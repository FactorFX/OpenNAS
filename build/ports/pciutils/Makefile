# Created by: Samy Al Bahra <samy@kerneled.org>
# $FreeBSD: sysutils/pciutils/Makefile 333525 2013-11-11 17:17:51Z sunpoet $

PORTNAME=	pciutils
PORTVERSION=	3.2.1
CATEGORIES=	sysutils
MASTER_SITES=	ftp://atrey.karlin.mff.cuni.cz/pub/linux/pci/ \
		LOCAL/sunpoet

MAINTAINER=	sunpoet@FreeBSD.org
COMMENT=	PCI configuration utilities

LICENSE=	GPLv2

LIB_DEPENDS=	libpci.so:${PORTSDIR}/devel/libpci
RUN_DEPENDS=	${LOCALBASE}/share/pciids/pci.ids:${PORTSDIR}/misc/pciids

ALL_TARGET=	lspci lspci.8 setpci setpci.8
CPPFLAGS+=	-fPIC
LDFLAGS+=	-L${LOCALBASE}/lib -lpci
MAKE_ENV=	LANG=C
USES=		gmake

PLIST_FILES=	bin/lspci \
		bin/setpci \
		man/man8/lspci.8.gz \
		man/man8/setpci.8.gz

post-patch:
	@${REINPLACE_CMD} -e '/^CC=/d; /^CFLAGS=/ s|=|+=|; /^IDSDIR=/ s|$$|/pciids|; /^OPT=/d; /^PREFIX=/d; s| lib/$$(PCILIB)||' ${WRKSRC}/Makefile

do-install:
	cd ${WRKSRC}/ && ${INSTALL_PROGRAM} lspci setpci ${NAS4FREE_ROOTFS}/usr/local/bin/
	for I in lspci.8 setpci.8; \
		do (rm -f ${WRKSRC}/$$I.gz; gzip -c ${WRKSRC}/$$I >${WRKSRC}/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8/$$I.gz; \
			rm -f ${WRKSRC}/$$I.gz); \
	done

.include <bsd.port.mk>
