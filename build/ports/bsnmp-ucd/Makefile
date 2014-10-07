# Created by: Mikolaj Golub <to.my.trociny@gmail.com>
# $FreeBSD: head/net-mgmt/bsnmp-ucd/Makefile 369944 2014-10-04 06:42:04Z trociny $

PORTNAME=		bsnmp-ucd
PORTVERSION=	0.4.1
CATEGORIES=		net-mgmt
MASTER_SITES=	http://people.freebsd.org/~trociny/${PORTNAME}/

MAINTAINER=		trociny@FreeBSD.org
COMMENT=		bsnmpd module that implements parts of UCD-SNMP-MIB

LICENSE=		BSD2CLAUSE

USES=			uidfix
MAKE_ENV+=		NO_OBJ=yes

post-patch:
	@${REINPLACE_CMD} -e '32,32 s/^.*/#include <sys\/queue.h>/' ${WRKSRC}/snmp_ucd.h
	@${REINPLACE_CMD} -e "s/LOCALBASE/PREFIX/g" ${WRKSRC}/Makefile

do-install:
	@${INSTALL_PROGRAM} -v ${WRKSRC}/snmp_ucd.so.* ${NAS4FREE_ROOTFS}/usr/lib
	${LN} -sfv /usr/lib/snmp_ucd.so.1 ${NAS4FREE_ROOTFS}/usr/lib/snmp_ucd.so

	@${INSTALL_DATA} ${WRKSRC}/UCD-SNMP-MIB.txt ${NAS4FREE_ROOTFS}/usr/share/snmp/mibs

.include <bsd.port.mk>
