# Created by: Lukas Slebodnik <lukas.slebodnik@intrak.sk>
# $FreeBSD: head/security/sssd/Makefile 358784 2014-06-22 10:44:29Z tijl $

PORTNAME=		sssd

COMMENT=		System Security Services Daemon

MASTERDIR=	/usr/ports/security/sssd

STAGEDIR=	${NAS4FREE_ROOTFS}

MAN.1=	sss_ssh_authorizedkeys.1 sss_ssh_knownhostsproxy.1
MAN.5= sssd-ad.5 sssd-ipa.5 sssd-krb5.5 sssd-ldap.5 sssd-simple.5 sssd-sudo.5 sssd.conf.5
MAN.8= pam_sss.8 sss_cache.8 sss_debuglevel.8 sss_groupadd.8 sss_groupdel.8 sss_groupmod.8 \
	sss_groupshow.8 sss_obfuscate.8 sss_seed.8 sss_useradd.8 sss_userdel.8 sss_usermod.8 sssd.8 \
	sssd_krb5_locator_plugin.8

MANS= ${MAN.1} ${MAN.5} ${MAN.8}

SBIN_FILES= sss_cache sss_debuglevel sss_groupadd sss_groupdel \
		sss_groupmod sss_groupshow sss_seed sss_useradd sss_userdel sss_usermod sssd

LIBEXEC_FILES= krb5_child ldap_child proxy_child sssd_be sssd_nss sssd_pam sssd_ssh sssd_sudo \
		sss_signal sssd_ifp

post-install:
	${ECHO} "Do nothing"

do-install:
	@${INSTALL_SCRIPT} -v ${.CURDIR}/files/sssd.in ${NAS4FREE_ROOTFS}/etc/rc.d/sssd

.for FILE in ${SBIN_FILES}
	${INSTALL_PROGRAM} -v ${WRKSRC}/.libs/${FILE} ${NAS4FREE_ROOTFS}/usr/local/sbin/
.endfor

	${INSTALL_SCRIPT} -v ${WRKSRC}/src/tools/sss_obfuscate ${NAS4FREE_ROOTFS}/usr/local/sbin/

	${INSTALL_PROGRAM} -v ${WRKSRC}/.libs/sss_ssh_authorizedkeys ${NAS4FREE_ROOTFS}/usr/local/bin/
	${INSTALL_PROGRAM} -v ${WRKSRC}/.libs/sss_ssh_knownhostsproxy ${NAS4FREE_ROOTFS}/usr/local/bin/

	## Copy python package
	${CP} ${WRKSRC}/.libs/pyhbac.so  ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/site-packages/
	${CP} ${WRKSRC}/.libs/pysss.so ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/site-packages/
	${CP} ${WRKSRC}/.libs/pysss_murmur.so ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/site-packages/
	${CP} ${WRKSRC}/.libs/pysss_nss_idmap.so ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/site-packages/

	cd ${WRKSRC}/src/config && /usr/local/bin/python2 setup.py install --prefix=${NAS4FREE_ROOTFS}/usr/local/

	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/libexec/sssd/
	${INSTALL_PROGRAM} -v ${WRKSRC}/.libs/sssd ${NAS4FREE_ROOTFS}/usr/local/libexec/sssd/

	${MKDIR} /usr/local/share/sssd/

.for DIR in /usr/local/lib/shared-modules/ldb/ /usr/local/share/xml/ /usr/local/share/xsl/ /usr/local/lib/ldb/
	${MKDIR} ${NAS4FREE_ROOTFS}${DIR}
	${CP} -R ${DIR} ${NAS4FREE_ROOTFS}${DIR}
.endfor

.for FILE in ${LIBEXEC_FILES}
	${CP} -v ${WRKSRC}/${FILE} ${NAS4FREE_ROOTFS}/usr/local/libexec/sssd/
.endfor

.for FILE in ldbadd ldbdel ldbedit ldbmodify ldbrename ldbsearch
	${CP} -v /usr/local/bin/${FILE} ${NAS4FREE_ROOTFS}/usr/local/bin/
