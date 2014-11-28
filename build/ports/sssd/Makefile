# Created by: Lukas Slebodnik <lukas.slebodnik@intrak.sk>
# $FreeBSD: head/security/sssd/Makefile 358784 2014-06-22 10:44:29Z tijl $

PORTNAME=		sssd
DISTVERSION=	1.9.6

COMMENT=		System Security Services Daemon

MASTERDIR=	/usr/ports/security/sssd

STAGEDIR=	${NAS4FREE_ROOTFS}

CONFIGURE_ARGS+= --sysconfdir=/var/etc/${PORTNAME}

MAN.1=	sss_ssh_authorizedkeys.1 sss_ssh_knownhostsproxy.1
MAN.5= sssd-ad.5 sssd-ipa.5 sssd-krb5.5 sssd-ldap.5 sssd-simple.5 sssd-sudo.5 sssd.conf.5
MAN.8= pam_sss.8 sss_cache.8 sss_debuglevel.8 sss_groupadd.8 sss_groupdel.8 sss_groupmod.8 \
	sss_groupshow.8 sss_obfuscate.8 sss_seed.8 sss_useradd.8 sss_userdel.8 sss_usermod.8 sssd.8 \
	sssd_krb5_locator_plugin.8

MANS= ${MAN.1} ${MAN.5} ${MAN.8}

SBIN_FILES= sss_cache sss_debuglevel sss_groupadd sss_groupdel \
		sss_groupmod sss_groupshow sss_seed sss_useradd sss_userdel sss_usermod sssd

LIBEXEC_FILES= krb5_child ldap_child proxy_child sssd_be sssd_nss sssd_pam sssd_ssh sssd_sudo

post-install:
	${ECHO} "Do nothing"

do-install:
	@${INSTALL_SCRIPT} -v ${.CURDIR}/files/sssd.in ${NAS4FREE_ROOTFS}/etc/rc.d/sssd

.for FILE in ${SBIN_FILES}
	${INSTALL_PROGRAM} -v ${WRKSRC}/${FILE} ${NAS4FREE_ROOTFS}/usr/local/sbin/
.endfor
	
	${INSTALL_SCRIPT} -v ${WRKSRC}/src/tools/sss_obfuscate ${NAS4FREE_ROOTFS}/usr/local/sbin/

	${INSTALL_PROGRAM} -v ${WRKSRC}/sss_ssh_authorizedkeys ${NAS4FREE_ROOTFS}/usr/local/bin/
	${INSTALL_PROGRAM} -v ${WRKSRC}/sss_ssh_knownhostsproxy ${NAS4FREE_ROOTFS}/usr/local/bin/

	## Copy python package
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/SSSDConfig/
	${CP} ${WRKSRC}/src/config/SSSDConfig/__init__.py ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/SSSDConfig/
	${CP} ${WRKSRC}/src/config/SSSDConfig/ipachangeconf.py ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/SSSDConfig/
	${CP} ${WRKSRC}/src/config/SSSDConfig/sssd_upgrade_config.py ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/SSSDConfig/
	${CP} ${WRKSRC}/.libs/pyhbac.so  ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/
	${CP} ${WRKSRC}/.libs/pysss.so ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/
	${CP} ${WRKSRC}/.libs/pysss_murmur.so ${NAS4FREE_ROOTFS}/usr/local/lib/python${PYTHON_VER}/
	
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/libexec/sssd/
	${INSTALL_PROGRAM} -v ${WRKSRC}/sssd ${NAS4FREE_ROOTFS}/usr/local/libexec/sssd/
	
	${MKDIR} -p /usr/local/share/sssd/
	
.for DIR in /usr/local/lib/shared-modules/ldb/ /usr/local/share/xml/ /usr/local/share/xsl/ /usr/local/lib/ldb/
	${MKDIR} -p ${NAS4FREE_ROOTFS}${DIR}
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
	${CP} -v ${WRKSRC}/.libs/libsss_ad.so ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
	${CP} -v ${WRKSRC}/.libs/libsss_ipa.so ${NAS4FREE_ROOTFS}/usr/local/lib/sssd/
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

.include "${MASTERDIR}/Makefile"
