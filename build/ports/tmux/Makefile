# Created by: Wen Heping <wenheping@gmail.com>
# $FreeBSD: sysutils/tmux/Makefile 323874 2013-07-29 08:30:06Z gahr $

PORTNAME=		tmux
DISTVERSION=	1.9a

COMMENT=		Terminal Multiplexer

MASTERDIR=		/usr/ports/sysutils/tmux

do-install:
	${MKDIR} ${NAS4FREE_ROOTFS}/etc/bash_completion.d
	@${INSTALL_DATA} ${WRKSRC}/examples/bash_completion_tmux.sh ${NAS4FREE_ROOTFS}/etc/bash_completion.d/tmux
	@${INSTALL_PROGRAM} ${WRKSRC}/tmux ${NAS4FREE_ROOTFS}/bin
	${CP} ${.CURDIR}/files/tmux.conf ${NAS4FREE_ROOTFS}/usr/local/etc/tmux.conf
	gzip -c ${WRKSRC}/tmux.1 >${WRKSRC}/tmux.1.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/local/man/man1
	@$(INSTALL_DATA) ${WRKSRC}/tmux.1.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1
	rm -f ${WRKSRC}/tmux.1.gz

.include "${MASTERDIR}/Makefile"
