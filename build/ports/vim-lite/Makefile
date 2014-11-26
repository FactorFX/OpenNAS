# Created by: David O'Brien (obrien@NUXI.com)
# $FreeBSD: head/editors/vim-lite/Makefile 346419 2014-02-28 01:30:02Z sunpoet $

PORTVERSION=	7.4.${PATCHLEVEL}
PORTREVISION=	0

MAINTAINER=	sunpoet@FreeBSD.org
COMMENT=	Improved version of the vi editor (lite package)

LITE=		yes
MASTERDIR=	/usr/ports/editors/vim

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	${REINPLACE_CMD} "/@sample/d" ${TMPPLIST}
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
