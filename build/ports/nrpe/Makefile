# Created by: Paul Dlug<paul@nerdlabs.com>
# $FreeBSD: head/net-mgmt/nrpe/Makefile 369602 2014-09-30 13:52:58Z mat $


PORTNAME=	nrpe

COMMENT=	Nagios Remote Plugin Executor

MASTERDIR=	/usr/ports/net-mgmt/nrpe

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"