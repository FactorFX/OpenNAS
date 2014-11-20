# $FreeBSD: head/sysutils/bacula-client/Makefile 360216 2014-07-02 16:14:10Z bapt $

PORTNAME=	bacula
PKGNAMESUFFIX=	5-client
DISTVERSION=	5.2.12

COMMENT=	Network backup solution (client)

WITH_CLIENT_ONLY=yes
USE_RC_SUBR=	bacula-fd

PLIST=		${PKGDIR}/pkg-plist.client
MASTERDIR=	/usr/ports/sysutils/bacula5-server

OPTIONS_DEFINE=	NLS OPENSSL PYTHON
OPTIONS_DEFAULT=NLS OPENSSL

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	# Install service script
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/bacula-fd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_fd

.include "${MASTERDIR}/Makefile"
