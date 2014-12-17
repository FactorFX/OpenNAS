# $FreeBSD: head/ports-mgmt/pkg/Makefile 370273 2014-10-07 06:53:49Z bapt $

PORTNAME=		pkg

COMMENT=		Package manager

MASTERDIR=	/usr/ports/ports-mgmt/pkg

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	@${RM} ${NAS4FREE_ROOTFS}/usr/local/etc/pkg.conf.sample
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/etc/pkg/repos
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/pkg.conf ${NAS4FREE_ROOTFS}/usr/local/etc/pkg/repos

.include "${MASTERDIR}/Makefile"
