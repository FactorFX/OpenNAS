# Created by: erich@rrnet.com
# $FreeBSD: head/security/sudo/Makefile 370967 2014-10-16 02:05:17Z wxs $

PORTNAME=	sudo
DISTVERSION=	1.8.11p1

MASTERDIR=	/usr/ports/security/sudo

COMMENT=	Allow others to run commands as root

post-install:
	${INSTALL_DATA} ${FILESDIR}/pam.conf ${NAS4FREE_ROOTFS}${PREFIX}/etc/pam.d/sudo.default
	${TOUCH} ${NAS4FREE_ROOTFS}${PREFIX}/etc/sudoers.d/.keep-me
	${MV} ${NAS4FREE_ROOTFS}${PREFIX}/etc/sudoers ${NAS4FREE_ROOTFS}${PREFIX}/etc/sudoers.sample
	${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/bin/sudoreplay
	${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/sbin/visudo
.for f in group_file.so libsudo_util.so sudoers.so system_group.so
	${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/libexec/sudo/${f}
.endfor

do-install:
	${CD} ${WRKSRC}
	$(MAKE) install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile
