# Created by: Andrew Pantyukhin <infofarmer@FreeBSD.org>
# $FreeBSD: sysutils/ncdu/Makefile 317888 2013-05-11 15:31:46Z pawel $

PORTNAME=		ncdu
PORTVERSION=	1.10

COMMENT=	Ncurses du(1)

MAN1=		${PORTNAME}.1

MASTERDIR=	/usr/ports/sysutils/ncdu

do-install:
	@${INSTALL_PROGRAM} ${WRKSRC}/ncdu ${NAS4FREE_ROOTFS}/${PREFIX}/bin

	gzip -c ${WRKSRC}/${PORTNAME}.1 >${WRKSRC}/${PORTNAME}.1.gz
	${MKDIR} -v ${NAS4FREE_ROOTFS}/usr/local/man/man1
	@$(INSTALL_DATA) ${WRKSRC}/${PORTNAME}.1.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1
	rm -f ${WRKSRC}/${PORTNAME}.1.gz

.include "${MASTERDIR}/Makefile"

