# $FreeBSD: head/sysutils/bacula-client/Makefile 360216 2014-07-02 16:14:10Z bapt $

PORTNAME=	bacula
PKGNAMESUFFIX=	-client
DISTVERSION=	7.0.5

COMMENT=	Network backup solution (client)

WITH_CLIENT_ONLY=yes
USE_RC_SUBR=	bacula-fd

PLIST=		${PKGDIR}/pkg-plist.client
MASTERDIR=	/usr/ports/sysutils/bacula-server

OPTIONS_DEFINE=	NLS OPENSSL PYTHON
OPTIONS_DEFAULT=NLS OPENSSL

do-install:
	# manpages
	$(MKDIR) ${NAS4FREE_ROOTFS}/usr/share/man/man8
	for I in ${MP8}; \
		do (rm -f ${WRKSRC}/manpages/$$I.gz; gzip -c ${WRKSRC}/manpages/$$I >${WRKSRC}/manpages/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/manpages/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8/$$I.gz; \
			rm -f ${WRKSRC}/manpages/$$I.gz); \
	done
	$(MKDIR) ${NAS4FREE_ROOTFS}/usr/share/man/man1
	for I in ${MP1}; \
		do (rm -f ${WRKSRC}/manpages/$$I.gz; gzip -c ${WRKSRC}/manpages/$$I >${WRKSRC}/manpages/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/manpages/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/manpages/$$I.gz); \
	done
	
	# bconsole
	${INSTALL_PROGRAM} ${WRKSRC}/src/console/.libs/bconsole ${NAS4FREE_ROOTFS}/usr/local/sbin/
	@${CP} -pv ${WRKSRC}/src/console/bconsole.conf ${NAS4FREE_ROOTFS}/usr/local/etc/
	${CHGRP} -f ${BACULA_GROUP} ${NAS4FREE_ROOTFS}/usr/local/etc/bconsole.conf
	#	ensure that users in the bacula group can run bconsole
	${CHGRP} -f ${BACULA_GROUP} ${NAS4FREE_ROOTFS}/usr/local/sbin/bconsole

	# fd
	${INSTALL_PROGRAM} ${WRKSRC}/src/filed/.libs/bacula-fd ${NAS4FREE_ROOTFS}/usr/local/sbin/
	@${CP} -pv ${WRKSRC}/src/filed/bacula-fd.conf ${NAS4FREE_ROOTFS}/usr/local/etc/
	${CHGRP} -f ${BACULA_GROUP} ${WRKSRC}/src/filed/bacula-fd.conf

	#libs
	@${CP} -pv ${WRKSRC}/src/findlib/.libs/lib*.so.* ${NAS4FREE_ROOTFS}/usr/local/lib/
	@${CP} -pv ${WRKSRC}/src/lib/.libs/lib*.so.* ${NAS4FREE_ROOTFS}/usr/local/lib/

	# 	Install config files and preserve existing ones
	${INSTALL_SCRIPT} ${FILESDIR}/chio-bacula ${NAS4FREE_ROOTFS}/usr/local/bin/
	${INSTALL_DATA} ${FILESDIR}/bacula-barcodes ${NAS4FREE_ROOTFS}/usr/local/bin/

	# Install service script
	@${INSTALL_SCRIPT} -v ${FILESDIR}/bacula-fd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_fd

.include "${MASTERDIR}/Makefile"
