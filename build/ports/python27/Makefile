# $FreeBSD: head/lang/python27/Makefile 372138 2014-11-04 09:14:21Z demon $

PORTNAME=		python27

COMMENT=		Interpreted object-oriented programming language

MASTERDIR=	/usr/ports/lang/python27

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"

