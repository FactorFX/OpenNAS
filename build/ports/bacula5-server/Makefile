# Created by: Dmitry Sivachenko <demon@FreeBSD.org>
# $FreeBSD: head/sysutils/bacula5-server/Makefile 368446 2014-09-18 12:31:24Z mat $


PORTNAME=	bacula
PKGNAMESUFFIX=	5-server

COMMENT=	Network backup solution (server)

CONFFILES=
USE_RC_SUBR=

MASTERDIR=	/usr/ports/sysutils/bacula5-server

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	${INSTALL_SCRIPT} ${FILESDIR}/chio-bacula ${STAGEDIR}${PREFIX}/sbin
	${INSTALL_DATA} ${FILESDIR}/bacula-barcodes ${STAGEDIR}${ETCDIR}
	${CHMOD} o+x ${STAGEDIR}${PREFIX}/sbin/bsmtp
	# Install service script
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/bacula-sd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_sd
	@${RM} -rf ${NAS4FREE_ROOTFS}/var/etc/${PORTNAME}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS} LOCALBASE=/usr/local

.include "${MASTERDIR}/Makefile"

CONFIGURE_ARGS+= --disable-build-dird