# $FreeBSD: head/sysutils/bacula-client/Makefile 360216 2014-07-02 16:14:10Z bapt $

PORTNAME=	zsh

COMMENT=	The Z shell

MASTERDIR=	/usr/ports/shells/zsh

NO_STAGE=yes

do-install:
	
	${INSTALL_PROGRAM} -v ${WRKSRC}/Src/zsh ${NAS4FREE_ROOTFS}/bin/
	
	${MKDIR} -p ${NAS4FREE_ROOTFS}/${PREFIX}/lib/zsh/${ZSH_VER}/zsh/net
	${FIND} ${WRKSRC}/Src -type f -name '*.so' -not -name 'tcp.so' -not -name 'socket.so' -exec cp -R {} ${NAS4FREE_ROOTFS}/${PREFIX}/lib/zsh/${ZSH_VER}/zsh \;
	${FIND} ${WRKSRC}/Src -type f \( -name 'tcp.so' -o -name 'socket.so' \) -exec cp -R {} ${NAS4FREE_ROOTFS}/${PREFIX}/lib/zsh/${ZSH_VER}/zsh/net \;
	
	sdir_top="${WRKSRC}" \
	fndir="${NAS4FREE_ROOTFS}/${PREFIX}/share/zsh/${ZSH_VER}/functions" \
	dir_top="${WRKSRC}" \
	scriptdir="${NAS4FREE_ROOTFS}/${PREFIX}/share/zsh/${ZSH_VER}/scripts" \
	FUNCTIONS_SUBDIRS="yes" \
	INSTALL_DATA="$(INSTALL_DATA)" \
	INSTALL_PROGRAM="$(INSTALL_PROGRAM)" \
	DESTDIR="" VERSION="${ZSH_VER}" \
	${WRKSRC}/Config/installfns.sh || exit 1;

	##manpages
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/share/man/man1
	for I in ${MANPAGES}; \
		do (rm -f ${WRKSRC}/Doc/$$I.gz; gzip -c ${WRKSRC}/Doc/$$I >${WRKSRC}/Doc/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/Doc/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/Doc/$$I.gz); \
	done
	
.include "${MASTERDIR}/Makefile"
