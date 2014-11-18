# Created by: David O'Brien (obrien@NUXI.com)
# $FreeBSD: head/editors/vim-lite/Makefile 346419 2014-02-28 01:30:02Z sunpoet $

PORTVERSION=	7.4.${PATCHLEVEL}
PORTREVISION=	0

MAINTAINER=	sunpoet@FreeBSD.org
COMMENT=	Improved version of the vi editor (lite package)

LITE=		yes
MASTERDIR=	/usr/ports/editors/vim

MAN1=		evim.1 vim.1 vimdiff.1 vimtutor.1 xxd.1

do-install:
	@${INSTALL_PROGRAM} -v ${WRKSRC}/src/vim ${NAS4FREE_ROOTFS}/${PREFIX}/bin/vim
	${MKDIR} -p ${NAS4FREE_ROOTFS}/${PREFIX}/share/vim/${_DATADIR}
	(cd ${WRKSRC}/runtime/ && ${COPYTREE_SHARE} . ${NAS4FREE_ROOTFS}/${PREFIX}/share/vim/${_DATADIR})
	
	## Manpage
	$(MKDIR) ${NAS4FREE_ROOTFS}/usr/local/man/man1
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/runtime/doc/$$I.gz; gzip -c ${WRKSRC}/runtime/doc/$$I >${WRKSRC}/runtime/doc/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/runtime/doc/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/runtime/doc/$$I.gz); \
	done

.include "${MASTERDIR}/Makefile"
