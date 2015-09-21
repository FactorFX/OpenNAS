# Created by: Ralf van Dooren <r.vdooren@snow.nl>
# $FreeBSD: head/sysutils/rsnapshot/Makefile 371526 2014-10-26 21:04:21Z swills $

PORTNAME=		rsnapshot

COMMENT=		Filesystem snapshot utility based on rsync(1)

MASTERDIR=	/usr/ports/sysutils/rsnapshot

STAGEDIR=	${NAS4FREE_ROOTFS}

PLIST= ${MASTERDIR}/pkg-plist

fix-perl-things:
	echo 'Ignore some fix for perl'

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	
.include "${MASTERDIR}/Makefile"