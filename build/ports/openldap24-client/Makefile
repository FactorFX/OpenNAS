# Created by: Xin LI <delphij@FreeBSD.org>
# $FreeBSD: head/net/openldap24-client/Makefile 342258 2014-02-02 09:51:17Z miwi $

DISTVERSION=	2.4.40

CLIENT_ONLY=	yes

MASTERDIR=	/usr/ports/net/openldap24-server

COMMENT=	Allow others to run commands as root

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
