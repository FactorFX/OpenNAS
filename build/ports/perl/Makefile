# Created by: markm
# $FreeBSD: head/lang/perl5.16/Makefile 357601 2014-06-12 14:33:28Z mat $

PORTNAME=		perl
PORTVERSION=	${PERL_VERSION}

PERL_VERSION=	5.16.3

COMMENT=	Practical Extraction and Report Language

MASTERDIR=	/usr/ports/lang/perl5.16

STAGEDIR = ${NAS4FREE_ROOTFS}

do-install:
	${WRKDIR}/perl installperl --destdir=${NAS4FREE_ROOTFS}
	${WRKDIR}/perl installman --destdir=/tmp/perl
	
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/local/man/man1
	for MAN in $(ls /tmp/perl/usr/local/man/man1); \
		do (gzip -c /tmp/perl/usr/local/man/man1/$$FILE > ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$FILE.gz); \
	done

.include "${MASTERDIR}/Makefile"
