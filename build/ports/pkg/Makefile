# $FreeBSD: head/ports-mgmt/pkg/Makefile 370273 2014-10-07 06:53:49Z bapt $

PORTNAME=		pkg
PORTVERSION=	1.3.8

COMMENT=		Package manager

MASTERDIR=	/usr/ports/ports-mgmt/pkg

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
