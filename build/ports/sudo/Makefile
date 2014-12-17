# Created by: erich@rrnet.com
# $FreeBSD: head/security/sudo/Makefile 370967 2014-10-16 02:05:17Z wxs $

PORTNAME=	sudo

MASTERDIR=	/usr/ports/security/sudo

COMMENT=	Allow others to run commands as root

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	${TOUCH} ${STAGEDIR}${PREFIX}/etc/sudoers.d/.keep-me
	${MV} ${STAGEDIR}${PREFIX}/etc/sudoers ${STAGEDIR}${PREFIX}/etc/sudoers.sample
	${STRIP_CMD} ${STAGEDIR}${PREFIX}/bin/sudoreplay
	${STRIP_CMD} ${STAGEDIR}${PREFIX}/sbin/visudo
.for f in group_file.so libsudo_util.so sudoers.so system_group.so
	${STRIP_CMD} ${STAGEDIR}${PREFIX}/libexec/sudo/${f}
.endfor

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"