.endfor

	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/lib/krb5/plugins/libkrb5/
	${CP} -v ${WRKSRC}/.libs/sssd_krb5_locator_plugin.so ${NAS4FREE_ROOTFS}/usr/local/lib/krb5/plugins/libkrb5/
	${CP} -v ${WRKSRC}/.libs/libipa_hbac.so ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/libipa_hbac.so.0 ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/libipa_hbac.so.0.0.1 ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/libsss_idmap.so ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/libsss_idmap.so.0 ${NAS4FREE_ROOTFS}/usr/local/lib/
	${LN} -sfv /usr/local/lib/libsss_idmap.so ${NAS4FREE_ROOTFS}/usr/local/lib/libsss_idmap.so.0.0
	${CP} -v ${WRKSRC}/.libs/libsss_sudo.so ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/nss_sss.so ${NAS4FREE_ROOTFS}/usr/local/lib/
	${LN} -sfv /usr/local/lib/nss_sss.so ${NAS4FREE_ROOTFS}/usr/local/lib/nss_sss.so.1
	${CP} -v ${WRKSRC}/.libs/nss_sss.so.2 ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/nss_sss.so.2.0.0 ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/pam_sss.so ${NAS4FREE_ROOTFS}/usr/local/lib/
	${CP} -v ${WRKSRC}/.libs/memberof.so ${NAS4FREE_ROOTFS}/usr/local/lib/shared-modules/ldb/
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
	${CP} -v ${WRKSRC}/.libs/libsss_krb5.so ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
	${CP} -v ${WRKSRC}/.libs/libsss_ldap.so ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
	${CP} -v ${WRKSRC}/.libs/libsss_proxy.so ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
	${CP} -v ${WRKSRC}/.libs/libsss_simple.so ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/

	${CP} /usr/local/lib/libldb.so.1 ${NAS4FREE_ROOTFS}/usr/local/lib/
	${LN} -sfv /usr/local/lib/libldb.so.1 ${NAS4FREE_ROOTFS}/usr/local/lib/libldb.so

	### ManPages
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man1
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man5
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man8

	for I in ${MANS}; \
		do (rm -f ${WRKSRC}/src/man/$$I.gz; gzip -c ${WRKSRC}/src/man/$$I >${WRKSRC}/src/man/$$I.gz;); \
	done

	for I in ${MAN.1}; \
		do ($(INSTALL_DATA) ${WRKSRC}/src/man/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/$$I.gz;); \
	done

	for I in ${MAN.5}; \
		do ($(INSTALL_DATA) ${WRKSRC}/src/man/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man5/$$I.gz;); \
	done

	for I in ${MAN.8}; \
		do ($(INSTALL_DATA) ${WRKSRC}/src/man/$$I.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8/$$I.gz;); \
	done

	for I in ${MANS}; \
		do (rm -f ${WRKSRC}/src/man/$$I.gz;); \
	done

	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/etc/dbus-1/system.d/
	${CP} -v ${WRKSRC}/src/responder/ifp/org.freedesktop.sssd.infopipe.conf ${NAS4FREE_ROOTFS}/usr/local/etc/dbus-1/system.d/org.freedesktop.sssd.infopipe.conf
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/etc/sssd/
	${CP} -v ${WRKSRC}/src/examples/sssd-example.conf ${NAS4FREE_ROOTFS}/usr/local/etc/sssd/sssd.conf.sample

	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/include/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/libdata/pkgconfig/
	${CP} -v ${WRKSRC}/src/providers/ipa/ipa_hbac.h ${NAS4FREE_ROOTFS}/usr/local/include/
	${CP} -v ${WRKSRC}/src/providers/ipa/ipa_hbac.pc ${NAS4FREE_ROOTFS}/usr/local/libdata/pkgconfig/
	${CP} -v ${WRKSRC}/src/lib/idmap/sss_idmap.h ${NAS4FREE_ROOTFS}/usr/local/include/
	${CP} -v ${WRKSRC}/src/lib/idmap/sss_idmap.pc ${NAS4FREE_ROOTFS}/usr/local/libdata/pkgconfig/
	${CP} -v ${WRKSRC}/src/sss_client/idmap/sss_nss_idmap.h ${NAS4FREE_ROOTFS}/usr/local/include/
	${CP} -v ${WRKSRC}/src/sss_client/idmap/sss_nss_idmap.pc ${NAS4FREE_ROOTFS}/usr/local/libdata/pkgconfig/

	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/modules/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/doc/sssd/doc/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/doc/sssd/hbac_doc/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/doc/sssd/idmap_doc/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/doc/sssd/libsss_sudo_doc/
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/doc/sssd/nss_idmap_doc/

.for FILE in libsss_nss_idmap.so.0 libsss_nss_idmap.so.0.0.1 libsss_idmap.so.0.4.0
	${CP} -v ${WRKSRC}/.libs/${FILE} ${NAS4FREE_ROOTFS}/usr/local/lib/
.endfor

.for FILE in libsss_child.so libsss_crypt.so libsss_debug.so libsss_util.so libsss_ldap_common.so libsss_krb5_common.so
	${CP} -v ${WRKSRC}/.libs/${FILE} ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
.endfor

	${LN} -sfv /usr/local/lib/libsss_nss_idmap.so ${NAS4FREE_ROOTFS}/usr/local/lib/libsss_nss_idmap.so.0.0.1

.include "${MASTERDIR}/Makefile"
