# Created by: Lukas Slebodnik <lukas.slebodnik@intrak.sk>
# $FreeBSD: head/security/sssd/Makefile 358784 2014-06-22 10:44:29Z tijl $

PORTNAME=		sssd
DISTVERSION=	1.9.6

COMMENT=		System Security Services Daemon

MASTERDIR=	/usr/ports/security/sssd

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	@${INSTALL_SCRIPT} -v ${.CURDIR}/files/sssd.in ${NAS4FREE_ROOTFS}/etc/rc.d/sssd

.include "${MASTERDIR}/Makefile"
