# Created by: erich@rrnet.com
# $FreeBSD: head/security/sudo/Makefile 370967 2014-10-16 02:05:17Z wxs $

PORTNAME=	sudo
DISTVERSION=	1.8.11p1

MASTERDIR=	/usr/ports/security/sudo

COMMENT=	Allow others to run commands as root

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	${INSTALL_DATA} ${FILESDIR}/pam.conf ${STAGEDIR}${PREFIX}/etc/pam.d/sudo.default
	${TOUCH} ${STAGEDIR}${PREFIX}/etc/sudoers.d/.keep-me
	${STRIP_CMD} ${STAGEDIR}${PREFIX}/bin/sudoreplay
	${STRIP_CMD} ${STAGEDIR}${PREFIX}/sbin/visudo
.for f in group_file.so libsudo_util.so sudoers.so system_group.so
	${STRIP_CMD} ${STAGEDIR}${PREFIX}/libexec/sudo/${f}
.endfor


do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	@${LN} -fsv /var/etc/sudoers ${NAS4FREE_ROOTFS}/usr/local/etc/sudoers
	@${LN} -fsv /var/etc/sudoers.d/ ${NAS4FREE_ROOTFS}/usr/local/etc/sudoers.d/

.include "${MASTERDIR}/Makefile"
