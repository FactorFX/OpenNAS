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

	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/ppolicy.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/ppolicy.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/java.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/java.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/pmi.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/pmi.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/duaconf.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/duaconf.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/dyngroup.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/dyngroup.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/nis.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/nis.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/collective.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/collective.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/misc.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/misc.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/core.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/core.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/inetorgperson.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/inetorgperson.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/corba.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/corba.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/cosine.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/cosine.schema
	${CP} -v ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/openldap.schema.sample ${NAS4FREE_ROOTFS}/usr/local/etc/openldap/schema/openldap.schema

.include "${MASTERDIR}/Makefile"
