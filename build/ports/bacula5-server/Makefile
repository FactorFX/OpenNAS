# Created by: Dmitry Sivachenko <demon@FreeBSD.org>
# $FreeBSD: head/sysutils/bacula5-server/Makefile 368446 2014-09-18 12:31:24Z mat $


PORTNAME=	bacula
PKGNAMESUFFIX=	5-server
DISTVERSION=	5.2.12

COMMENT=	Network backup solution (server)

CONFFILES= sd
USE_RC_SUBR=  bacula-sd

CONFIGURE_ARGS+= --disable-build-dird

MASTERDIR=	/usr/ports/sysutils/bacula5-server

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	${REINPLACE_CMD} "/@sample/d" ${TMPPLIST}

do-install:
	env LOCALBASE=/usr/local $(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	# Install service script
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/bacula-sd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_sd

.include "${MASTERDIR}/Makefile"

