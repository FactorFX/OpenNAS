# Created by: Paul Dlug<paul@nerdlabs.com>
# $FreeBSD: head/net-mgmt/nrpe/Makefile 369602 2014-09-30 13:52:58Z mat $


PORTNAME=	nrpe

COMMENT=	Nagios Remote Plugin Executor

MASTERDIR=	/usr/ports/net-mgmt/nrpe

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

	${CP} -v ${WRKSRC}/sample-config/nrpe.cfg ${NAS4FREE_ROOTFS}/usr/local/etc/nrpe.cfg.sample

	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/libexec/nagios/
	${INSTALL_PROGRAM} -v ${WRKSRC}/src/check_nrpe ${NAS4FREE_ROOTFS}/usr/local/libexec/nagios/check_nrpe2

	${INSTALL_PROGRAM} -v ${WRKSRC}/src/nrpe ${NAS4FREE_ROOTFS}/usr/local/sbin/nrpe2

	${MKDIR} ${NAS4FREE_ROOTFS}/var/run/nrpe2

.include "${MASTERDIR}/Makefile"