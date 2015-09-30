# Created by: David O'Brien (obrien@cs.ucdavis.edu)
# $FreeBSD: head/net/rsync/Makefile 386312 2015-05-14 10:15:04Z mat $

PORTNAME=       rsync

COMMENT=        Network file distribution/synchronization utility

MASTERDIR=      /usr/ports/net/rsync

STAGEDIR=       ${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"

ACL_EXTRA_PATCHES= ${WRKSRC}/patches/acls.diff \
				   ${.CURDIR}/files/extrapatch-acl

do-install:
	@${INSTALL_PROGRAM} -v ${WRKSRC}/rsync ${NAS4FREE_ROOTFS}/usr/local/bin