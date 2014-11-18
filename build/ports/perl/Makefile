# Created by: markm
# $FreeBSD: head/lang/perl5.16/Makefile 357601 2014-06-12 14:33:28Z mat $

PORTNAME=		perl
PORTVERSION=	${PERL_VERSION}

PERL_VERSION=	5.16.3

COMMENT=	Practical Extraction and Report Language

MASTERDIR=	/usr/ports/lang/perl5.16

do-install:
	${WRKDIR}/perl installperl --destdir=${NAS4FREE_ROOTFS}
	${WRKDIR}/perl installman --destdir=/tmp/perl
	
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/local/man/man1
	for MAN in $(ls /tmp/perl/usr/local/man/man1); \
		do (gzip -c /tmp/perl/usr/local/man/man1/$$FILE > ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$FILE.gz); \
	done

post-install:
	${MKDIR} ${NAS4FREE_ROOTFS}${PREFIX}/lib/perl5/${PERL_VER}/man/man3
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_PERL}/${PERL_ARCH}/auto
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_PERL}/${PERL_ARCH}/machine
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_PERL}/${PERL_ARCH}/sys
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_PERL}/auto
	${LN} ${NAS4FREE_ROOTFS}${PREFIX}/bin/perl${PERL_VERSION} ${NAS4FREE_ROOTFS}${PREFIX}/bin/perl5
	${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/bin/perl${PERL_VERSION}
	${INSTALL_DATA} ${WRKDIR}/perl5_version ${NAS4FREE_ROOTFS}${PREFIX}/etc
.if ${OSVERSION} >= 900022
	${INSTALL_DATA} ${WRKDIR}/perl-man.conf ${NAS4FREE_ROOTFS}${PREFIX}/etc/man.d/perl${PERL_VER}.conf
.endif
.for files in ${BSDPAN_FILES}
	${MKDIR} ${NAS4FREE_ROOTFS}${BSDPAN_DEST}/${files:H}
	${INSTALL_DATA} ${BSDPAN_WRKSRC}/${files} ${NAS4FREE_ROOTFS}${BSDPAN_DEST}/${files}
.endfor

.include "${MASTERDIR}/Makefile"
