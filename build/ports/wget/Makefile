# Created by: Thomas Gellekum <tg@FreeBSD.org>
# $FreeBSD: head/ftp/wget/Makefile 366659 2014-08-30 18:18:14Z tijl $

PORTNAME=		wget
DISTVERSION=	1.15

COMMENT=	Retrieve files from the Net via HTTP(S) and FTP

MASTERDIR=	/usr/ports/ftp/wget

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	${REINPLACE_CMD} "/wgetrc.sample/d" ${TMPPLIST}
	${REINPLACE_CMD} "/licenses/d" ${TMPPLIST}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
