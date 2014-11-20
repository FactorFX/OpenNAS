# Created by: markm
# $FreeBSD: head/lang/perl5.16/Makefile 357601 2014-06-12 14:33:28Z mat $

PORTNAME=		perl
PORTVERSION=	${PERL_VERSION}

PERL_VERSION=	5.16.3

COMMENT=	Practical Extraction and Report Language

MASTERDIR=	/usr/ports/lang/perl5.16

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
