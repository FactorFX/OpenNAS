# Created by: Xin LI <delphij@FreeBSD.org>
# $FreeBSD: head/net/openldap24-client/Makefile 342258 2014-02-02 09:51:17Z miwi $

DISTVERSION=	2.4.41

MASTERDIR=	/usr/ports/net/openldap24-server

COMMENT=	 Open source LDAP client implementation with SASL2 support

STAGEDIR=	${NAS4FREE_ROOTFS}

CONFLICTS=

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	@for prog in ldapcompare ldapdelete ldapexop ldapmodify ldapmodrdn ldappasswd ldapsearch ldapurl ldapwhoami; do\
			${CP} ${WRKSRC}/clients/tools/.libs/$${prog} ${NAS4FREE_ROOTFS}/usr/local/bin; \
	done

	${CP} /usr/local/bin/ldapadd ${NAS4FREE_ROOTFS}/usr/local/bin

.include "${MASTERDIR}/Makefile"
