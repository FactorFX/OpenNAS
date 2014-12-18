# Created by: markm
# $FreeBSD: head/lang/perl5.16/Makefile 357601 2014-06-12 14:33:28Z mat $

PORTNAME=		perl

COMMENT=	Practical Extraction and Report Language

MASTERDIR=	/usr/ports/lang/perl5.18

post-install:
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_MAN3}
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_ARCH}/auto
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_PERL}/auto
	${LN} ${NAS4FREE_ROOTFS}${PREFIX}/bin/perl${PERL_VERSION} ${NAS4FREE_ROOTFS}${PREFIX}/bin/perl5
	${LN} -sf libperl.so.${PERL_VERSION} ${NAS4FREE_ROOTFS}${PREFIX}/${_ARCH_LIB}/CORE/libperl.so
	${LN} -sf libperl.so.${PERL_VERSION} ${NAS4FREE_ROOTFS}${PREFIX}/${_ARCH_LIB}/CORE/libperl.so.${PERL_VER}
	${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/bin/perl${PERL_VERSION}
	${INSTALL_DATA} ${WRKDIR}/perl5_version ${NAS4FREE_ROOTFS}${PREFIX}/etc
	${FIND} ${NAS4FREE_ROOTFS} -name '*.bs' -size 0 -delete
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_ARCH}/machine
	${MKDIR} ${NAS4FREE_ROOTFS}${SITE_ARCH}/sys
	# h2ph needs perl, but perl is not installed, it's only
	# staged, so, use the one in WRKDIR 
	(cd /usr/include && ${SETENV} LD_LIBRARY_PATH=${WRKSRC} \
		${WRKSRC}/perl -I ${WRKSRC}/lib ${NAS4FREE_ROOTFS}${PREFIX}/bin/h2ph \
		-d ${NAS4FREE_ROOTFS}${SITE_ARCH} *.h machine/*.h sys/*.h >/dev/null)
	@${FIND} ${NAS4FREE_ROOTFS}${SITE_ARCH} -name '*.ph' | sed -e 's|${NAS4FREE_ROOTFS}||' >> ${TMPPLIST}
	${FIND} ${NAS4FREE_ROOTFS}/usr/local/lib -name '*.so*' -type f | while read f; \
		do \
			${CHMOD} 644 $$f; \
			${STRIP_CMD} $$f; \
			${CHMOD} 444 $$f; \
		done
	${INSTALL_DATA} ${WRKDIR}/perl-man.conf ${NAS4FREE_ROOTFS}${PREFIX}/etc/man.d/perl${PERL_VER}.conf

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
