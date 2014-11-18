# $FreeBSD: head/sysutils/bacula-client/Makefile 360216 2014-07-02 16:14:10Z bapt $

PORTNAME=	bacula
PKGNAMESUFFIX=	-server
DISTVERSION=	5.2.12

COMMENT=	Network backup solution (server)

USE_RC_SUBR=	bacula-sd

PLIST=		${PKGDIR}/pkg-plist.client
MASTERDIR=	/usr/ports/sysutils/bacula-server

MAN8+=	bbacula.8 bacula-sd.8 bcopy.8 bextract.8 bls.8 bscan.8 \
		btape.8 btraceback.8 dbcheck.8 bwild.8 bregex.8

do-install:
	# manpages
	$(MKDIR) ${NAS4FREE_ROOTFS}/usr/local/man/man8
	for I in ${MAN8}; \
		do (rm -f ${WRKSRC}/manpages/$$I.gz; gzip -c ${WRKSRC}/manpages/$$I >${WRKSRC}/manpages/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/manpages/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8/$$I.gz; \
			rm -f ${WRKSRC}/manpages/$$I.gz); \
	done
	
	# stored
	${INSTALL_PROGRAM} ${WRKSRC}/src/stored/.libs/bscan ${NAS4FREE_ROOTFS}/usr/local/sbin/
.for file in bacula-sd bcopy bextract bls btape
	${INSTALL_PROGRAM} ${WRKSRC}/src/stored/${file} ${NAS4FREE_ROOTFS}/usr/local/sbin/
.endfor

	@${CP} -pv ${WRKSRC}/src/stored/bacula-sd.conf ${NAS4FREE_ROOTFS}/usr/local/etc/
	${CHGRP} -f ${BACULA_GROUP} ${NAS4FREE_ROOTFS}/usr/local/etc/bacula-sd.conf

	# tools
.for file in bbatch bvfs_test dbcheck ing_test
	${INSTALL_PROGRAM} ${WRKSRC}/src/tools/.libs/${file} ${NAS4FREE_ROOTFS}/usr/local/sbin/
.endfor

	#libs
	@${CP} -pv ${WRKSRC}/src/cats/.libs/libbacsql*.so* ${NAS4FREE_ROOTFS}/usr/local/lib/
	@${CP} -pv ${WRKSRC}/src/cats/.libs/libbaccats*.so* ${NAS4FREE_ROOTFS}/usr/local/lib/

	# 	Install config files and preserve existing ones
	${INSTALL_SCRIPT} ${FILESDIR}/chio-bacula ${NAS4FREE_ROOTFS}/usr/local/bin/
	${INSTALL_DATA} ${FILESDIR}/bacula-barcodes ${NAS4FREE_ROOTFS}/usr/local/bin/

	# Install service script
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/bacula-sd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_sd

post-install:
	${ECHO} "Do nothing"

.include "${MASTERDIR}/Makefile"
