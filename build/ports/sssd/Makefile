# Created by: Lukas Slebodnik <lukas.slebodnik@intrak.sk>
# $FreeBSD: head/security/sssd/Makefile 358784 2014-06-22 10:44:29Z tijl $

PORTNAME=		sssd
DISTVERSION=	1.9.6

COMMENT=		System Security Services Daemon

MASTERDIR=	/usr/ports/security/sssd

STAGEDIR=	${NAS4FREE_ROOTFS}

post-install:
	(cd ${STAGEDIR}${PREFIX}/lib && ${LN} -s nss_sss.so nss_sss.so.1)

	# clean these up from the install; we create them in rc script start_precmd
.for VARDIRS in db/sss db/sss_mc log/sssd run/sss/krb5.include.d run/sss/private run/sss
	@${RMDIR} ${STAGEDIR}/var/${VARDIRS}
.endfor

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	@${INSTALL_SCRIPT} -v ${.CURDIR}/files/sssd.in ${NAS4FREE_ROOTFS}/etc/rc.d/sssd

.include "${MASTERDIR}/Makefile"
