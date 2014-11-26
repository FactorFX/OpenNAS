# Created by: Xin LI <delphij@FreeBSD.org>
# $FreeBSD: head/net/openldap24-client/Makefile 342258 2014-02-02 09:51:17Z miwi $

DISTVERSION=	2.4.40

CLIENT_ONLY=	yes

MASTERDIR=	/usr/ports/net/openldap24-server

COMMENT=	 Open source LDAP client implementation with SASL2 support

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	@${LN} -fsv /var/etc/ldap.conf ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/ldap.conf	
	@${LN} -fsv /var/etc/ldap.secret ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/ldap.secret
	@${RM} ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/ldap.conf.sample

.include "${MASTERDIR}/Makefile"
