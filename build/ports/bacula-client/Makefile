# $FreeBSD: head/sysutils/bacula-client/Makefile 360216 2014-07-02 16:14:10Z bapt $

PORTNAME=	bacula
PKGNAMESUFFIX=	-client

COMMENT=	Network backup solution (client)

WITH_CLIENT_ONLY=yes
USE_RC_SUBR=
CONFFILES=

PLIST=		${PKGDIR}/pkg-plist.client
MASTERDIR=	/usr/ports/sysutils/bacula-server

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	# Install service script
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/bacula-fd.in ${NAS4FREE_ROOTFS}/etc/rc.d/bacula_fd
	@${RM} -rf ${NAS4FREE_ROOTFS}/var/etc/${PORTNAME}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"