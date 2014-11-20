# Created by: Dmitry Sivachenko <demon@FreeBSD.org>
# $FreeBSD: head/sysutils/bacula5-server/Makefile 368446 2014-09-18 12:31:24Z mat $


PORTNAME=	bacula
PKGNAMESUFFIX=	5-server
DISTVERSION=	5.2.12

COMMENT=	Network backup solution (server)

USE_RC_SUBR=	bacula-sd

MASTERDIR=	/usr/ports/sysutils/bacula5-server

STAGEDIR=	${NAS4FREE_ROOTFS}

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

.include "${MASTERDIR}/Makefile"
