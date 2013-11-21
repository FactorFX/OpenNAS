# Created by: Dmitry Sivachenko <demon@FreeBSD.org>
# $FreeBSD: sysutils/bacula-server/Makefile 317491 2013-05-06 09:07:58Z bapt $

PORTNAME=	bacula
DISTVERSION=	5.2.12
PORTREVISION?=	3
CATEGORIES?=	sysutils
MASTER_SITES=	SF/bacula/bacula/${PORTVERSION}
PKGNAMEPREFIX?=	#

MAINTAINER=	dan@langille.org
COMMENT?=	Network backup solution (server)

LIB_DEPENDS+=   lzo2:${PORTSDIR}/archivers/lzo2

UNIQUENAME?=	${PORTNAME}${PKGNAMESUFFIX}

USERS=		bacula
GROUPS=		${USERS}

PLIST=		${PKGDIR}/pkg-plist.client
PLIST_SUB+=	MAJOR=${PORTVERSION:R:R}

GNU_CONFIGURE=	yes
USE_LDCONFIG=	yes

CPPFLAGS+=	-I/usr/include/readline -I${LOCALBASE}/include
LDFLAGS+=	-L${LOCALBASE}/lib

OPTIONS_DEFINE?=	SQLITE3 MYSQL PGSQL MTX NLS OPENSSL
OPTIONS_DEFAULT?=	MTX NLS OPENSSL SQLITE3

MTX_DESC=		Install mtx for control of autochanger devices

.include <bsd.port.options.mk>

#LIB_DEPENDS+=   bac:${PORTSDIR}/sysutils/bacula-client
USE_RC_SUBR?=	bacula-fd bacula-dir bacula-sd 

MANCOMPRESSED=	yes

CONFIGURE_ARGS+=--with-tcp-wrappers=/usr/lib \
		--enable-smartalloc \
		--with-working-dir=${BACULA_DIR} \
		--with-scriptdir=/usr/local/share/${PORTNAME} \
		--with-readline=yes \
		--enable-conio \
		--without-tcp-wrappers \
		--with-python=yes \
		--enable-batch-insert \
		--with-plugindir=/usr/local/lib \
		--with-dump-email=root@localhost \
		--with-job-email=root@localhost \
		--with-db-name=bacula \
		--with-sbin-perm=755 \
		--with-db-user=bacula \
		--with-baseport=9101 \
		--with-fd-user=root \
		--with-fd-group=wheel \
		--with-dir-user=${BACULA_USER} \
		--with-dir-group=${BACULA_GROUP} \
		--with-sd-user=${BACULA_USER} \
		--with-sd-group=operator \

BACULA_USER?=	bacula
BACULA_GROUP?=	${BACULA_USER}
BACULA_UID?=	910
BACULA_GID?=	${BACULA_UID}
BACULA_DIR?=	/var/db/bacula

PLIST_SUB+=	BACULA_DIR=${BACULA_DIR}

SUB_LIST=	BACULA_USER=${BACULA_USER} \
		BACULA_GROUP=${BACULA_GROUP} \
		BACULA_UID=${BACULA_UID} \
		BACULA_GID=${BACULA_GID} \
		BACULA_DIR=${BACULA_DIR}

CONFFILES=		fd sd dir
CONFIGURE_ARGS+= --with-sqlite3=yes

DBTYPE=			sqlite3
SUB_LIST+=		REQ_MYSQL="" REQ_PGSQL="" REQ_SQLITE3="sqlite3"
PLIST_SUB+=		DBTYPE=${DBTYPE}

.if ${PORT_OPTIONS:MNLS}
USES+=			gettext
CONFIGURE_ARGS+=	--enable-nls
.else
CONFIGURE_ARGS+=	--disable-nls
.endif

.if ${PORT_OPTIONS:MOPENSSL}
.include "${PORTSDIR}/Mk/bsd.openssl.mk"
CONFIGURE_ARGS+=	--with-openssl=${OPENSSLBASE}
.else
CONFIGURE_ARGS+=	--with-openssl="no"
.endif

MAN8+=	bacula-fd.8 bconsole.8 bacula.8 bacula-dir.8 bacula-sd.8 bcopy.8 bextract.8 bls.8 bscan.8 \
	btape.8 btraceback.8 dbcheck.8 bwild.8 bregex.8
MAN1+=	bsmtp.1

MAKE_ENV+=	MAN8="${MAN8}" MAN1="${MAN1}"

post-patch:
#	This port does not install docs.  See bacula-docs for that
	${REINPLACE_CMD} -e '/docdir/d' ${WRKSRC}/Makefile.in
#	Change $(ECHO) to echo in some Makefile.in files
	@${REINPLACE_CMD} -e 's|$$(ECHO)|echo|g' ${WRKSRC}/src/filed/Makefile.in \
		${WRKSRC}/src/console/Makefile.in
#	Default bconsole.conf is ${PREFIX}/etc
	@${REINPLACE_CMD} -e 's|./bconsole.conf|${PREFIX}/etc/bconsole.conf|g' ${WRKSRC}/src/console/console.c
	@${REINPLACE_CMD} -e 's|^MAN8 =|MAN8 ?=|g' -e 's|^MAN1 =|MAN1 ?=|g' ${WRKSRC}/manpages/Makefile.in

