# $FreeBSD: head/sysutils/bacula-client/Makefile 360216 2014-07-02 16:14:10Z bapt $

PORTNAME=		zsh
PORTVERSION=	5.0.6

COMMENT=		The Z shell

MASTERDIR=		/usr/ports/shells/zsh

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