# 	In client port only install startup script out of script dir (see below post-install)
# 	Dont mkdir ${PREFIX}/share/bacula cause it's empty
	${REINPLACE_CMD} -e 's|\(.*$${MKDIR} $${DESTDIR}$${scriptdir}\)|#\1|g' ${WRKSRC}/Makefile.in
#	In server port don't install filed
	@${REINPLACE_CMD} -e 's|@FD_PLUGIN_DIR@||' ${WRKSRC}/Makefile.in
	@${REINPLACE_CMD} -e 's|fd_plugins.h|filed/fd_plugins.h|g' -e 's|dir_plugins.h|dird/dir_plugins.h|g' -e 's|stored.h|stored/stored.h|g' \
		${WRKSRC}/src/tools/bpluginfo.c

do-install:
	# manpages
	$(MKDIR) ${NAS4FREE_ROOTFS}/usr/share/man/man8
	for I in ${MAN8}; \
		do (rm -f ${WRKSRC}/manpages/$$I.gz; gzip -c ${WRKSRC}/manpages/$$I >${WRKSRC}/manpages/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/manpages/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man8/$$I.gz; \
			rm -f ${WRKSRC}/manpages/$$I.gz); \
	done
	$(MKDIR) ${NAS4FREE_ROOTFS}/usr/share/man/man1
	for I in ${MAN1}; \
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

	# cats
	@${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/bacula
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/create_*_database ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/drop_*_database ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/drop_*_tables ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/fix_*_tables ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/grant_*_privileges ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/make_*_tables ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/make_*_backup ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/update_*_tables ${NAS4FREE_ROOTFS}/usr/local/share/bacula/

	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/make_catalog_backup.pl ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/make_catalog_backup ${NAS4FREE_ROOTFS}/usr/local/share/bacula/
	${INSTALL_SCRIPT} ${WRKSRC}/src/cats/delete_catalog_backup ${NAS4FREE_ROOTFS}/usr/local/share/bacula/

	# dird
	#${INSTALL_PROGRAM} ${WRKSRC}/src/dird/.libs/bacula-dir ${NAS4FREE_ROOTFS}/usr/local/sbin/
	#@${CP} -pv ${WRKSRC}/src/dird/bacula-dir.conf ${NAS4FREE_ROOTFS}/usr/local/etc/
	#${CHGRP} -f ${BACULA_GROUP} ${NAS4FREE_ROOTFS}/usr/local/etc/bacula-dir.conf

	# stored
.for file in bacula-sd bcopy bextract bls bscan btape
	${INSTALL_PROGRAM} ${WRKSRC}/src/stored/.libs/${file} ${NAS4FREE_ROOTFS}/usr/local/sbin/
.endfor

	@${CP} -pv ${WRKSRC}/src/stored/bacula-sd.conf ${NAS4FREE_ROOTFS}/usr/local/etc/
	${CHGRP} -f ${BACULA_GROUP} ${NAS4FREE_ROOTFS}/usr/local/etc/bacula-sd.conf

	# tools
.for file in bbatch bpluginfo bregex bregtest bsmtp bvfs_test bwild dbcheck drivetype fstype grow ing_test testfind testls
	${INSTALL_PROGRAM} ${WRKSRC}/src/tools/.libs/${file} ${NAS4FREE_ROOTFS}/usr/local/sbin/
.endfor

	# fd
	${INSTALL_PROGRAM} ${WRKSRC}/src/filed/.libs/bacula-fd ${NAS4FREE_ROOTFS}/usr/local/sbin/
	@${CP} -pv ${WRKSRC}/src/filed/bacula-fd.conf ${NAS4FREE_ROOTFS}/usr/local/etc/
	${CHGRP} -f ${BACULA_GROUP} ${WRKSRC}/src/filed/bacula-fd.conf

    #libs
	@${CP} -pv ${WRKSRC}/src/cats/.libs/libbacsql.so.* ${NAS4FREE_ROOTFS}/usr/local/lib/
	@${CP} -pv ${WRKSRC}/src/cats/.libs/libbaccats*.so.* ${NAS4FREE_ROOTFS}/usr/local/lib/
	@${CP} -pv ${WRKSRC}/src/findlib/.libs/lib*.so.* ${NAS4FREE_ROOTFS}/usr/local/lib/
	@${CP} -pv ${WRKSRC}/src/lib/.libs/lib*.so.* ${NAS4FREE_ROOTFS}/usr/local/lib/

	# 	Install config files and preserve existing ones
	${INSTALL_SCRIPT} ${FILESDIR}/chio-bacula ${NAS4FREE_ROOTFS}/usr/local/bin/
	${INSTALL_DATA} ${FILESDIR}/bacula-barcodes ${NAS4FREE_ROOTFS}/usr/local/bin/

	# Install service srcipt
	@${INSTALL_SCRIPT} -v ${FILESDIR}/bacula-fd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_fd
	@${INSTALL_SCRIPT} -v ${FILESDIR}/bacula-sd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_sd
	#@${INSTALL_SCRIPT} -v ${FILESDIR}/bacula-dir.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_dir

.include <bsd.port.mk>
